<?php

if(!defined('BASEPATH'))
    die;

class ObjectFormatter 
{
    private $CI;
    
    function __construct(){
        $this->CI =&get_instance();
        $this->CI->load->config('object_formatter');
        
        $x_objs = ['objDate', 'objEnum', 'objMedia', 'objText'];
        foreach($x_objs as $obj)
            require_once(APPPATH . 'object/' . $obj . '.php');
    }
    
    private function _makeEmbed($url){
        $regexs = [
            '/youtu\.be\/([\w\-.]+)/'                               => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 560, 'height' => 314, 'src' => 'https://www.youtube.com/embed/$1', 'allowFullscreen' => '1' ] ],
            '/youtube\.com(.+)v=([^&]+)/'                           => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 560, 'height' => 314, 'src' => 'https://www.youtube.com/embed/$2', 'allowFullscreen' => '1' ] ],
            '/youtube.com\/embed\/([a-z0-9\-_]+)/i'                 => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 560, 'height' => 314, 'src' => 'https://www.youtube.com/embed/$1', 'allowFullscreen' => '1' ] ],
            '/vimeo\.com\/([0-9]+)/'                                => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 425, 'height' => 350, 'src' => 'https://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0&color=e3a01b', 'allowFullscreen' => '1' ] ],
            '/vimeo\.com\/(.*)\/([0-9]+)/'                          => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 425, 'height' => 350, 'src' => 'https://player.vimeo.com/video/$2?title=0&amp;byline=0&amp;portrait=0&color=e3a01b', 'allowFullscreen' => '1' ] ],
            '/dailymotion.com\/embed\/video\/([^_]+)/'              => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 480, 'height' => 270, 'src' => 'https://www.dailymotion.com/embed/video/$1', 'allowFullscreen' => '1', 'frameborder' => '0' ] ],
            '/dailymotion.com\/video\/([^_]+)/'                     => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 480, 'height' => 270, 'src' => 'https://www.dailymotion.com/embed/video/$1', 'allowFullscreen' => '1', 'frameborder' => '0' ] ],
            '/vidio.com\/watch\/([\w\-]+)/'                         => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 480, 'height' => 270, 'src' => 'https://www.vidio.com/embed/$1?player_only=true', 'frameborder' => '0', 'class' => 'vidio-embed', 'scrolling' => 'no' ] ],
            '/vidio.com\/embed\/([\w\-]+)/'                         => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 480, 'height' => 270, 'src' => 'https://www.vidio.com/embed/$1?player_only=true', 'frameborder' => '0', 'class' => 'vidio-embed', 'scrolling' => 'no' ] ],
            '/facebook.com/'                                        => [ 'tag' => 'div',    'attrs' => [ 'data-href' => $url, 'data-width' => '670', 'data-show-text' => 'false', 'class' => 'fb-video', 'data-allowfullscreen' => 'true' ] ],
            '/liveleak.com\/ll_embed\?f=([\w\-]+)/'                 => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 640, 'height' => 360, 'src' => 'http://www.liveleak.com/ll_embed?f=$1', 'frameborder' => '0' ] ],
            '/dailymail.co.uk\/video\/([\w]+)\/video-([0-9]+)/'     => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 698, 'height' => 573, 'src' => 'http://www.dailymail.co.uk/embed/video/$2.html', 'frameborder' => '0', 'allowfullscreen' => '1', 'scrolling' => 'no' ] ],
            '/dailymail.co.uk\/([\w]+)\/video\/([0-9]+)/'           => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 698, 'height' => 573, 'src' => 'http://www.dailymail.co.uk/embed/video/$2.html', 'frameborder' => '0', 'allowfullscreen' => '1', 'scrolling' => 'no' ] ],
            '/vid.me\/([\w\-]+)/'                                   => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 854, 'height' => 480, 'src' => 'https://vid.me/e/$1?tools=1', 'frameborder' => '0', 'allowfullscreen' => '1', 'scrolling' => 'no' ] ],
            '/vid.me\/e\/([\w\-]+)/'                                => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 854, 'height' => 480, 'src' => 'https://vid.me/e/$1?tools=1', 'frameborder' => '0', 'allowfullscreen' => '1', 'scrolling' => 'no' ] ],
            '/imdb.com\/video\/imdb\/([\w]+)/'                      => [ 'tag' => 'iframe', 'attrs' => [ 'width' => 854, 'height' => 400, 'src' => 'http://www.imdb.com/videoembed/$1', 'allowfullscreen' => '1' ]]
        ];
        
        $tx = '';
        foreach($regexs as $re => $prop){
            if(preg_match($re, $url, $match)){
                $tag = $prop['tag'];
                $attrs = array();
                
                foreach($prop['attrs'] as $name => $value){
                    foreach($match as $index => $val)
                        $value = str_replace('$' . $index, $val, $value);
                    $attrs[] = $name . '="' . $value . '"';
                }
                
                $attrs = ' ' . implode(' ', $attrs);
                $tx = '<' . $tag . $attrs . '></' . $tag . '>';
                break;
            }
        }
        
        // they're not any of above solution, let try to make video/audio tag instead
        if(!$tx){
            $mime = '';
            $ext = explode('.', $url);
            $ext = '.' . end($ext);
            if($ext == '.mp3')
                $mime = 'audio/mpeg';
            elseif($ext == '.wav')
                $mime = 'audio/wav';
            elseif($ext == '.mp4')
                $mime = 'video/mp4';
            elseif($ext == 'webm')
                $mime = 'video/webm';
            elseif($ext == '.ogg')
                $mime = 'video/ogg';
            
            if($mime){
                if(in_array($ext, ['.mp3', '.wav']))
                    $tx = '<audio controls><source src="' . $url . '" type="' . $mime . '"></audio>';
                else 
                    $tx = '<video width="560" height="314" controls><source src="' . $url . '" type="' . $mime . '"></video>';
            }
        }
        
        return $tx;
    }
    
    /**
     * Start formatting the object.
     * @param string name The format name.
     * @param object|array objects Single object or list of object to format.
     * @param boolean arraykey Set field as the array key. Default false. True for id.
     * @param array|boolean fetch List of field to format/force fetch the data from
     *  database for format type start with @.
     * @return formatted object.
     */
    public function format($name, $objects, $arraykey=false, $fetch=true){
        $current_user = $this->CI->user ? $this->CI->user->id : 0;
        
        if(!$objects)
            return $objects;
        
        if($arraykey === true)
            $arraykey = 'id';
        
        $single = is_object($objects);
        
        $rules = config_item('object_formatter');
        if(!array_key_exists($name, $rules)){
            if($arraykey && !$single)
                return prop_as_key($objects, $arraykey);
            return $objects;
        }
        
        if($single)
            $objects = [$objects];
        
        $rules = $rules[$name];
        $other_tables = array();
        $used_model = array();
        
        if($fetch){
            if(is_string($fetch))
                $fetch = [$fetch];
            
            if(is_int($fetch))
                $fetch = true;
            
            if($fetch === true){
                $fetch = array();
                foreach($rules as $field => $rule)
                    $fetch[$field] = false;
            }
            
            $new_fetch = array();
            foreach($fetch as $field => $cond){
                if(is_numeric($field)){
                    unset($fetch[$field]);
                    $field = $cond;
                    $cond = false;
                    $fetch[$field] = $cond;
                }
                
                if(preg_match('!^@([a-z]+)\[([^\]]+)\]$!', $rules[$field], $match)){
                    $new_fetch[$field] = $cond;
                    $type = $match[1];
                    $table= $match[2];
                    
                    $model_chain = null;
                    $model_main  = null;
                    $table_chain = null;
                    $table_main  = null;
                    
                    if($type == 'chain' && !strstr($table, ','))
                        $table.= ',' . $table . '_chain';
                    
                    $tables = explode(',', $table);
                    
                    foreach($tables as $index => $tab){
                        $tab = trim($tab);
                        $model = ucfirst(str_replace('_', '', $tab));
                        $model_name = $model . '_model';
                        if(!array_key_exists($model_name, $used_model))
                            $used_model[$model_name] = $model;
                        
                        if(!$index){
                            $table_main = $tab;
                            $model_main = $model;
                        }else{
                            $table_chain= $tab;
                            $model_chain= $model;
                        }
                    }
                    
                    $other_tables[$field] = array(
                        'type'        => $type,
                        'table'       => $table_main,
                        'table_chain' => $table_chain,
                        'model'       => $model_main,
                        'model_chain' => $model_chain,
                        'rows'        => array()
                    );
                }
            }
            $fetch = $new_fetch;
            
            if($other_tables){
                if($used_model){
                    foreach($used_model as $model_name => $model)
                        $this->CI->load->model($model_name, $model);
                }
                foreach($other_tables as $field => $cond){
                    $table_ids = array();
                    $type = $cond['type'];
                    $table = $cond['table'];
                    $table_chain = $cond['table_chain'];
                    $model = $cond['model'];
                    $model_chain = $cond['model_chain'];
                    
                    foreach($objects as $obj){
                        $value = NULL;
                        if(in_array($type, array('chain', 'member', 'partial')))
                            $value = $obj->id;
                        elseif($type == 'parent')
                            $value = $obj->$field;
                        
                        if($value)
                            $table_ids[] = $value;
                    }
                    $table_ids = array_unique($table_ids);
                    
                    if(!$table_ids)
                        continue;
                    
                    if(in_array($type, ['parent', 'partial'])){
                        $table_field = 'id';
                        if($type == 'partial')
                            $table_field = $name;
                        
                        $dbrows = $this->CI->$model->getByCond([$table_field=>$table_ids], true);
                        
                        if($dbrows){
                            $dbrows = $this->format($table, $dbrows, $table_field, $fetch[$field]);
                            $other_tables[$field]['rows'] = $dbrows;
                        }
                    
                    }elseif($type == 'member'){
                        $cond = array(
                            'user' => $current_user,
                            $name  => $table_ids
                        );
                        $dbrows = $this->CI->$model->getByCond($cond, true);
                        
                        /*
                        $dbrows = $this->CI->db 
                            ->where_in($name, $table_ids)
                            ->where('user', $current_user)
                            ->get($table);
                        
                        if($dbrows->num_rows()){
                            $dbrows = $dbrows->result();
                            $dbrows = prop_as_key($dbrows, $name);
                            $other_tables[$field]['rows'] = $dbrows;
                        }
                        */
                        
                        if($dbrows){
                            $dbrows = prop_as_key($dbrows, $name);
                            $other_tables[$field]['rows'] = $dbrows;
                        }
                    
                    }elseif($type == 'chain'){
                        $dbrows = $this->CI->$model_chain->getByCond([$name=>$table_ids], true);
                        
                        if($dbrows){
                            $chain_ids = prop_values($dbrows, $table);
                            $chain_ids = array_unique($chain_ids);
                            
                            $chain_values = $this->CI->$model->getByCond(['id' => $chain_ids], true);
                            
                            if($chain_values){
                                $chain_values = $this->format($table, $chain_values, 'id', $fetch[$field]);
                                
                                $dbrows_result = array();
                                foreach($dbrows as $row){
                                    $chain_value_id = $row->$table;
                                    if(!array_key_exists($chain_value_id, $chain_values))
                                        continue;
                                    $chain_value = clone $chain_values[$chain_value_id];
                                    $chain_value->chain_id = $row->id;
                                    if(!array_key_exists($row->$name, $dbrows_result))
                                        $dbrows_result[$row->$name] = array();
                                    $dbrows_result[$row->$name][] = $chain_value;
                                }
                                
                                $other_tables[$field]['rows'] = $dbrows_result;
                            }
                        }
                    }
                }
            }
        }
        
        $falsy = array(0, '0', 'no', 'false', false, null);
        foreach($objects as $index => &$object){
            foreach($rules as $field => $cond){
                if(array_key_exists($field, $other_tables)){
                    $other_field = $other_tables[$field];
                    $rows = $other_field['rows'];
                    
                    if(in_array($other_field['type'], array('chain', 'member', 'partial')))
                        $rows_id = $object->id;
                    else
                        $rows_id = $object->$field;
                    
                    if(array_key_exists($rows_id, $rows))
                        $object->$field = $rows[$rows_id];
                
                }elseif(property_exists($object, $field)){
                    switch($cond){
                        case 'boolean':
                            $value = strtolower($object->$field);
                            $value = !in_array($value, $falsy, true);
                            $object->$field = $value;
                            break;
                        case 'date':
                            $object->$field = new objDate($object->$field);
                            break;
                        case 'delete':
                            unset($object->$field);
                            break;
                        case 'enum':
                            $object->$field = new objEnum("$name.$field", $object->$field);
                            break;
                        case 'integer':
                            $object->$field = (int)$object->$field;
                            break;
                        case 'location':
                            $location = explode(',', $object->$field);
                            if(count($location) == 2){
                                $object->$field = (object)array(
                                    'latitude' => $location[0],
                                    'longitude'=> $location[1]
                                );
                            }
                            break;
                        case 'media':
                            $object->$field = new objMedia($object->$field);
                            break;
                        case 'media-list':
                            $medias = explode(',', $object->$field);
                            foreach($medias as &$media)
                                $media = new objMedia($media);
                            $object->$field = $medias;
                            break;
                        case 'string':
                            $object->$field = (string)$object->$field;
                            break;
                        case 'text':
                            $object->$field = new objText($object->$field);
                            break;
                        case 'embed':
                            if(substr($object->$field, 0, 4) == 'http')
                                $object->$field = $this->_makeEmbed($object->$field);
                            break;
                    }
                }else{
                    if(preg_match('!^join\(([^\)]+)\)$!', $cond, $match)){
                        $vars = explode('|', $match[1]);
                        $value = '';
                        foreach($vars as $var){
                            if(substr($var, 0, 1) == '$'){
                                $var = substr($var, 1);
                                if(property_exists($object, $var))
                                    $value.= $object->$var;
                            }else{
                                $value.= $var;
                            }
                        }
                        $object->$field = $value;
                    }
                }
            }
        }
        
        if($single)
            return $objects[0];
        if($arraykey)
            return prop_as_key($objects, $arraykey);
        return $objects;
    }
    
    /**
     * MAGIC method to call _format
     * @param string name The format name.
     * @param array args List of arguments
     * @return as of format()
     */
    public function __call($name, $args){
        array_unshift($args, $name);
        return call_user_func_array(array($this, 'format'), $args);
    }
}