<?php

if(!defined('BASEPATH'))
    die;

class MediaFile
{
    private $CI;
    
    function __construct(){
        $this->CI =&get_instance();
        
    }
    
    /**
     * Make the name and create the folder of the file.
     * @param string name The file name to prepare.
     * @return array list of the new media data to be use.
     *  @param string local_file_name The file name without extension to use.
     *  @param string local_file The file with extension to use.
     *  @param string local_file_ext The extension of the file.
     *  @param string local_file_path Absolute path to the file.
     *  @param string local_file_folder Absolute path to the file folder.
     *  @param string local_media_folder Relative path to the file folder ( use this on website )
     *  @param string local_media_file Relative path to the file.
     */
    private function _prepareTargetDir($name){
        $exts = explode('.', $name);
        $ext  = end($exts);
        
        $local_file_name = md5(time() . '-' . uniqid());
        $local_file      = $local_file_name . '.' . $ext;
        $local_media     = '/media/';
        $local_path_abs  = dirname(BASEPATH);
        $local_path      = $local_path_abs . $local_media;
        
        $index_file = APPPATH . 'index.html';
        for($i=0; $i<3; $i++){
            $sub_path = substr($local_file_name, ($i*2), 2);
            $local_media.= "$sub_path/";
            $local_path = $local_path_abs . $local_media;
            if(!is_dir($local_path)){
                mkdir($local_path);
                copy($index_file, $local_path.'index.html');
            }
        }
        
        $result = array(
            'local_file_name'   => $local_file_name,
            'local_file'        => $local_file,
            'local_file_ext'    => $ext,
            'local_file_path'   => $local_path . $local_file,
            'local_file_folder' => $local_path,
            'local_media_folder'=> $local_media,
            'local_media_file'  => $local_media . $local_file,
            'original_name'     => $name
        );
        
        if(is_file($result['local_file_path'])){
            sleep(1);
            return $this->_prepareTargetDir($name);
        }
        
        return $result;
    }
    
    /**
     * Save the result to DB 
     * @param array target The target object as returned by _prepareTargetDir
     * @param string type The media type. as of form_validation rule name.
     * @return media id on success, false otherwise.
     */
    private function _saveToDB($target, $type, $object=null){
        $user_id = $this->CI->user ? $this->CI->user->id : 1;
        
        $new = array(
            'user' => $user_id,
            'original_name' => $target['original_name'],
            'name' => $target['local_file'],
            'path' => $target['local_media_file'],
            'type' => $type
        );
        if($object)
            $new['object'] = $object;
        
        $this->CI->load->model('Media_model', 'Media');
        return $this->CI->Media->create($new);
    }
    
    /**
     * Process local file.
     * @param string path Absolute path to local file.
     * @param string name The real name of the file.
     * @param string type The media type. The name of rule on form_validation.
     * @param integer object The object this file belong to.
     * @return as of _prepareTargetDir
     */
    public function processLocal($path, $name, $type, $object=null){
        $target = $this->_prepareTargetDir($name);
        
        copy($path, $target['local_file_path']);
        
        $target['media_id'] = $this->_saveToDB($target, $type, $object);
        return $target;
    }
    
    /**
     * Process Upload
     * @param string name The input form name.
     * @param string filename The original file name.
     * @param string type The media type. The name of rule on form_validation.
     * @param integer object The object id this file belongs to.
     * @return as of _prepareTargetDir
     */
    public function processUpload($name, $filename, $type, $object=null){
        $target = $this->_prepareTargetDir($filename);
        
        $this->CI->load->config('form_validation');
        
        $form_validation = explode('.', $type);
        if(!array_key_exists(1, $form_validation))
            return 'Media type invalid';
        
        $form_name = $form_validation[0];
        $field_name= $form_validation[1];
        
        $form = config_item($form_validation[0]);
        if(!$form || !array_key_exists($field_name, $form))
            return 'Media type form not found';
        
        $field = $form[$field_name];
        $input = $field['input'];
        
        if(array_key_exists('file_type', $input))
            $file_type = $input['file_type'];
        else
            $file_type = 'jpg|jpeg|gif|png|bmp|avi|mp4|mpeg|mkv';
        
        $config['upload_path'] = $target['local_file_folder'];
        $config['allowed_types'] = $file_type;
        $config['file_name'] = $target['local_file'];
        $config['file_ext_tolower'] = true;
        
        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);
        
        if(!$this->CI->upload->do_upload($name))
            return $this->CI->upload->display_errors('','');
        
        $target['media_id'] = $this->_saveToDB($target, $type, $object);
        
        return $target;
    }
    
    /**
     * Process URL based file.
     * @param string url The url where the file should be downloaded.
     * @param string type The media type. The name of rule on form_validation.
     * @param integer object The object id this file belongs to.
     * @return as of _prepareTargetDir or false.
     */
    public function processURL($url, $type, $object=null){
        $this->CI->load->config('form_validation');
        
        $form_validation = explode('.', $type);
        $form_name = $form_validation[0];
        $field_name= $form_validation[1];
        $form = config_item($form_validation[0]);
        $field = $form[$field_name];
        $input = $field['input'];
        $file_type = 'jpg|jpeg|gif|png|gif';
        
        if(array_key_exists('file_type', $input))
            $file_type = $input['file_type'];
        
        $file_types = explode('|', $file_type);
        
        $url_ext = explode('.', $url);
        $url_ext = end($url_ext);
        $url_ext = strtolower($url_ext);
        
        if(!in_array($url_ext, $file_types))
            return 'The filetype you are attempting to download is not allowed.';
        
        $cu = curl_init($url);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cu, CURLOPT_FOLLOWLOCATION, 1);
        $binary = curl_exec($cu);
        curl_close($cu);
        
        $local_temp = tempnam("/tmp", "admu");
        $f = fopen($local_temp, 'w');
        fwrite($f, $binary);
        fclose($f);
        
        $result = $this->processLocal($local_temp, basename($url), $type, $object);
        unlink($local_temp);
        
        return $result;
    }
    
    /**
     * Resize image
     * @param string original Absolute path to original file.
     * @param string target Absolute path to target new file to create.
     * @param integer width The target width.
     * @param integer height The target height.
     * @return boolean true on success, false otherwise.
     */
    public function resizeImage($original, $target, $width=0, $height=0){
        if(!file_exists($original))
            return false;
        if(file_exists($target))
            return true;
        
        if(!$width && !$height)
            return false;
        
        $this->CI->load->library('image_lib');
        
        list($ori_width, $ori_height) = getimagesize($original);
        
        $tar_width = $width  ? $width  : ceil( $ori_height * $height / $ori_width );
        $tar_height= $height ? $height : ceil( $ori_width  * $width  / $ori_height);
        
        $v_fact = $height / $ori_height;
        $h_fact = $width / $ori_width;
        
        $im_fact = max($v_fact, $h_fact);
        
        $resize_height = ceil($ori_height * $im_fact);
        $resize_width  = ceil($ori_width  * $im_fact);
        
        if(!$height)
            $tar_height = $resize_height;
        if(!$width)
            $tar_width  = $resize_width;
        
        $config['image_library']    = 'gd2';
        $config['source_image']     = $original;
        $config['new_image']        = $target;
        $config['quality']          = '90%';
        $config['maintain_ratio']   = TRUE;
        $config['width']            = $resize_width;
        $config['height']           = $resize_height;
        
        $this->CI->image_lib->initialize($config);
        if(!$this->CI->image_lib->resize())
            return false;
        
        if($tar_width == $resize_width && $tar_height == $resize_height)
            return true;
        
        $config['source_image']     = $target;
        $config['create_thumb']     = FALSE;
        $config['maintain_ratio']   = FALSE;
        $config['x_axis']           = $tar_width  < $resize_width  ? ceil( $resize_width / 2 - ( $tar_width / 2 ) ) : 0;
        $config['y_axis']           = $tar_height < $resize_height ? ceil( $resize_height / 2 - ( $tar_height / 2 ) ) : 0;
        $config['width']            = $tar_width;
        $config['height']           = $tar_height;
        
        $this->CI->image_lib->initialize($config);
        if(!$this->CI->image_lib->crop())
            return false;
        return true;
    }
}