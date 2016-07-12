<?php

class SiteMeta
{
    private $CI;
    private $site_params;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    public function _ga($ga){
        $ga_code = $this->CI->setting->item('code_google_analytics');
        
        $tx = '';
        
        if($ga_code){
            $tx.= '<script>';
            $tx.=   '(function(i,s,o,g,r,a,m){';
            $tx.=   'i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
            $tx.=   '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
            $tx.=   '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';
            $tx.=   'ga(\'create\', \'' . $ga_code . '\', \'auto\');';
            if($ga){
                $ga_group = array_key_exists('group', $ga) ? $ga['group'] : '';
                $ga_index = array_key_exists('index', $ga) ? $ga['index'] : $this->CI->setting->item('google_analytics_content_group');
                if($ga_group)
                    $tx.= 'ga(\'set\', \'contentGroup' . $ga_index . '\', \'' . $ga_group . '\');';
            }
            $tx.=   'ga(\'send\', \'pageview\');';
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    private function _general($title=null, $metas=array(), $schemes=array(), $ga=array()){
        $tx = '<meta charset="utf-8">';
        $tx.= '<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">';
        if($this->CI->setting->item('site_theme_responsive'))
            $tx.= '<meta content="width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no" name="viewport">';
        $tx.= '<meta content="AdminCI" name="generator">';
        
        $google_code = $this->CI->setting->item('code_verification_google');
        if($google_code)
            $tx.= '<meta name="google-site-verification" content="' . $google_code . '">';
        
        $alexa_code = $this->CI->setting->item('code_verification_alexa');
        if($alexa_code)
            $tx.= '<meta name="alexaVerifyID" content="' . $alexa_code . '">';
        
        $bing_code = $this->CI->setting->item('code_verification_bing');
        if($bing_code)
            $tx.= '<meta name="msvalidate.01" content="' . $bing_code . '">';
        
        $pinterest_code = $this->CI->setting->item('code_verification_pinterest');
        if($pinterest_code)
            $tx.= '<meta name="p:domain_verify" content="' . $pinterest_code . '">';
        
        $yandex_code = $this->CI->setting->item('code_verification_yandex');
        if($yandex_code)
            $tx.= '<meta name="yandex-verification" content="' . $yandex_code . '">';
        
        $facebook_code = $this->CI->setting->item('code_application_facebook');
        if($facebook_code)
            $tx.= '<meta content="' . $facebook_code . '" property="fb:app_id">';
        
        $facebook_page_id = $this->CI->setting->item('code_facebook_page_id');
        if($facebook_page_id)
            $tx.= '<meta content="' . $facebook_page_id . '" property="fb:pages">';
        
        $tx.= '<meta property="og:site_name" content="' . $this->CI->setting->item('site_name') . '">';
        
        // additional metas
        $prop_or_name = array(
            'keywords' => 'name',
            'description' => 'name',
            'twitter:card' => 'name',
            'twitter:description' => 'name',
            'twitter:image:src' => 'name',
            'twitter:title' => 'name',
            'twitter:url' => 'name',
            'og:description' => 'property',
            'og:image' => 'property',
            'og:title' => 'property',
            'og:type' => 'property',
            'og:url' => 'property',
            'article:modified_time' => 'property',
            'article:publisher' => 'property',
            'article:section' => 'property',
            'article:published_time' => 'property',
            'article:section' => 'property',
            'article:tag' => 'property',
            'profile:username' => 'property',
            'profile:first_name' => 'property',
            'profile:last_name' => 'property'
        );
        foreach($metas as $name => $mets){
            $prop = 'name';
            if(array_key_exists($name, $prop_or_name))
                $prop = $prop_or_name[$name];
            if(is_array($mets)){
                foreach($mets as $met)
                    $tx.= '<meta ' . $prop . '="' . $name . '" content="' . $met . '">';
            }else{
                $tx.= '<meta ' . $prop . '="' . $name . '" content="' . $mets . '">';
            }
        }
        
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/shortcut-icon.png') . '" rel="shortcut icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon.png') . '" rel="apple-touch-icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-72x72.png') . '" rel="apple-touch-icon" sizes="72x72">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-114x114.png') . '" rel="apple-touch-icon" sizes="114x114">';
        
        $tx.= '<link href="' . base_url('feed.xml') . '" rel="alternate" title="' . $this->CI->setting->item('site_frontpage_title') . '" type="application/rss+xml">';
        
        $tx.= '<link href="' . base_url(uri_string()) . '" rel="canonical">';
        
        $tx.= $this->_ga($ga);
        
        if($title)
            $tx.= '<title>' . $title . ' - ' . $this->CI->setting->item('site_name') . '</title>';
        
        $data = array(
            '@context'      => 'http://schema.org',
            '@type'         => 'Website',
            'url'           => base_url(),
            'potentialAction' => array(
                '@type'         => 'SearchAction',
                'target'        => base_url('/search') . '?q={search_term_string}',
                'query-input'   => 'required name=search_term_string'
            )
        );
        
        $tx.= '<script type="application/ld+json">';
        $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
        $tx.= '</script>';
        foreach($schemes as $scheme){
            $tx.= '<script type="application/ld+json">';
            $tx.= json_encode($scheme, JSON_UNESCAPED_SLASHES);
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    private function _schemaBreadcrumb($links){
        $data = array(
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => array()
        );
        
        $index = 1;
        foreach($links as $id => $name){
            $data['itemListElement'][] = array(
                '@type' => 'ListItem',
                    'position' => $index,
                    'item' => array(
                        '@id' => $id,
                        'name' => $name
                    )
            );
            $index++;
        }
        
        return $data;
    }
    
    public function event_single($event){
        $meta_title = $event->seo_title->clean();
        if(!$meta_title)
            $meta_title = $event->name->clean();
        
        $meta_description = $event->seo_description->clean();
        if(!$meta_description)
            $meta_description = $event->content->chars(160);
        
        $page = $this->CI->input->get('page');
        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $meta_keywords = $event->seo_keywords;
        $meta_image = $event->cover;
        $meta_url   = base_url($event->page);
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "website",
            "og:url"                => $meta_url
        );
        
        $schemas = array();
        
        if(!$event->seo_schema->value)
            $event->seo_schema = 'Event';
        
        $schemas[] = array(
            '@context'      => 'http://schema.org',
            '@type'         => $event->seo_schema,
            'name'          => $meta_title,
            'description'   => $meta_description,
            'location'      => array(
                '@type'         => 'Place',
                'name'          => $event->name,
                'address'       => $event->address
            ),
            'image'         => $meta_image,
            'url'           => $meta_url,
            'keywords'      => $event->seo_keywords,
            'startDate'     => $event->date->format('c')
        );
        
        $schemas[] = $this->_schemaBreadcrumb([
            base_url() => $this->CI->setting->item('site_name')
        ]);
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
    
    public function footer(){
        $tx = '';
        
        if($this->CI->setting->item('theme_include_fb_js_api')){
            $fb_app_id = $this->CI->setting->item('code_application_facebook');
            $fb_ads_api= $this->CI->setting->item('theme_include_fb_js_api_with_ads');
            
            $tx.= '<script>';
            $tx.=   '(function(d,s,id){';
            $tx.=       'var js,fjs=d.getElementsByTagName(s)[0];';
            $tx.=       'if(d.getElementById(id)) return;';
            $tx.=       'js=d.createElement(s);js.id=id;js.src="';
            $tx.=       $fb_ads_api
                        ? '//connect.facebook.net/en_US/sdk/xfbml.ad.js#xfbml=1&version=v2.5&appId='
                        : '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=';
            $tx.=       $fb_app_id;
            $tx.=       '";fjs.parentNode.insertBefore(js,fjs);';
            $tx.=   '}(document,\'script\',\'facebook-jssdk\'));';
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    public function home($meta_title=null){
        if(!$meta_title)
            $meta_title = $this->CI->setting->item('site_frontpage_title');
        
        $meta_description = $this->CI->setting->item('site_frontpage_description');
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_image = $this->CI->theme->asset('/static/image/logo/logo.png');
        $meta_keywords = $this->CI->setting->item('site_frontpage_keywords');
        
        $page = $this->CI->input->get('page');
        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_name,
            "twitter:url"           => base_url(),
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_name,
            "og:type"               => "website",
            "og:url"                => base_url()
        );
        
        $schemas = array();
        
        $data = array(
            '@context'      => 'http://schema.org',
            '@type'         => 'Organization',
            'name'          => $this->CI->setting->item('site_name'),
            'url'           => base_url(),
            'logo'          => $this->CI->theme->asset('/static/image/logo/logo.png')
        );
        
        // social url
        $socials = array();
        $known_socials = array(
            'facebook',
            'gplus',
            'instagram',
            'linkedin',
            'myspace',
            'pinterest',
            'soundcloud',
            'tumblr',
            'twitter',
            'youtube'
        );
        foreach($known_socials as $soc){
            $url = $this->CI->setting->item('site_x_social_'.$soc);
            if($url)
                $socials[] = $url;
        }
        
        if($socials)
            $data['sameAs'] = $socials;
        
        // phone contact number
        $contacts = array();
        $known_contacts = array(
            'customer_support' => 'customer support',
            'technical_support' => 'technical support',
            'billing_support' => 'billing support',
            'bill_payment' => 'bill payment',
            'sales' => 'sales',
            'reservations' => 'reservations',
            'credit_card_support' => 'credit card support',
            'emergency' => 'emergency',
            'baggage_tracking' => 'baggage tracking',
            'roadside_assistance' => 'roadside assistance',
            'package_tracking' => 'package tracking'
        );
        $contact_served = $this->CI->setting->item('organization_contact_area_served');
        if($contact_served){
            $contact_served = explode(',', $contact_served);
            if(count($contact_served) == 1)
                $contact_served = $contact_served[0];
        }
        
        $contact_language = $this->CI->setting->item('organization_contact_available_language');
        if($contact_language){
            $contact_language = explode(',', $contact_language);
            if(count($contact_language) == 1)
                $contact_language = $contact_language[0];
        }
        
        $contact_options = array();
        if($this->CI->setting->item('organization_contact_opt_tollfree'))
            $contact_options[] = 'TollFree';
        if($this->CI->setting->item('organization_contact_opt_his'))
            $contact_options[] = 'HearingImpairedSupported';
        
        foreach($known_contacts as $cont => $name){
            $phone = $this->CI->setting->item('organization_contact_' . $cont);
            if(!$phone)
                continue;
            $contact = array(
                '@type' => 'ContactPoint',
                'telephone' => $phone,
                'contactType' => $name
            );
            if($contact_served)
                $contact['areaServed'] = $contact_served;
            if($contact_language)
                $contact['availableLanguage'] = $contact_language;
            if($contact_options)
                $contact['contactOption'] = $contact_options;
            $contacts[] = $contact;
        }
        
        if($contacts)
            $data['contactPoint'] = $contacts;
        
        $schemas[] = $data;
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
    
    public function page_single($page){
        $meta_title = $page->seo_title->clean();
        if(!$meta_title)
            $meta_title = $page->title->clean();
        
        $meta_description = $page->seo_description->clean();
        if(!$meta_description)
            $meta_description = $page->content->chars(160);
        
        $meta_keywords = $page->seo_keywords;
        $meta_image = $this->CI->theme->asset('/static/image/logo/logo.png');
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($page->page);
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "website",
            "og:url"                => $meta_url
        );
        
        $schemas = array();
        
        if($page->seo_schema->value){
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $page->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'url'           => base_url($page->page),
                'dateCreated'   => $page->created->format('c')
            );
        }
        
        $schemas[] = $this->_schemaBreadcrumb([
            base_url() => $meta_name
        ]);
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
    
    public function post_category_single($category){
        $meta_title = $category->seo_title->clean();
        if(!$meta_title)
            $meta_title = $category->name->clean();
        $meta_description = $category->seo_description->clean();
        if(!$meta_description)
            $meta_description = $category->description->chars(160);
        
        $page = (int)$this->CI->input->get('page');

        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $meta_keywords = $category->seo_keywords;
        $meta_image = $this->CI->theme->asset('/static/image/logo/logo.png');
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($category->page);
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "website",
            "og:url"                => $meta_url
        );
        
        $schemas = array();
        
        if($category->seo_schema->value){
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $category->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'image'         => $meta_image,
                'url'           => $meta_url,
                'keywords'      => $category->seo_keywords,
                'datePublished' => $category->created->format('c'),
                'dateCreated'   => $category->created->format('c')
            );
        }
        
        $schemas[] = $this->_schemaBreadcrumb([
            base_url() => $meta_name
        ]);
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
    
    public function post_amp($post, $comps){
        $meta_title = $post->seo_title->clean();
        if(!$meta_title)
            $meta_title = $post->title->clean();
        
        $meta_description = $post->seo_description->clean();
        if(!$meta_description)
            $meta_description = $post->content->chars(160);
        
        $page = $this->CI->input->get('page');
        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $meta_keywords = $post->seo_keywords;
        $meta_image = $post->cover;
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($post->page);
        $schemas    = array();
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "article",
            "og:url"                => $meta_url,
            "article:published_time"=> $post->published->format('c'),
            "article:modified_time" => $post->updated->format('c')
        );
        
        if(property_exists($post, 'category')){
            foreach($post->category as $cat)
                $metas["article:section"] = $cat->name;
        }
        if(property_exists($post, 'tag')){
            $metas['article:tag'] = array();
            foreach($post->tag as $tag)
                $metas['article:tag'][] = $tag->name;
        }
        
        if(!$post->seo_schema->value)
            $post->seo_schema = 'Article';
        
        // fuck get image sizes
        $image_file = dirname(BASEPATH) . $meta_image->value;
        if(is_file($image_file)){
            list($img_width, $img_height) = getimagesize($image_file);
            
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $post->seo_schema,
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
                        'url'           => $this->CI->theme->asset('/static/image/logo/logo-200x60.png'),
                        'width'         => 200,
                        'height'        => 60
                    )
                ),
                'datePublished' => $post->published->format('c'),
                'dateModified'  => $post->updated->format('c'),
                'dateCreated'   => $post->created->format('c')
            );
        }
        
        // google analytics grouping
        $ga = array();
        if($post->ga_group)
            $ga['group'] = $post->ga_group;
        
        $ga_code = $this->CI->setting->item('code_google_analytics');
        $this->CI->setting->item('code_google_analytics', false);
        
        echo $this->_general($meta_title, $metas, $schemas, $ga);
        echo '<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>';
        echo '<noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>';
        
        $this->CI->setting->item('code_google_analytics', $ga_code);
        if($ga_code)
            echo '<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>';
        
        if($comps){
            foreach($comps as $comp)
                echo '<script async custom-element="' . $comp . '" src="https://cdn.ampproject.org/v0/' . $comp . '-0.1.js"></script>';
        }
        echo '<script async src="https://cdn.ampproject.org/v0.js"></script>';
    }
    
    public function post_single($post){
        $meta_title = $post->seo_title->clean();
        if(!$meta_title)
            $meta_title = $post->title->clean();
        
        $meta_description = $post->seo_description->clean();
        if(!$meta_description)
            $meta_description = $post->content->chars(160);
        
        $page = $this->CI->input->get('page');
        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $meta_keywords = $post->seo_keywords;
        $meta_image = $post->cover;
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($post->page);
        $schemas    = array();
        $schema_bread = [
            base_url() => $meta_name
        ];
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "article",
            "og:url"                => $meta_url,
            "article:published_time"=> $post->published->format('c'),
            "article:modified_time" => $post->updated->format('c')
        );
        
        if(property_exists($post, 'category')){
            foreach($post->category as $cat){
                $metas["article:section"] = $cat->name;
                $schema_bread[base_url($cat->page)] = $cat->name;
                break;
            }
        }
        if(property_exists($post, 'tag')){
            $metas['article:tag'] = array();
            foreach($post->tag as $tag)
                $metas['article:tag'][] = $tag->name;
        }
        
        if(!$post->seo_schema->value)
            $post->seo_schema = 'Article';
        
        // fuck get image sizes
        $image_file = dirname(BASEPATH) . $meta_image->value;
        if(is_file($image_file)){
            list($img_width, $img_height) = getimagesize($image_file);
            
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $post->seo_schema,
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
                        'url'           => $this->CI->theme->asset('/static/image/logo/logo-200x60.png'),
                        'width'         => 200,
                        'height'        => 60
                    )
                ),
                'datePublished' => $post->published->format('c'),
                'dateModified'  => $post->updated->format('c'),
                'dateCreated'   => $post->created->format('c')
            );
        }
        
        $schemas[] = $this->_schemaBreadcrumb($schema_bread);
        
        // google analytics grouping
        $ga = array();
        if($post->ga_group)
            $ga['group'] = $post->ga_group;
        
        echo $this->_general($meta_title, $metas, $schemas, $ga);
        if($this->CI->setting->item('amphtml_support_for_post'))
            echo '<link rel="amphtml" href="' . base_url($post->amp) . '">';
    }
    
    public function post_tag_single($tag){
        $meta_title = $tag->seo_title->clean();
        if(!$meta_title)
            $meta_title = $tag->name->clean();
        
        $meta_description = $tag->seo_description->clean();
        if(!$meta_description)
            $meta_description = $tag->description->chars(160);
            
        $page = (int)$this->CI->input->get('page');
        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $meta_keywords = $tag->seo_keywords;
        $meta_image = $this->CI->theme->asset('/static/image/logo/logo.png');
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($tag->page);
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "website",
            "og:url"                => $meta_url
        );
        
        if($tag->seo_schema->value){
            $schemas[] = array(
                '@context'      => 'http://schema.org',
                '@type'         => $tag->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'image'         => $meta_image,
                'url'           => $meta_url,
                'keywords'      => $meta_keywords,
                'datePublished' => $tag->created->format('c'),
                'dateCreated'   => $tag->created->format('c')
            );
        }
        
        $schemas[] = $this->_schemaBreadcrumb([
            base_url() => $meta_name
        ]);
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
    
    public function search_single(){
        $meta_title = _l('Search');
        
        $meta_description = '';
        $meta_keywords = '';
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url(uri_string());
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords
        );
        
        $schemas = [];
        
        // schema breadcrumb
        $schemas[] = $this->_schemaBreadcrumb([
            base_url() => $meta_name
        ]);
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
    
    public function user_single($user){
        $meta_title = $user->fullname;
        
        $meta_description = $user->about->chars(160);
        $meta_keywords = '';
        $meta_image = $user->avatar;
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($user->page);
        
        $page = (int)$this->CI->input->get('page');
        if($page && $page > 1){
            $meta_title = _l('Page') . ' ' . $page . ' ' . $meta_title;
            $meta_description = _l('Page') . ' ' . $page . ' ' . $meta_description;
        }
        
        $metas = array(
            "description"           => $meta_description,
            "keywords"              => $meta_keywords,
            "twitter:card"          => "summary_large_image",
            "twitter:description"   => $meta_description,
            "twitter:image:src"     => $meta_image,
            "twitter:title"         => $meta_title,
            "twitter:url"           => $meta_url,
            "og:description"        => $meta_description,
            "og:image"              => $meta_image,
            "og:title"              => $meta_title,
            "og:type"               => "profile",
            "og:url"                => $meta_url,
            "profile:username"      => $user->name
        );
        
        $fname = explode(' ', $user->fullname);
        if($fname[0])
            $metas["profile:first_name"] = $fname[0];
        if(array_key_exists(1, $fname) && $fname[1])
            $metas["profile:last_name"] = $fname[1];
            
        $schemas[] = array(
            '@context'      => 'http://schema.org',
            '@type'         => 'Person',
            'email'         => $user->email,
            'image'         => $user->avatar,
            'name'          => $user->fullname,
            'url'           => $meta_url
        );
        
        // schema breadcrumb
        $schemas[] = $this->_schemaBreadcrumb([
            base_url() => $meta_name
        ]);
        
        echo $this->_general($meta_title, $metas, $schemas);
    }
}