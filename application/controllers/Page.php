<?php

if(!defined('BASEPATH'))
    die;

class Page extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    private function _schemaPage($page){
        $schemas = array();
        
        $meta_title = $page->seo_title->clean();
        if(!$meta_title)
            $meta_title = $page->title->clean();
        
        $meta_description = $page->seo_description->clean();
        if(!$meta_description)
            $meta_description = $page->content->chars(160);
        
        if($page->seo_schema->value){
            $data = array(
                '@context'      => 'http://schema.org',
                '@type'         => $page->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'url'           => base_url($page->page),
                'dateCreated'   => $page->created->format('c')
            );
            
            $schemas[] = $data;
        }
        
        $breadcs = array(
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => base_url(),
                        'name' => $this->setting->item('site_name')
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => base_url('/#page'),
                        'name' => 'Page'
                    )
                )
            )
        );
        
        $schemas[] = $breadcs;
        
        return $schemas;
    }
    
    public function single($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Page_model', 'Page');
        $page = $this->Page->getBy('slug', $slug);
        if(!$page)
            return $this->show_404();
        
        $params = array();
        
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $page = $this->formatter->page($page, false, false);
        $page->schema = $this->_schemaPage($page);
        $params['page'] = $page;
        
        $view = 'page/single';
        if($this->theme->exists('page/single-' . $page->slug))
            $view = 'page/single-' . $page->slug;
        
        $this->respond($view, $params);
    }
}