<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Object` controller
 */
class Object extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
    }

    function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-post'))
            return $this->show_404();
        if($id && !$this->can_i('update-post'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->model('Postcategorychain_model', 'PCChain');
        $this->load->model('Posttag_model', 'PTag');
        $this->load->model('Posttagchain_model', 'PTChain');
        $this->load->model('Gallery_model', 'Gallery');
        $this->load->model('Postschedule_model', 'PSchedule');
        
        $post_scheduled = false;
        
        $params = array(
            'slug_editable' => true,
            'reporter' => null
        );
        
        if($id){
            $object = $this->Post->get($id);
            if(!$object)
                return $this->show_404();
            
            // allow user to edit other user posts only if he's allowed to do so.
            if($object->user != $this->user->id && !$this->can_i('update-post_other_user'))
                return $this->show_404();
            
            $params['title'] = _l('Edit Post');
            
            $object_categories = $this->PCChain->getBy('post', $id, true);
            $object->category = $object_categories ? prop_values($object_categories, 'post_category') : array();
            $object_tags = $this->PTChain->getBy('post', $id, true);
            $object->tag = $object_tags ? prop_values($object_tags, 'post_tag') : array();
            
            if(!$this->can_i('update-post_slug'))
                $params['slug_editable'] = false;
            
            if($object->user != $this->user->id){
                $reporter = $this->User->get($object->user);
                if($reporter)
                    $params['reporter'] = $this->formatter->user($reporter);
            }
        }else{
            $object = (object)array('status' => 1);
            if($this->can_i('read-post_category'))
                $object->category = [];
            if($this->can_i('read-post_tag'))
                $object->tag = [];
                
            $params['title'] = _l('Create New Post');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/post');

        $params['post'] = $object;
        
        if($this->can_i('read-post_category')){
            $all_categories = array();
            
            $categories = $this->PCategory->getByCond([], true, false, ['name'=>'ASC']);
            if($categories){
                $all_categories = $this->formatter->post_category($categories, 'id', false);
                $categories = group_by_prop($categories, 'parent');
            }
            $params['categories'] = $categories ? $categories : array();
        }
        
        $chain_multiple_fields_set = array(
            'tag'    => [ 'read-post_tag',  'tags',     'PTag', 'name' ]
        );
        
        foreach($chain_multiple_fields_set as $prop => $rules){
            $perm  = $rules[0];
            $vars  = $rules[1];
            $model = $rules[2];
            $label = $rules[3];
            
            $params[$vars] = array();
            $posted_data = $this->input->post($prop);
            
            if(!$this->can_i($perm) || (!$object->$prop && !$posted_data))
                continue;
            
            if(!$posted_data)
                $posted_data = $object->$prop;
            if($posted_data){
                $visible_objs  = $this->$model->get($posted_data, true);
                if($visible_objs)
                    $params[$vars] = prop_as_key($visible_objs, 'id', $label);
            }
        }
        
        if($this->can_i('read-gallery')){
            $params['galleries'] = array();
            if(property_exists($object, 'gallery') && $object->gallery){
                $gallery = $this->Gallery->get($object->gallery);
                if($gallery)
                    $params['galleries'] = array( $object->gallery => $gallery->name );
            }else{
                $galleries = $this->Gallery->getByCond([], 10);
                if($galleries)
                    $params['galleries'] = prop_as_key($galleries, 'id', 'name');
            }
        }
        
        $statuses = $this->enum->item('post.status');
        if(!$this->can_i('create-post_published')){
            unset($statuses[4]);
            unset($statuses[3]);
        }
        $params['statuses'] = $statuses;
        
        if(!($new_object=$this->form->validate($object)))
            return $this->respond('post/edit', $params);
        
        if($new_object === true)
            return $this->redirect('/admin/post');
        
        // remove instant article
        if(array_key_exists('content', $new_object))
            $new_object['instant_content'] = NULL;
        
        // make sure user not publish it if user not allowed to publish it
        // or set the published property if it's published
        if(array_key_exists('status', $new_object)){
            if(in_array($new_object['status'], [3,4])){
                if($this->can_i('create-post_published')){
                    if($new_object['status'] == 4){
                        $new_object['published'] = date('Y-m-d H:i:s');
                        $new_object['publisher'] = $this->user->id;
                        
                    // add the post to post_schedule to be listed on
                    // publish later post
                    }else{
                        $post_scheduled = $new_object['published'];
                        $new_object['publisher'] = $this->user->id;
                    }
                    if($id)
                        $this->PSchedule->removeBy('post', $id);
                }else{
                    unset($new_object['status']);
                    if(array_key_exists('published', $new_object))
                        unset($new_object['published']);
                }
            }
        }elseif(array_key_exists('published', $new_object) && $object->status == 3){
            if($this->can_i('create-post_published')){
                $post_scheduled = $new_object['published'];
                if($id)
                    $this->PSchedule->removeBy('post', $id);
            }else{
                unset($new_object['published']);
            }
        }
        
        // make sure user not change the slug if he's not allowed
        if($id && array_key_exists('slug', $new_object) && !$this->can_i('update-post_slug'))
            unset($new_object['slug']);
        
        $chain_to_insert = array(
            'PCChain'  => [ 'rows' => [], 'prop' => 'post_category' ],
            'PTChain'  => [ 'rows' => [], 'prop' => 'post_tag' ]
        );
        $save_chains = array(
            'category'  => [ 'PCategory',   'PCChain',  'posts',    'post_category',    'read-post_category' ],
            'tag'       => [ 'PTag',        'PTChain',  'posts',    'post_tag',         'read-post_tag' ]
        );
        foreach($save_chains as $prop => $rules){
            if(!array_key_exists($prop, $new_object))
                $new_object[$prop] = array();
            
            $new_objs = $new_object[$prop];
            unset($new_object[$prop]);
            
            $model = $rules[0];
            $chain = $rules[1];
            $dienc = $rules[2];
            $format= $rules[3];
            $perms = $rules[4];
            
            if(!$this->can_i($perms))
                continue;
            
            $old_objs = [];
            if($id)
                $old_objs = $object->$prop;
            
            $obj_to_delete = array();
            $obj_to_insert = array();
            $obj_effected  = array();
            
            foreach($new_objs as $obj){
                if(in_array($obj, $old_objs))
                    continue;
                $obj_effected[] = $obj;
                $obj_to_insert[] = $obj;
            }
            
            foreach($old_objs as $obj){
                if(in_array($obj, $new_objs))
                    continue;
                $obj_effected[] = $obj;
                $obj_to_delete[]= $obj;
            }
            
            if($dienc){
                if($obj_to_delete)
                    $this->$model->dec($obj_to_delete, $dienc, 1, true);
                if($obj_to_insert)
                    $this->$model->inc($obj_to_insert, $dienc, 1, true);
            }
            
            $chain_to_insert[$chain]['rows'] = $obj_to_insert;
            
            if($obj_effected){
                $obj_effected = $this->$model->get($obj_effected, true);
                if($obj_effected){
                    $obj_effected = $this->formatter->$format($obj_effected, false, false);
                    foreach($obj_effected as $obj){
                        $this->output->delete_cache($obj->page);
                        $this->output->delete_cache($obj->page . '/feed.xml');
                    }
                }
            }
            
            if($obj_to_delete)
                $this->$chain->removeByCond(['post' => $id, $format => $obj_to_delete]);
        }
        
        $this->output->delete_cache('/post/feed.xml');
        $this->output->delete_cache('/post/instant.xml');
        
        if($id){
            $fobject = $this->formatter->post($object, false, false);
            $this->output->delete_cache($fobject->page);
            $this->output->delete_cache($fobject->amp);
        }
        
        if($new_object){
            $new_object['updated'] = date('Y-m-d H:i:s');
            if(!$id){
                $new_object['user'] = $this->user->id;
                $new_object['id'] = $this->Post->create($new_object);
                $id = $new_object['id'];
                
                $this->event->post->created($new_object);
            }else{
                $this->Post->set($id, $new_object);
                
                $this->event->post->updated($object, $new_object);
            }
            
            if($post_scheduled){
                $post_scheduled = (object)array(
                    'post' => $id,
                    'published' => $post_scheduled
                );
                $this->PSchedule->removeBy('post', $post_scheduled->post);
                $this->PSchedule->create($post_scheduled);
            }
        }
        
        if($id){
            foreach($chain_to_insert as $model => $data){
                if(!count($data['rows']))
                    continue;
                $new_data = array();
                foreach($data['rows'] as $obj)
                    $new_data[] = array( 'post' => $id, $data['prop'] => $obj );
                $this->$model->create_batch($new_data);
            }
        }
        
        $this->redirect('/admin/post');
    }

    function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-post'))
            return $this->show_404();

        $params = array(
            'title' => _l('Posts'),
            'posts' => [],
            'categories' => array(),
            'tag' => null,
            'statuses' => $this->enum->item('post.status'),
            'pagination' => array(),
            'user' => null
        );

        $cond = array();

        $args = ['q','tag','category','status','user'];
        foreach($args as $arg){
            $arg_val = $this->input->get($arg);
            if($arg_val)
                $cond[$arg] = $arg_val;
        }
        
        if(!$this->can_i('read-post_other_user'))
            $cond['user'] = $this->user->id;
        elseif(array_key_exists('user', $cond))
            $params['user'] = $this->User->get($cond['user']);
        
        if(array_key_exists('tag', $cond)){
            $this->load->model('Posttag_model', 'PTag');
            $params['tag'] = $this->PTag->get($cond['tag']);
        }
        
        if($this->can_i('read-post_category')){
            $this->load->model('Postcategory_model', 'PCategory');
            $all_categories = $this->PCategory->getByCond([], true);
            $params['categories'] = $all_categories;
        }
        
        $rpp = 20;
        $page= $this->input->get('page');
        if(!$page)
            $page = 1;

        $result = $this->Post->findByCond($cond, $rpp, $page, ['updated'=>'DESC', 'published'=>'DESC']);
        if($result)
            $params['posts'] = $this->formatter->post($result, false, false);

        $total_result = $this->Post->findByCondTotal($cond);
        if($total_result > $rpp){
            $pagination_cond = $cond;
            if(array_key_exists('q', $cond))
                $pagination_cond['q'] = $cond['q'];
            
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $this->respond('post/index', $params);
    }

    function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-post'))
            return $this->show_404();
        
        $post = $this->Post->get($id);
        if(!$post)
            return $this->show_404();

        if($post->user != $this->user->id && !$this->can_i('delete-post_other_user'))
            return $this->show_404();
        
        $this->load->model('Postcategorychain_model', 'PCChain');
        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->model('Posttagchain_model', 'PTChain');
        $this->load->model('Posttag_model', 'PTag');
        $this->load->model('Postselection_model', 'PSelection');
        $this->load->model('Poststatistic_model', 'PStatistic');
        
        $this->Post->remove($id);
        
        // list of chains to be removed
        $remove_chains = array(
            'tag'       => [ 'PTag',        'PTChain',  'posts',    'post_tag'  ],
            'category'  => [ 'PCategory',   'PCChain',  'posts',    'post_category' ]
        );
        
        foreach($remove_chains as $tag => $props){
            $model = $props[0];
            $chain = $props[1];
            $decc  = $props[2];
            $format= $props[3];
        
            $chain_obj = $this->$chain->getBy('post', $id, true);
            if(!$chain_obj)
                continue;
            $chain_obj = $this->formatter->$format($chain_obj, false, false);
            foreach($chain_obj as $obj){
                if($decc)
                    $this->$model->dec($obj->$format, $decc, 1, true);
                $this->output->delete_cache($obj->page);
                $this->output->delete_cache($obj->page . '/feed.xml');
            }
            
            $this->$chain->removeBy('post', $id);
        }
        
        // remove post selection
        $post_selection = $this->PSelection->getBy('post', $post->id, true);
        if($post_selection){
            $this->cache->file->delete('post_selection');
            $this->PSelection->removeBy('post', $post->id);
        }
        
        // remove post trending
        $this->PStatistic->removeBy('post', $post->id);
        
        $this->event->post->deleted($post);
        
        $post = $this->formatter->post($post, false, false);
        
        $this->output->delete_cache($post->page);
        $this->output->delete_cache($post->amp);
        $this->output->delete_cache('/post/feed.xml');
        $this->output->delete_cache('/post/instant.xml');
        
        $this->redirect('/admin/post');
    }
}