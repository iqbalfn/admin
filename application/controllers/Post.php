<?php

if(!defined('BASEPATH'))
    die;

class Post extends MY_Controller
{
    function __construct(){
        parent::__construct();
        
    }
    
    private function _schemaPostBreadcrumb($post){
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
                )
            )
        );
        
        if(!property_exists($post, 'category')){
            $breadcs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => 2,
                'item' => array(
                    '@id' => base_url('/#post'),
                    'name' => 'Post'
                )
            );
            return $breadcs;
        }
        
        $categories = prop_as_key($post->category, 'id');
        ksort($categories);
        $last_category = end($categories);
        $desc_breads = array($last_category);
        while(array_key_exists($last_category->parent, $categories)){
            $last_category = $categories[$last_category->parent];
            $desc_breads[] = $last_category;
        }
        krsort($desc_breads);
        $index = 1;
        foreach($desc_breads as $cat){
            $index++;
            $breadcs['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $index,
                'item' => array(
                    '@id' => base_url($cat->page),
                    'name' => hs($cat->name)
                )
            );
        }
        
        return $breadcs;
    }
    
    private function _schemaAmp($post){
        $meta_title = $post->seo_title->clean();
        if(!$meta_title)
            $meta_title = $post->title->clean();
        
        $meta_description = $post->seo_description->clean();
        if(!$meta_description)
            $meta_description = $post->content->chars(160);
        
        $meta_name  = $this->setting->item('site_name');
        $meta_url   = base_url($post->page);
        
        if(!$post->seo_schema->value)
            $post->seo_schema->value = 'Article';
        
        if(!in_array($post->seo_schema->value, array('Article', 'NewsArticle')))
            $post->seo_schema->value = 'Article';
        
        $schemas = array();
        $image_file = dirname(BASEPATH) . $post->cover->value;
        if(is_file($image_file)){
            list($img_width, $img_height) = getimagesize($image_file);
            
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $post->seo_schema->value,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'author'        => array(
                    '@type'         => 'Person',
                    'name'          => $post->user->fullname,
                    'url'           => base_url($post->user->page)
                ),
                'image'         => array(
                    '@type'         => 'ImageObject',
                    'url'           => $post->cover,
                    'height'        => $img_height,
                    'width'         => $img_width
                ),
                'headline'      => $meta_title,
                'url'           => $meta_url,
                'keywords'      => $post->seo_keywords,
                'mainEntityOfPage' => array(
                    '@type'         => 'WebPage',
                    '@id'           => $meta_url
                ),
                'publisher'     => array(
                    '@type'         => 'Organization',
                    'name'          => $meta_name,
                    'logo'          => array(
                        '@type'         => 'ImageObject',
                        'url'           => $this->theme->asset('/static/image/logo/logo-200x60.png'),
                        'width'         => 200,
                        'height'        => 60
                    )
                ),
                'datePublished' => $post->published->format('c'),
                'dateModified'  => $post->updated->format('c'),
                'dateCreated'   => $post->created->format('c')
            );
        }
        
        $schemas[] = $this->_schemaPostBreadcrumb($post);
        
        return $schemas;
    }
    
    private function _schemaCategory($category){
        $meta_title = $category->seo_title->clean();
        if(!$meta_title)
            $meta_title = $category->name->clean();
        $meta_description = $category->seo_description->clean();
        if(!$meta_description)
            $meta_description = $category->description->chars(160);
        
        $schemas = array();
        
        if($category->seo_schema->value){
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $category->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'image'         => $this->theme->asset('/static/image/logo/logo.png'),
                'url'           => base_url($category->page),
                'keywords'      => $category->seo_keywords,
                'datePublished' => $category->created->format('c'),
                'dateCreated'   => $category->created->format('c')
            );
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
                        '@id' => base_url('/#post'),
                        'name' => 'Post'
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => array(
                        '@id' => base_url('/#post/category'),
                        'name' => 'Category'
                    )
                )
            )
        );
        
        $schemas[] = $breadcs;
        
        return $schemas;
    }
    
    private function _schemaPost($post){
        $meta_title = $post->seo_title->clean();
        if(!$meta_title)
            $meta_title = $post->title->clean();
        
        $meta_description = $post->seo_description->clean();
        if(!$meta_description)
            $meta_description = $post->content->chars(160);
            
        $meta_keywords = $post->seo_keywords;
        $meta_image = $post->cover;
        $meta_name  = $this->setting->item('site_name');
        $meta_url   = base_url($post->page);
        
        if(!$post->seo_schema->value)
            $post->seo_schema->value = 'Article';
        
        // fuck get image sizes
        $image_file = dirname(BASEPATH) . $meta_image->value;
        if(is_file($image_file)){
            list($img_width, $img_height) = getimagesize($image_file);
            
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $post->seo_schema->value,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'author'        => array(
                    '@type'         => 'Person',
                    'name'          => $post->user->fullname,
                    'url'           => base_url($post->user->page)
                ),
                'image'         => array(
                    '@type'         => 'ImageObject',
                    'url'           => $meta_image,
                    'height'        => $img_height,
                    'width'         => $img_width
                ),
                'headline'      => $meta_title,
                'url'           => $meta_url,
                'keywords'      => $meta_keywords,
                'mainEntityOfPage' => array(
                    '@type'         => 'WebPage',
                    '@id'           => $meta_url
                ),
                'publisher'     => array(
                    '@type'         => 'Organization',
                    'name'          => $meta_name,
                    'logo'          => array(
                        '@type'         => 'ImageObject',
                        'url'           => $this->theme->asset('/static/image/logo/logo-200x60.png'),
                        'width'         => 200,
                        'height'        => 60
                    )
                ),
                'datePublished' => $post->published->format('c'),
                'dateModified'  => $post->updated->format('c'),
                'dateCreated'   => $post->created->format('c')
            );
        }
        
        $schemas[] = $this->_schemaPostBreadcrumb($post);
        return $schemas;
    }
    
    private function _schemaTag($tag){
        $meta_title = $tag->seo_title->clean();
        if(!$meta_title)
            $meta_title = $tag->name->clean();
        
        $meta_description = $tag->seo_description->clean();
        if(!$meta_description)
            $meta_description = $tag->description->chars(160);
        
        $schemas = array();
        
        if($tag->seo_schema->value){
            $data = array(
                '@context'      => 'http://schema.org',
                '@type'         => $tag->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'image'         => $this->theme->asset('/static/image/logo/logo.png'),
                'url'           => base_url($tag->page),
                'keywords'      => $tag->seo_keywords,
                'datePublished' => $tag->created->format('c'),
                'dateCreated'   => $tag->created->format('c')
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
                        '@id' => base_url('/#post'),
                        'name' => 'Post'
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => array(
                        '@id' => base_url('/#post/tag'),
                        'name' => 'Tag'
                    )
                )
            )
        );
        
        $schemas[] = $breadcs;
        
        return $schemas;
    }
    
    public function amp($slug=null){
        if(!$slug || !$this->setting->item('amphtml_support_for_post'))
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
        $this->load->library('Camp/Camp', '', 'camp');
        
        $params = [];
        
        $post = $this->Post->getBy('slug', $slug);
        if(!$post || $post->status != 4)
            return $this->show_404();
        
        if(!is_dev())
            $this->output->cache((60*60*5));
        
        $post = $this->formatter->post($post, false, true);
        $post->schema = $this->_schemaAmp($post);
        
        $amp_options = [];
        $amp_text = $post->content . '<p>' . $post->embed . '</p>';
        $amp = $this->camp->convert($amp_text, $amp_options);
        
        $post->components  = $amp->components;
        $post->amp_content = $amp->amp;
        
        $params['post'] = $post;
        
        $view = 'post/amp';
        $this->respond($view, $params);
    }
    
    public function category($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $params = array(
            'posts' => array(),
            'pagination' => array()
        );
        
        $category = $this->PCategory->getBy('slug', $slug);
        if(!$category)
            return $this->show_404();
        
        $category = $this->formatter->post_category($category, false, false);
        $category->schema = $this->_schemaCategory($category);
        $params['category'] = $category;
        
        // posts
        $cond = array(
            'status' => 4,
            'category' => $category->id
        );
        
        $rpp = 12;
        $page = $this->input->get('page');
        if(!$page)
            $page = 1;
        
        if(!is_dev() && $page == 1)
            $this->output->cache((60*60*5));
        
        $posts = $this->Post->findByCond($cond, $rpp, $page);
        if($posts)
            $params['posts'] = $this->formatter->post($posts);
        
        $total_result = $this->Post->findByCondTotal($cond);
        if($total_result > $rpp){
            $pagination_cond = $cond;
            
            unset($pagination_cond['category']);
            unset($pagination_cond['status']);
            
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $view = 'post/category/single';
        if($this->theme->exists('post/category/single-' . $category->slug))
            $view = 'post/category/single-' . $category->slug;
        
        $this->respond($view, $params);
    }
    
    public function categoryFeed($slug=null){
        $pages = array();
        $last_update = 0;
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Postcategory_model', 'PCategory');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $category = $this->PCategory->getBy('slug', $slug);
        if(!$category)
            return $this->show_404();
        
        if(!is_dev())
            $this->output->cache((60*60*5));
        
        $category = $this->formatter->post_category($category, false, false);
        
        // POSTS
        $cond = array(
            'status'    => 4,
            'category'  => $category->id
        );
        
        $posts = $this->Post->findByCond($cond, 100);
        
        if($posts){
            $posts = $this->formatter->post($posts, false, ['category']);
            foreach($posts as $post){
                $page = (object)array(
                    'page' => base_url($post->page),
                    'description' => $post->seo_description->value ? $post->seo_description : $post->content->chars(160),
                    'title' => $post->title,
                    'categories' => []
                );
                
                if(property_exists($post, 'category')){
                    foreach($post->category as $cat)
                        $page->categories[] = hs($cat->name);
                }
                
                $pages[] = $page;
                
                if($post->published->time > $last_update)
                    $last_update = $post->published->time;
            }
        }
        
        $this->output->set_header('Content-Type: application/xml');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        
        $params = array('pages' => $pages);
        
        $params['feed_url'] = base_url($category->page . '/feed.xml');
        $params['feed_title'] = hs($this->setting->item('site_name')) . ' &#187; Post &#187; Category &#187; ' . hs($category->name);
        $params['feed_owner_url'] = base_url($category->page);
        $params['feed_description'] = $category->seo_description->value ? $category->seo_description : $category->description;
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
    }
    
    public function feed($type='index'){
        $pages = array();
        $last_update = 0;
        
        if(!in_array($type, array('index', 'instant')))
            return $this->show_404();
        
        if($type == 'instant' && !$this->setting->item('instant_article_support_for_post'))
            return $this->show_404();
        
        if(!is_dev())
            $this->output->cache((60*60*5));
        
        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
        $this->load->library('Cinstant/Cinstant', '', 'cia');
        
        // POSTS
        $cond = array(
            'status'    => 4
        );
        if($type == 'instant')
            $cond['instant_content'] = NULL;
        
        $posts = $this->Post->getByCond($cond, 30, 1, ['updated'=>'DESC', 'published'=>'DESC']);

        if($posts){
            $posts = $this->formatter->post($posts, false, ['category', 'user']);
            foreach($posts as $post){
                $page = (object)array(
                    'page' => base_url($post->page),
                    'description' => $post->seo_description->value ? $post->seo_description : $post->content->chars(160),
                    'title' => $post->title,
                    'published' => $post->published->format('c'),
                    'author' => $post->user->fullname,
                    'categories' => []
                );
                
                // let create instant article content
                if($type == 'instant'){
                    if(!$post->instant_content){
                        $post->instant_content = $post->content->value;
                        if($post->embed)
                            $post->instant_content.= '<div>' . $post->embed . '</div>';
                    
                        $instant = $this->cia->convert($post->instant_content, ['localHost'=>base_url()]);
                        $post->instant_content = $instant->article;
                        $this->Post->set($post->id, ['instant_content'=>$post->instant_content]);
                    }
                    
                    $post->content = $post->instant_content;
                    $theme_file = $this->theme->current('/post/instant.php');
                    $page->content = $this->load->view($theme_file, ['post'=>$post], true);
                }
                
                if(property_exists($post, 'category')){
                    foreach($post->category as $cat)
                        $page->categories[] = hs($cat->name);
                }
                
                $pages[] = $page;
                
                if($post->published->time > $last_update)
                    $last_update = $post->published->time;
            }
        }
        
        $this->output->set_header('Content-Type: application/xml');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        
        $params = array('pages' => $pages);
        
        $params['feed_url'] = base_url('/post/feed.xml');
        $params['feed_title'] = hs($this->setting->item('site_name')) . ' &#187; Post';
        $params['feed_owner_url'] = base_url();
        $params['feed_description'] = $this->setting->item('site_frontpage_description');
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        $params['last_update'] = date('c', $last_update);
        
        $view = 'robot/feed';
        if($type == 'instant')
            $view = 'robot/feed-instant';
        
        $this->load->view($view, $params);
    }
    
    public function single($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $params = array();
        
        $post = $this->Post->getBy('slug', $slug);
        if(!$post || $post->status != 4)
            return $this->show_404();
        
        if(!is_dev())
            $this->output->cache((60*60*5));
        
        $post = $this->formatter->post($post, false, true);
        $post->schema = $this->_schemaPost($post);
        $params['post'] = $post;
        
        $view = 'post/single';
        if($this->theme->exists('post/single-' . $post->slug))
            $view = 'post/single-' . $post->slug;
        
        $this->respond($view, $params);
    }
    
    public function tag($slug=null){
        if(!$slug)
            return $this->show_404();
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Posttag_model', 'PTag');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $params = array(
            'posts' => array(),
            'pagination' => array()
        );
        
        $tag = $this->PTag->getBy('slug', $slug);
        if(!$tag)
            return $this->show_404();
        
        $tag = $this->formatter->post_tag($tag, false, false);
        $tag->schema = $this->_schemaTag($tag);
        $params['tag'] = $tag;
        
        // posts
        $cond = array(
            'status' => 4,
            'tag' => $tag->id
        );
        
        $rpp = 12;
        $page = $this->input->get('page');
        if(!$page)
            $page = 1;
        
        if(!is_dev() && $page == 1)
            $this->output->cache((60*60*5));
        
        $posts = $this->Post->findByCond($cond, $rpp, $page);
        if($posts)
            $params['posts'] = $this->formatter->post($posts);
        
        $total_result = $this->Post->findByCondTotal($cond);
        if($total_result > $rpp){
            $pagination_cond = $cond;
            unset($pagination_cond['tag']);
            unset($pagination_cond['status']);
            $this->load->helper('pagination');
            $params['pagination'] = calculate_pagination($total_result, $page, $rpp, $pagination_cond);
        }
        
        $view = 'post/tag/single';
        if($this->theme->exists('post/tag/single-' . $tag->slug))
            $view = 'post/tag/single-' . $tag->slug;
        
        $this->respond($view, $params);
    }
    
    public function tagFeed($slug=null){
        $pages = array();
        $last_update = 0;
        
        $this->load->model('Post_model', 'Post');
        $this->load->model('Posttag_model', 'PTag');
        $this->load->library('ObjectFormatter', '', 'formatter');
        
        $tag = $this->PTag->getBy('slug', $slug);
        if(!$tag)
            return $this->show_404();
        
        if(!is_dev())
            $this->output->cache((60*60*5));
        
        $tag = $this->formatter->post_tag($tag, false, false);
        
        // POSTS
        $cond = array(
            'status'    => 4,
            'tag'  => $tag->id
        );
        
        $posts = $this->Post->findByCond($cond, 100);
        
        if($posts){
            $posts = $this->formatter->post($posts, false, ['category']);
            foreach($posts as $post){
                $page = (object)array(
                    'page' => base_url($post->page),
                    'description' => $post->seo_description->value ? $post->seo_description : $post->content->chars(160),
                    'title' => $post->title,
                    'categories' => []
                );
                
                if(property_exists($post, 'category')){
                    foreach($post->category as $cat)
                        $page->categories[] = hs($cat->name);
                }
                
                $pages[] = $page;
                
                if($post->published->time > $last_update)
                    $last_update = $post->published->time;
            }
        }
        
        $this->output->set_header('Content-Type: application/xml');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $last_update) . ' GMT');
        
        $params = array('pages' => $pages);
        
        $params['feed_url'] = base_url($tag->page . '/feed.xml');
        $params['feed_title'] = hs($this->setting->item('site_name')) . ' &#187; Post &#187; Tag &#187; ' . hs($tag->name);
        $params['feed_owner_url'] = base_url($tag->page);
        $params['feed_description'] = $tag->seo_description->value ? $tag->seo_description : $tag->description;
        $params['feed_image_url'] = $this->theme->asset('/static/image/logo/feed.jpg');
        
        $this->load->view('robot/feed', $params);
    }
}