<?php

if(!defined('BASEPATH'))
    die;

/**
 * The `Media` controller
 */
class Media extends MY_Controller
{

    function __construct(){
        parent::__construct();

        $this->load->model('Gallerymedia_model', 'GMedia');
        $this->load->model('Gallery_model', 'Gallery');
        $this->load->library('ObjectFormatter','','formatter');
    }
    
    private function _removePostCache($gallery){
        $this->load->model('Post_model', 'Post');

        $posts = $this->Post->getBy('gallery', $gallery, true);
        
        if($posts){
            $posts = $this->formatter->post($posts, false, false);
            
            // remove posts cache
            foreach($posts as $post)
                $this->output->delete_cache($post->page);
        }
    }

    public function edit($id=null, $gallery=null){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$id && !$this->can_i('create-gallery_media'))
            return $this->show_404();
        if($id && !$this->can_i('update-gallery_media'))
            return $this->show_404();
        
        $album = $this->Gallery->get($gallery);
        if(!$album)
            return $this->show_404();

        $this->load->library('SiteForm', '', 'form');

        $params = ['album' => $album];

        if($id){
            $object = $this->GMedia->get($id);
            if(!$object)
                return $this->show_404();
            $params['title'] = _l('Edit Media');
        }else{
            $object = (object)array();
            $params['title'] = _l('Create New Media');
        }

        $this->form->setObject($object);
        $this->form->setForm('/admin/gallery/media');

        $params['media'] = $object;

        if(!($new_object=$this->form->validate($object)))
            return $this->respond('gallery/media/edit', $params);

        if($new_object === true)
            return $this->redirect('/admin/gallery/' . $gallery . '/media');

        if(!$id){
            $new_object['user'] = $this->user->id;
            $new_object['gallery'] = $gallery;
            $new_object['id'] = $this->GMedia->create($new_object);
            
            $this->event->gallery_media->created($new_object);
        }else{
            $this->GMedia->set($id, $new_object);
            
            $this->event->gallery_media->updated($object, $new_object);
            $this->_removePostCache($object->gallery);
        }

        $this->redirect('/admin/gallery/' . $gallery . '/media');
    }

    public function index($gallery){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('read-gallery_media'))
            return $this->show_404();
        
        $album = $this->Gallery->get($gallery);
        if(!$album)
            return $this->show_404();
        $album = $this->formatter->gallery($album, false, false);
        
        $albums = $this->Gallery->getByCond([], 7);
        if(!$albums)
            return $this->show_404();
            
        $albums = $this->formatter->gallery($albums, true);
        
        $params = array(
            'title' => _l('Album') . ' `' . $album->name . '`',
            'media' => [],
            'albums' => $albums,
            'album' => $album
        );

        $cond = array('gallery'=>$gallery);
        $result = $this->GMedia->getByCond($cond, true);
        if($result)
            $params['media'] = $this->formatter->gallery_media($result);
        
        $this->respond('gallery/media/index', $params);
    }

    public function remove($id, $gallery){
        if(!$this->user)
            return $this->redirect('/admin/me/login?next=' . uri_string());
        if(!$this->can_i('delete-gallery_media'))
            return $this->show_404();
        
        $this->event->gallery_media->deleted($id, $gallery);
        $this->_removePostCache($gallery);

        $this->GMedia->remove($id);
        $this->redirect('/admin/gallery/' . $gallery . '/media');
    }
}