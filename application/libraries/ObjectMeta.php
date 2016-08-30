<?php

if(!defined('BASEPATH'))
    die;

class ObjectMeta
{
    private $CI;
    
    private $object;
    private $name;
    private $meta_value = array();
    private $attr_value = array();
    private $rules;
    
    private $afterJQFiles = array();
    
    private $meta_to_attr = array(
        'article:author'                => 'property',
        'article:modified_time'         => 'property',
        'article:published_time'        => 'property',
        'article:publisher'             => 'property',
        'article:section'               => 'property',
        'article:tag'                   => 'property',
        'alexaVerifyID'                 => 'name',
        'msvalidate.01'                 => 'name',
        'p:domain_verify'               => 'name',
        'yandex-verification'           => 'name',
        'description'                   => 'name',
        'fb:admins'                     => 'property',
        'fb:app_id'                     => 'property',
        'fb:pages'                      => 'property',
        'fb:profile_id'                 => 'property',
        'generator'                     => 'name',
        'google-site-verification'      => 'name',
        'keywords'                      => 'name',
        'og:description'                => 'property',
        'og:image'                      => 'property',
        'og:site_name'                  => 'property',
        'og:title'                      => 'property',
        'og:type'                       => 'property',
        'og:url'                        => 'property',
        'og:updated_time'               => 'property',
        'profile:username'              => 'property',
        'profile:first_name'            => 'property',
        'profile:last_name'             => 'property',
        'twitter:card'                  => 'name',
        'twitter:description'           => 'name',
        'twitter:image:src'             => 'name',
        'twitter:title'                 => 'name',
        'twitter:url'                   => 'name',
        'viewport'                      => 'name'
    );
    
    function __construct(){
        $this->CI =&get_instance();
        
        $this->CI->load->config('object_meta');
        $this->CI->load->helper('pagination');
    }
    
    public function _generateGA($group=null){
        $ga_code = $this->CI->setting->item('code_google_analytics');
        
        $tx = '';
        
        if($ga_code){
            $tx.= '<script>';
            $tx.=   '(function(i,s,o,g,r,a,m){';
            $tx.=   'i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
            $tx.=   '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
            $tx.=   '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';
            $tx.=   'ga(\'create\', \'' . $ga_code . '\', \'auto\');';
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
    
    private function _generateLink(){
        $tx = '<link href="' . $this->CI->theme->asset('/static/image/logo/shortcut-icon.png') . '" rel="shortcut icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon.png') . '" rel="apple-touch-icon">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-72x72.png') . '" rel="apple-touch-icon" sizes="72x72">';
        $tx.= '<link href="' . $this->CI->theme->asset('/static/image/logo/apple-touch-icon-114x114.png') . '" rel="apple-touch-icon" sizes="114x114">';
        
        $tx.= '<link href="' . base_url('feed.xml') . '" rel="alternate" title="' . $this->CI->setting->item('site_frontpage_title') . '" type="application/rss+xml">';
        
        $canonical = $this->_metaValueFromObject('canonical');
        if($canonical)
            $tx.= '<link href="' . $canonical . '" rel="canonical">';
        
        if($this->CI->setting->item('amphtml_support_for_post')){
            $amphtml = $this->_metaValueFromObject('amphtml');
            if($amphtml)
                $tx.= '<link rel="amphtml" href="' . $amphtml . '">';
        }
        
        
        return $tx;
    }
    
    private function _generateMeta(){
        $tx = '<meta charset="utf-8">';
        $tx.= '<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">';
        
        $metas = array();
        
        if($this->CI->setting->item('site_theme_responsive'))
            $metas['viewport'] = 'width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no';
        
        $metas['generator'] = 'AdminCI';
        
        // metas from db
        $meta_db = array(
            'alexaVerifyID'             => 'code_verification_alexa',
            'fb:app_id'                 => 'code_application_facebook',
            'fb:pages'                  => 'code_facebook_page_id',
            'google-site-verification'  => 'code_verification_google',
            'msvalidate.01'             => 'code_verification_bing',
            'og:site_name'              => 'site_name',
            'p:domain_verify'           => 'code_verification_pinterest',
            'yandex-verification'       => 'code_verification_yandex'
        );
        
        foreach($meta_db as $name => $key){
            $value = $this->CI->setting->item($key);
            if($value)
                $metas[$name] = $value;
        }
        
        // meta from object/config
        foreach($this->meta_to_attr as $name => $attr){
            $value = $this->_metaValueFromObject($name);
            if($value)
                $metas[$name] = $value;
        }
        
        // always be there meta
        $req_metas = array('description', 'keywords');
        foreach($req_metas as $meta){
            if(!array_key_exists($meta, $metas))
                $metas[$meta] = '';
        }
        
        foreach($metas as $name => $value){
            $prop = array_key_value_or($name, $this->meta_to_attr, null);
            if($prop){
                if(is_array($value)){
                    foreach($value as $val)
                        $tx.= '<meta ' . $prop . '="' . $name . '" content="' . $val . '">';
                }else{
                    $tx.= '<meta ' . $prop . '="' . $name . '" content="' . $value . '">';
                }
            }
        }
        
        return $tx;
    }
    
    private function _generateSchema(){
        $schemas = array();
        
        // website
        $schemas[] = array(
            '@context'          => 'http://schema.org',
            '@type'             => 'WebSite',
            'url'               => base_url(),
            'description'       => $this->CI->setting->item('site_frontpage_description'),
            'headline'          => $this->CI->setting->item('site_frontpage_title'),
            'publisher'         => array(
                "@type"             => "Organization",
                "name"              => $this->CI->setting->item('site_name')
            ),
            'image'             => base_url('/static/image/logo/logo.png'),
            'name'              => $this->CI->setting->item('site_name'),
            'potentialAction'   => array(
                '@type'             => 'SearchAction',
                'target'            => base_url('/search') . '?q={search_term_string}',
                'query-input'       => 'required name=search_term_string'
            )
        );
        
        if(property_exists($this->object, 'schema')){
            foreach($this->object->schema as $schema)
                $schemas[] = $schema;
        }
        
        
        $tx = '';
        foreach($schemas as $schema){
            $tx.= '<script type="application/ld+json">';
            $tx.= json_encode($schema, JSON_UNESCAPED_SLASHES);
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    private function _generateScript(){
        $ga_group = $this->_metaValueFromObject('ga:group');
        $tx = '';
        
        // AMP Page shouldn't with ga
        if(!$this->_metaValueFromObject('is_amp'))
            $tx.= $this->_generateGA($ga_group);
        
        return $tx;
    }
    
    /**
     * Get meta values from object
     * @param string name the meta name.
     * @return string on exists, false otherwise.
     */
    private function _metaValueFromObject($name){
        if(array_key_exists($name, $this->attr_value))
            return $this->attr_value[$name];
        
        if(!$this->rules){
            $rules = config_item('object_meta');
            if(!array_key_exists($this->name, $rules))
                return false;
            $this->rules = $rules[$this->name];
        }
        
        if(!array_key_exists($name, $this->rules))
            return false;
        
        $rules = $this->rules[$name];
        
        if(is_string($rules))
            $rules = [$rules];
        
        foreach($rules as $rule){
            if(array_key_exists($rule, $this->meta_value))
                return $this->meta_value[$rule];
            
            if(substr($rule,0,1) == '@')
                $value = $this->_metaValueFromObject(substr($rule,1));
            else
                $value = $this->_metaValueFromLexer($rule);
            
            if($value)
                break;
        }
        
        $this->attr_value[$name] = $value;
        $this->meta_value[$rule] = $value;
        return $value;
    }
    
    /** 
     * Get meta value from lexer 
     * @param string rule 
     * @return string value or false.
     */
    private function _metaValueFromLexer($rule){
        $params = explode('|', $rule);
        $value  = null;
        
        foreach($params as $index => $param){
            if(!$index){
                $value = $param;
                
            }else{
            
                $func = $param;
                $args = [$value];
                
                if($func == 'object_property'){
                    if(strstr($value, '->') === false){
                        if(!property_exists($this->object, $value))
                            return false;
                        $value = $this->object->{$value};
                    }else{
                        $values = explode('->', $value);
                        $value  = $this->object;
                        
                        foreach($values as $index => $prop){
                            if(preg_match('!([^\(]+)\(([^\)]*)\)!', $prop, $match)){
                                $method_name   = $match[1];
                                $method_params = explode(',',$match[2]);
                                if(!method_exists($value, $method_name))
                                    return false;
                                $value = call_user_func_array([$value, $method_name], $method_params);
                            }else{
                                if(!property_exists($value, $prop))
                                    return false;
                                $value = $value->$prop;
                            }
                        }
                    }
                }else{
                
                    if(preg_match('!([^\(]+)\(([^\)]+)\)!', $func, $match)){
                        $func = $match[1];
                        if(array_key_exists(2, $match)){
                            $func_args = explode(',', $match[2]);
                            foreach($func_args as $index => $val){
                                $val = trim($val);
                                if($val == '$')
                                    $val = $value;
                                $func_args[$index] = $val;
                            }
                            $args = $func_args;
                        }
                    }
                    
                    if(strstr($param, '->') !== false){
                        // it can only be 2 member on it
                        $funcs = explode('->', $param);
                        $func = [$this->CI->{$funcs[0]}, $funcs[1]];
                    }
                    
                    $value = call_user_func_array($func, $args);
                }
            }
            
            if(!$value)
                break;
        }
        
        return $value;
    }
    
    /**
     * Add new script after JQ loaded
     * @param string|array files The file name to load
     */
    public function addAfterJQ($files){
        if(!is_array($files))
            $files = [$files];
        
        foreach($files as $file){
            if($file == 'cac.js')
                $file = base_url('/theme/static/js/cac.js');
            if(!in_array($file, $this->afterJQFiles))
                $this->afterJQFiles[] = $file;
        }
    }
    
    /**
     * Print footer scripts
     * @param string|array files List of additional files to append
     * @return string scripts tag
     */
    public function footer($files=array()){
        $tx = '';
        
        if($files)
            $this->addAfterJQ($files);
        
        // facebook js
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
        
        if($this->afterJQFiles){
            $tx.= '<script src="https://code.jquery.com/jquery-1.12.3.min.js" async defer></script>';
            $tx.= '<script>';
            $tx.= 'function loadJS(){';
            $tx.=   'if(!window.jQuery) return setTimeout(loadJS,100);';
            $tx.=   'var files = ' . json_encode($this->afterJQFiles) . ';';
            $tx.=   'for(var i=0; i<files.length; i++){';
            $tx.=       'var s = document.createElement(\'script\');';
            $tx.=       's[files[i].substr(0,4)==\'http\'?\'src\':\'innerHTML\'] = files[i];';
            $tx.=       'document.body.appendChild(s);';
            $tx.=   '}';
            $tx.= '}';
            $tx.= 'loadJS()';
            $tx.= '</script>';
        }
        
        return $tx;
    }
    
    /**
     * Generate the meta 
     * @param string name The object name.
     * @param object object The object object.
     * @return string meta The meta.
     */
    public function generate($name, $object=null){
        $this->object       = $object;
        $this->name         = $name;
        $this->meta_value   = array();
        $this->rules        = null;
        $this->attr_value   = array();
        
        if(!$this->object)
            $this->object = new stdClass;
        
        $tx = $this->_generateMeta();
        $tx.= $this->_generateLink();
        $tx.= $this->_generateSchema();
        $tx.= $this->_generateScript();
        
        $title = $this->_metaValueFromObject('title');
        if($title)
            $tx.= '<title>' . $title . ' - ' . $this->CI->setting->item('site_name') . '</title>';
        
        return $tx;
    }
    
    public function __call($name, $args){
        array_unshift($args, $name);
        return call_user_func_array([$this, 'generate'], $args);
    }
}