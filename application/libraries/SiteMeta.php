<?php

class SiteMeta
{
    private $CI;
    private $site_params;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    private function _general($title=null, $metas=null){
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
        
        if($metas)
            $tx.= $metas;
        
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/shortcut-icon.png') . '" rel="shortcut icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon.png') . '" rel="apple-touch-icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-72x72.png') . '" rel="apple-touch-icon" sizes="72x72">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-114x114.png') . '" rel="apple-touch-icon" sizes="114x114">';
        
        $tx.= '<link href="' . base_url('feed.xml') . '" rel="alternate" title="' . $this->CI->setting->item('site_frontpage_title') . '" type="application/rss+xml">';
        
        $tx.= '<link href="' . base_url(uri_string()) . '" rel="canonical">';
        
        $ga_code = $this->CI->setting->item('code_google_analytics');
        if($ga_code)
            $tx.= '<script>(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\'); ga(\'create\', \'' . $ga_code . '\', \'auto\'); ga(\'send\', \'pageview\');</script>';
        
        if($title)
            $tx.= '<title>' . $title . ' - ' . $this->CI->setting->item('site_name') . '</title>';
        
        $data = array(
            '@context'      => 'http://schema.org',
            '@type'         => 'Website',
            'url'           => base_url(),
            'potentialAction' => array(
                '@type'         => 'SearchAction',
                'target'        => base_url('/post/search') . '?q={search_term_string}',
                'query-input'   => 'required name=search_term_string'
            )
        );
        
        $tx.= '<script type="application/ld+json">';
        $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
        $tx.= '</script>';
        
        return $tx;
    }
    
    public function gallery_single($gallery){
        $meta_title = $gallery->seo_title;
        if(!$meta_title)
            $meta_title = $gallery->title;
        
        $meta_description = $gallery->seo_description;
        if(!$meta_description)
            $meta_description = $gallery->description->chars(160);
        
        $meta_keywords = $gallery->seo_keywords;
        $meta_image = $gallery->cover;
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_url   = base_url($gallery->page);
        
        $tx = '<meta name="description" content="' . $meta_description . '">';
        $tx.= '<meta name="keywords" content="' . $meta_keywords . '">';
        
        $tx.= '<meta name="twitter:card" content="summary_large_image">';
        $tx.= '<meta name="twitter:description" content="' . $meta_description . '">';
        $tx.= '<meta name="twitter:image:src" content="' . $meta_image . '">';
        $tx.= '<meta name="twitter:title" content="' . $meta_title  .'">';
        $tx.= '<meta name="twitter:url" content="' . $meta_url . '">';
        
        $tx.= '<meta property="og:description" content="' . $meta_description . '">';
        $tx.= '<meta property="og:image" content="' . $meta_image . '">';
        $tx.= '<meta property="og:site_name" content="' . $meta_name . '">';
        $tx.= '<meta property="og:title" content="' . $meta_title . '">';
        $tx.= '<meta property="og:type" content="website">';
        $tx.= '<meta property="og:url" content="' . $meta_url . '">';
        
        $tx = $this->_general($meta_title, $tx);
        
        if($gallery->seo_schema){
            $data = array(
                '@context'      => 'http://schema.org',
                '@type'         => $gallery->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'image'         => $meta_image,
                'url'           => $meta_url,
                'keywords'      => $gallery->seo_keywords,
                'datePublished' => $gallery->created->format('c'),
                'dateCreated'   => $gallery->created->format('c')
            );
            
            $tx.= '<script type="application/ld+json">';
            $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
            $tx.= '</script>';
        }
        
        $data = array(
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => base_url(),
                        'name' => $this->CI->setting->item('site_name')
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => base_url('/gallery'),
                        'name' => _l('Gallery')
                    )
                )
            )
        );
        $tx.= '<script type="application/ld+json">';
        $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
        $tx.= '</script>';
        
        echo $tx;
    }
    
    public function home($title=null){
        if(!$title)
            $title = $this->CI->setting->item('site_frontpage_title');
        
        $meta_description = $this->CI->setting->item('site_frontpage_description');
        $meta_name  = $this->CI->setting->item('site_name');
        $meta_image = $this->CI->theme->asset('/static/image/logo/logo.png');
        
        $tx = '<meta name="description" content="' . $meta_description . '">';
        $tx.= '<meta name="keywords" content="' . $this->CI->setting->item('site_frontpage_keywords') . '">';
        
        $tx.= '<meta name="twitter:card" content="summary_large_image">';
        $tx.= '<meta name="twitter:description" content="' . $meta_description . '">';
        $tx.= '<meta name="twitter:image:src" content="' . $meta_image . '">';
        $tx.= '<meta name="twitter:title" content="' . $meta_name  .'">';
        $tx.= '<meta name="twitter:url" content="' . base_url() . '">';
        
        $tx.= '<meta property="og:description" content="' . $meta_description . '">';
        $tx.= '<meta property="og:image" content="' . $meta_image . '">';
        $tx.= '<meta property="og:site_name" content="' . $meta_name . '">';
        $tx.= '<meta property="og:title" content="' . $title . '">';
        $tx.= '<meta property="og:type" content="website">';
        $tx.= '<meta property="og:url" content="' . base_url() . '">';
        
        
        $tx = $this->_general($title, $tx);
        
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
            $data['contactPoint'] == $contacts;
        
        $tx.= '<script type="application/ld+json">';
        $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
        $tx.= '</script>';
        
        echo $tx;
    }
    
    public function page_single($page){
        $meta_title = $page->seo_title;
        if(!$meta_title)
            $meta_title = $page->title;
        
        $meta_description = $page->seo_description;
        if(!$meta_description)
            $meta_description = $page->content->chars(160);
        
        $meta_keywords = $page->seo_keywords;
        $meta_image = $this->CI->theme->asset('/static/image/logo/logo.png');
        $meta_name  = $this->CI->setting->item('site_name');
        
        $tx = '<meta name="description" content="' . $meta_description . '">';
        $tx.= '<meta name="keywords" content="' . $meta_keywords . '">';
        
        $tx.= '<meta name="twitter:card" content="summary_large_image">';
        $tx.= '<meta name="twitter:description" content="' . $meta_description . '">';
        $tx.= '<meta name="twitter:image:src" content="' . $meta_image . '">';
        $tx.= '<meta name="twitter:title" content="' . $meta_title  .'">';
        $tx.= '<meta name="twitter:url" content="' . base_url($page->page) . '">';
        
        $tx.= '<meta property="og:description" content="' . $meta_description . '">';
        $tx.= '<meta property="og:image" content="' . $meta_image . '">';
        $tx.= '<meta property="og:site_name" content="' . $meta_name . '">';
        $tx.= '<meta property="og:title" content="' . $meta_title . '">';
        $tx.= '<meta property="og:type" content="website">';
        $tx.= '<meta property="og:url" content="' . base_url($page->page) . '">';
        
        $tx = $this->_general($meta_title, $tx);
        
        if($page->seo_schema){
            $data = array(
                '@context'      => 'http://schema.org',
                '@type'         => $page->seo_schema,
                'name'          => $meta_title,
                'description'   => $meta_description,
                'url'           => base_url($page->page),
                'dateCreated'   => $page->created->format('c')
            );
            
            $tx.= '<script type="application/ld+json">';
            $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
            $tx.= '</script>';
        }
        
        $data = array(
            '@context'  => 'http://schema.org',
            '@type'     => 'BreadcrumbList',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => array(
                        '@id' => base_url(),
                        'name' => $meta_name
                    )
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => array(
                        '@id' => base_url('/page'),
                        'name' => _l('Page')
                    )
                )
            )
        );
        $tx.= '<script type="application/ld+json">';
        $tx.= json_encode($data, JSON_UNESCAPED_SLASHES);
        $tx.= '</script>';
        
        echo $tx;
    }
}