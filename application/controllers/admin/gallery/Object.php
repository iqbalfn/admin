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

        $this->load->library('ObjectFormatter', '', 'formatter');
        $this->load->model('Gallerymedia_model', 'GMedia');
        $this->load->model('Gallery_model', 'Gallery');
    }
    
    private function _removePostCache($gallery, $update_post=false){
        $this->load->model('Post_model', 'Post');

        $posts = $this->Post->getBy('gallery', $gallery, true);
        
        if($posts){
            if($update_post){
                $posts_id = prop_values($posts, 'id');
                $this->Post->set($posts_id, ['gallery'=>null]);
            }
            
            $posts = $this->formatter->post($posts, false, false);
            
            // remove posts cache
            foreach($posts as $post)
                $this->output->delete_cache($post->page);
        }
    }

    public function edit($id=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-gallery'))
            return $this->show_404();
        if($id && !$this->can_i('update-gallery'))
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = [];

        if($id){
            $object = $this->Gallery->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Gallery Album');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Gallery Album');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/gallery');

        $params['album'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('gallery/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/gallery');

        if(!$id){
            $new_object['user'] = $this->user->id;
            $new_object['id'] = $this->Gallery->create($new_object);
            $this->event->gallery->created($new_object);
        }else{
            $this->Gallery->set($id, $new_object);
            $this->event->gallery->updated($object, $new_object);
            $this->_removePostCache($object->id);
        }

        $this->redirect('/admin/gallery');
    }

    public function index(){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-gallery'))
            return $this->show_404();

        $params = array(
            'title' => _l('Galleries'),
            'albums' => []
        );

        $cond = array();

        $rpp = true;
        $page= false;

        $result = $this->Gallery->getByCond($cond, $rpp, $page, ['name'=>'ASC']);
        if($result)
            $params['albums'] = $this->formatter->gallery($result);
        
        $this->respond('gallery/index', $params);
    }

    public function remove($id){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-gallery'))
            return $this->show_404();
        
        $this->_removePostCache($id, true);
        $this->event->gallery->removed($id);

        $this->Gallery->remove($id);
        $this->GMedia->removeBy('gallery', $id);
        $this->redirect('/admin/gallery');
    }
}