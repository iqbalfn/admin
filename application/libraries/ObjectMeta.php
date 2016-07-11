<?php

class ObjectMeta
{
    private $CI;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    private function generate($name, $object=null){
        $tx = '<meta charset="utf-8">';
        $tx.= '<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">';
        
        $meta_prop_or_name = array(
            'name' => [
                'alexaVerifyID',
                'description',
                'generator',
                'google-site-verification',
                'keywords',
                'msvalidate.01',
                'p:domain_verify',
                'twitter:card',
                'twitter:description',
                'twitter:image:src',
                'twitter:title',
                'twitter:url',
                'viewport',
                'yandex-verification'
            ],
            'property' => [
                'article:modified_time',
                'article:publisher',
                'article:section',
                'article:published_time',
                'article:section',
                'article:tag',
                'fb:app_id',
                'fb:pages',
                'og:description',
                'og:image',
                'og:site_name',
                'og:title',
                'og:type',
                'og:url',
                'profile:username',
                'profile:first_name',
                'profile:last_name'
            ]
        );
        
        $metas      = array();
        $schemes    = array(
            array(
                '@context'          => 'http://schema.org',
                '@type'             => 'Website',
                'url'               => base_url(),
                'potentialAction'   => array(
                    '@type'             => 'SearchAction',
                    'target'            => base_url('/search') . '?q={search_term_string}',
                    'query-input'       => 'required name=search_term_string'
                )
            )
        );
        
        if($this->CI->setting->item('site_theme_responsive'))
            $metas['viewport'] = 'width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no';
        $metas['generator'] = 'AdminCI';
        
        $meta_from_db = array(
            'code_application_facebook'     => 'fb:app_id',
            'code_facebook_page_id'         => 'fb:pages',
            'code_verification_alexa'       => 'alexaVerifyID',
            'code_verification_bing'        => 'msvalidate.01',
            'code_verification_google'      => 'google-site-verification',
            'code_verification_pinterest'   => 'p:domain_verify',
            'code_verification_yandex'      => 'yandex-verification',
            'site_name'                     => 'og:site_name'
        );
        
        foreach($meta_from_db as $key => $name){
            $meta_db_val = $this->CI->setting->item($key);
            if($meta_db_val)
                $metas[$name] = $meta_db_val;
        }
        
        // generate the meta of the object
        foreach($metas as $name => $value){
            $prop_name = null;
            
            if(in_array($name, $meta_prop_or_name['name']))
                $prop_name = 'name';
            elseif(in_array($name, $meta_prop_or_name['property']))
                $prop_name = 'property';
                
            if(!$prop_name)
                continue;
            
            if(is_array($value)){
                foreach($value as $val)
                    $tx.= '<meta ' . $prop_name . '="' . $name . '" content="' . hs($val) . '">';
            }else{
                $tx.= '<meta ' . $prop_name . '="' . $name . '" content="' . ($value) . '">';
            }
        }
        
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/shortcut-icon.png') . '" rel="shortcut icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon.png') . '" rel="apple-touch-icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-72x72.png') . '" rel="apple-touch-icon" sizes="72x72">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-114x114.png') . '" rel="apple-touch-icon" sizes="114x114">';
        
        $tx.= '<link href="' . base_url('feed.xml') . '" rel="alternate" title="' . $this->CI->setting->item('site_frontpage_title') . '" type="application/rss+xml">';
        $tx.= '<link href="' . base_url(uri_string()) . '" rel="canonical">';
        
        $tx.= $this->google_analytics(array_key_value_or('ga_group', $metas, null));
        
        if(array_key_exists('og:title', $metas))
            $tx.= '<title>' . $metas['og:title'] . ' - ' . $metas['og:site_name'] . '</title>';
        
        foreach($schemes as $scheme){
            $tx.= '<script type="application/ld+json">';
            $tx.= json_encode($scheme, JSON_UNESCAPED_SLASHES);
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    private function google_analytics($group=null){
        $code = $this->CI->setting->item('code_google_analytics');
        
        $tx = '';
        if($code){
            $tx.= '<script>';
            $tx.=   '(function(i,s,o,g,r,a,m){';
            $tx.=   'i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
            $tx.=   '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
            $tx.=   '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';
            $tx.=   'ga(\'create\', \'' . $code . '\', \'auto\');';
            if($group){
                $index = $this->CI->setting->item('google_analytics_content_group');
                if($group)
                    $tx.= 'ga(\'set\', \'contentGroup' . $index . '\', \'' . $group . '\');';
            }
            $tx.=   'ga(\'send\', \'pageview\');';
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    public function __call($name, $args){
        array_unshift($args, $name);
        return call_user_func_array(array($this, 'generate'), $args);
    }
}