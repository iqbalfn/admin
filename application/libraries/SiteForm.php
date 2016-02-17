<?php

class SiteForm
{
    private $CI;
    
    private $object;
    
    private $form = [];
    private $errors = [];
    
    private $field;
    private $input;
    private $input_error;
    private $input_id;
    private $input_label;
    private $input_label_show;
    private $input_name;
    private $input_options;
    private $input_type;
    private $input_value;
    
    function __construct(){
        $this->CI =&get_instance();
        
        $this->CI->load->library('form_validation');
        $this->CI->load->config('form_validation');
    }
    
    /**
     * Generate element attributes
     * @return array name-value pair of element attributes
     */
    private function _genAttribute($preset=array()){
        $attrs = array(
            'name' => $this->input_name,
            'id'   => $this->input_id,
            'class'=> [],
            'title'=> $this->input_label,
            'placeholder' => $this->input_label
        );
        
        // get from user preset
        if(array_key_exists('attrs', $this->input)){
            foreach($this->input['attrs'] as $name => $value){
                if($name == 'class'){
                    if(is_array($value))
                        $value = implode(' ', $value);
                    $attrs['class'][] = $value;
                }else{
                    $attrs[$name] = $value;
                }
            }
        }
        
        if($preset){
            foreach($preset as $name => $value){
                if($name == 'class')
                    $attrs['class'][] = $value;
                else
                    $attrs[$name] = $value;
            }
        }
        return $attrs;
    }
    
    /**
     * Generate the HTML
     * @param array element The element to generate
     * @return string html element.
     * @example 
     *  array(
     *      'tag' => String,
     *      'attrs' => Array [
     *          String => String | [String, ...]
     *      ]
     *      'children' => [ Array, ... ]
     *  )
     */
    private function _generateHTML($el){
        if(is_string($el))
            return $el;
        
        // the attributes
        $attrs = array_key_value_or('attrs', $el, array());
        $attr = array();
        foreach($attrs as $name => $value){
            $value = is_array($value) ? implode(' ', $value) : $value;
            $attr[] = $name . '="' . $value . '"';
        }
        $attr = $attr ? ' ' . implode(' ', $attr) : '';
        
        // the tag name.
        $tag = array_key_value_or('tag', $el, 'div');
        
        // the html string
        $tx = '<' . $tag . $attr . '>';
        if(array_key_exists('children', $el)){
            
            if(!is_array($el['children']))
                $el['children'] = array($el['children']);
            
            foreach($el['children'] as $child)
                $tx.= $this->_generateHTML($child);
            
        }
        $tx.= '</' . $tag . '>';
        
        return $tx;
    }
    
    /**
     * input boolean
     */
    public function _inputBoolean(){
        // the container
        $div = array(
            'attrs' => array(
                'class' => 'checkbox'
            )
        );
        
        // the label
        $label = array(
            'tag' => 'label',
            'attrs' => array(
                'for' => $this->input_id
            ),
            'children' => $this->input_label
        );
        
        // the checkbox
        $input = array(
            'tag' => 'input'
        );
        
        $preset_attrs = array(
            'type'          => 'checkbox',
            'value'         => 1
        );
        $input['attrs'] = $this->_genAttribute($preset_attrs);
        
        if($this->input_label_show)
            $input['attrs']['aria-labelledby'] = $this->input_id . '-label';
        else
            $input['attrs']['aria-label'] = $this->input_label;
        
        $div['children'] = array($input, $label);
        return $div;
    }
    
    /**
     * general input
     */
    public function _inputGeneral(){
        $input = array(
            'tag' => 'input'
        );
        
        $preset_attrs = array(
            'type'          => $this->input_type,
            'class'         => 'form-control',
            'value'         => set_value($this->input_name, $this->input_value)
        );
        $input['attrs'] = $this->_genAttribute($preset_attrs);
        
        // input type color should use `text` instead as we're going to use
        // bootstrap-colorpicker to be able to support almost all browser
        if($this->input_type == 'color')
            $input['attrs']['type'] = 'text';
        
        if($this->input_label_show)
            $input['attrs']['aria-labelledby'] = $this->input_id . '-label';
        else
            $input['attrs']['aria-label'] = $this->input_label;
        
        // implement form rules by CI rules
        
        $input_group = false;
        $with_prefix = array_key_value_or('prefix', $this->input);
        $special_input = in_array($this->input_type, [
            'color',
            'date',
            'datetime',
            'file',
            'image',
            'month',
            'password',
            'time'
        ]);
        
        if($special_input || $with_prefix)
            $input_group = true;
        
        if(!$input_group)
            return $input;
        
        $input_group = array(
            'attrs' => array(
                'class' => ['input-group']
            ),
            'children' => array()
        );
        
        // with prefix
        if($with_prefix){
            $span = array(
                'tag' => 'span',
                'attrs' => array(
                    'class' => 'input-group-addon',
                    'id'    => $this->input_id . '-prefix'
                ),
                'children' => $with_prefix
            );
            $input['attrs']['aria-describedby'] = $this->input_id . '-prefix';
            
            $input_group['children'][] = $span;
        }
        
        // input[type=color]
        if($this->input_type == 'color'){
            $span = array(
                'tag' => 'span',
                'attrs' => array(
                    'class' => 'input-group-addon'
                ),
                'children' => '<i></i>'
            );
            
            $input_group['attrs']['class'][] = 'color-picker';
            
            $input_group['children'][] = $span;
        }
        
        $input_group['children'][] =&$input;
        
        // password with mask toggler
        if($this->input_type == 'password'){
            $span = array(
                'tag' => 'span',
                'attrs' => array(
                    'class' => 'input-group-btn'
                ),
                'children' => [
                    array(
                        'tag' => 'button',
                        'attrs' => array(
                            'class' => 'btn btn-default btn-password-masker',
                            'data-target' => $this->input_id,
                            'type' => 'button'
                        ),
                        'children' => [
                            array(
                                'tag' => 'i',
                                'attrs' => array(
                                    'class' => 'glyphicon glyphicon-eye-open'
                                )
                            )
                        ]
                    )
                ]
            );
            
            $input_group['children'][] = $span;
        }
        
        // date with date-picker
        if(in_array($this->input_type, array('date', 'datetime', 'month', 'time'))){
            $icons = array(
                'date' => 'th-list',
                'datetime' => 'calendar',
                'month' => 'th',
                'time' => 'time'
            );
            
            $span = array(
                'tag' => 'span',
                'attrs' => array(
                    'class' => 'input-group-addon'
                ),
                'children' => [
                    array(
                        'tag' => 'i',
                        'attrs' => array(
                            'class' => 'glyphicon glyphicon-' . $icons[$this->input_type]
                        )
                    )
                ]
            );
            
            $input_group['children'][] = $span;
            $input_group['attrs']['class'][] = 'date ' . $this->input_type . '-picker';
            $input['attrs']['type'] = 'text';
        }
        
        if(in_array($this->input_type, array('file', 'image'))){
            $span = array(
                'tag' => 'span',
                'attrs' => array(
                    'class' => 'input-group-btn'
                ),
                'children' => array(
                    array(
                        'tag' => 'button',
                        'attrs' => array(
                            'class' => 'btn btn-default btn-uploader',
                            'data-target' => $this->input_id
                        ),
                        'children' => array(
                            array(
                                'tag' => 'i',
                                'attrs' => array(
                                    'class' => 'glyphicon glyphicon-open-file'
                                )
                            )
                        )
                    )
                )
            );
            
            $input_group['children'][] = $span;
            $input['attrs']['type'] = 'text';
            
            // type image need image previewer
            if($this->input_type == 'image'){
                $previewer_id = $this->input_id . '-preview';
                
                $input['attrs']['data-preview'] = $previewer_id;
                
                $preview_cont = array(
                    'children' => array(
                        $input_group
                    )
                );
                
                $preview_div = array(
                    'attrs' => array(
                        'id' => $previewer_id,
                        'class' => 'form-control-preview'
                    )
                );
                
                if($this->input_value)
                    $preview_div['children'] = '<img src="' . $this->input_value . '" alt="Image">';
                
                $preview_cont['children'][] = $preview_div;
                $input_group = $preview_cont;
            }
        }
        
        return $input_group;
    }
    
    /**
     * general input
     */
    public function _inputMultiple(){
        return '';
    }
    
    /**
     * input select
     */
    public function _inputSelect(){
        $input = array(
            'tag' => 'select',
            'children' => array()
        );
        
        $preset_attrs = array(
            'class'         => 'select-box'
        );
        $input['attrs'] = $this->_genAttribute($preset_attrs);
        
        if($this->input_label_show)
            $input['attrs']['aria-labelledby'] = $this->input_id . '-label';
        else
            $input['attrs']['aria-label'] = $this->input_label;
        
        if($this->input_options){
            foreach($this->input_options as $val => $label){
                $option = array(
                    'tag' => 'option',
                    'attrs' => array(
                        'value' => $val
                    ),
                    'children' => $label
                );
                
                $input['children'][] = $option;
            }
        }
        
        return $input;
    }
    
    /**
     * input textarea
     */
    public function _inputTextArea(){
        $input = array(
            'tag' => 'textarea',
            'children' => set_value($this->input_name, $this->input_value)
        );
        
        $preset_attrs = array();
        if($this->input_type == 'textarea')
            $preset_attrs['class'] = 'form-control textarea-dynamic';
        else
            $preset_attrs['class'] = 'tinymce';
        
        $input['attrs'] = $this->_genAttribute($preset_attrs);
        
        if($this->input_label_show)
            $input['attrs']['aria-labelledby'] = $this->input_id . '-label';
        else
            $input['attrs']['aria-label'] = $this->input_label;
        
        return $input;
    }
    
    /**
     * Create field element.
     * @param string name The field name.
     * @param array options List of value-label pair of the options.
     * @return string html tag of the input form
     */
    public function field($name, $options=array()){
        if(!array_key_exists($name, $this->form))
            return '';
        
        $this->field            = $this->form[$name];
        $this->input            = $this->field['input'];
        $this->input_error      = array_key_value_or($name, $this->errors);
        $this->input_id         = 'field-' . $name;
        $this->input_label      = _l($this->field['label']);
        $this->input_label_show = true;
        $this->input_name       = $name;
        $this->input_options    = $options;
        $this->input_type       = $this->input['type'];
        
        $this->input_value = '';
        if(property_exists($this->object, $this->input_name))
            $this->input_value = $this->object->{$this->input_name};
        
        if(array_key_exists('attrs', $this->input)){
            if(array_key_exists('id', $this->input['attrs']))
                $this->input_id = $this->input['attrs']['id'];
        }
        
        // should we show the label?
        if(array_key_exists('label', $this->input)){
            $this->input_label_show = false;
            
            if($this->input['label'] === true || $this->input_error)
                $this->input_label_show = true;
        }
        
        // list of type without label
        if(in_array($this->input_type, array('boolean')))
            $this->input_label_show = false;
        
        // .form-group
        $form_group = array(
            'attrs' => array(
                'class' => ['form-group']
            ),
            'children' => array()
        );
        
        if($this->input_error)
            $form_group['attrs']['class'][] = 'has-error';
        
        // label
        if($this->input_label_show){
            $label_text = $this->input_label;
            if($this->input_error)
                $label_text = $this->input_error;
            
            $control_label = array(
                'tag' => 'label',
                'attrs' => array(
                    'for' => $this->input_id,
                    'class' => 'control-label',
                    'id' => $this->input_id . '-label'
                ),
                'children' => [$label_text]
            );
            
            $form_group['children'][] = $control_label;
        }
        
        // form input generator
        $methods = array(
            'textarea'  => '_inputTextArea',
            'tinymce'   => '_inputTextArea',
            
            'select'    => '_inputSelect',
            
            'boolean'   => '_inputBoolean',
            
            'multiple'  => '_inputMultiple'
        );
        
        $method = array_key_value_or($this->input_type, $methods, '_inputGeneral');
        
        $inp = $this->$method();
        if($inp)
            $form_group['children'][] = $inp;
        
        return $this->_generateHTML($form_group);
    }
    
    /**
     * Set error
     * @param string name The field name.
     * @param string error The error message.
     * @return $this
     */
    public function setError($name, $error){
        $this->errors[$name] = $error;
        
        return $this;
    }
    
    /**
     * Set current active form
     * @param string name The form name.
     * @return $this
     */
    public function setForm($name){
        $rules = config_item($name);
        if($rules)
            $this->form = $rules;
        return $this;
    }
    
    /**
     * Set the object
     * @param object object The form object.
     * @return $this
     */
    public function setObject($object){
        $this->object = $object;
    }
}