---
layout: post
title: Form Validation
---

The form validation should be put on config file named `form_validation.php`. With
the format:

{% highlight php %}
<?php

$config = array(
    
    '$form_name' => array(
        '$field_name' => array(
            'field'     => '$field_name',
            'label'     => '$label_text',
            'rules'     => '$list_of_rules',
            'input'     => array(
                'type'      => '$form_input_type',
                'prefix'    => '$prefix_label',
                'attrs'     => array($additional_attributes),
                'label'     => '$show-or-hide-label',
                'file_type' => '$list_of_filetype'
            )
        )
    )
    
);
{% endhighlight %}

$form_name
----------

The form name, the one that identify the form rule to use during validation on
controller.

{% highlight php %}
<?php

// form_validation.php
$config = array(
    'user/login' => array(  
        'name' => array(...),
        'password' => array(...)
    )
);

// User.php controller
public function login(){
    if(!($login=$this->form->validate('user/login')))
        return $this->respond('login');
}
{% endhighlight %}

$field_name
-----------

The form field name ( input name ). Validation will take $_POST[$field_name] to
validate the field.

$label_text
-----------

The form field label and title attribute.

$list_of_rules
--------------

List of rules to validate the field, separated by `|`. Please refer to 
[Form Validation Rules]({{ site.baseurl }}{% post_url 2016-02-11-form-validation-rules %})
for list of usable rules.

$list_of_filetype
-----------------

List of accepted file type for field type `image` and `file`.

$form_input_type
----------------

The form field input type, they can be one of:

1. Input Based
    1. email
    1. number
    1. password
    1. search
    1. tel
    1. text
    1. url
1. Color Chooser
    1. color
1. Date Selector
    1. date
    1. datetime
    1. month
    1. time
1. Range Selector
    1. range
1. Uploader
    1. image
    1. file
1. Textarea
    1. textarea
1. WYSIWYG
    1. tinymce
1. Dropdown Selector
    1. select
1. Checkbox
    1. boolean
    1. multiple

$prefix_label
-------------

Additional prefix for input based field. Example value `http://`.

$additional_attributes
----------------------

Array list of additional attribute to be appended to the form field.

$show-or-hide-label
-------------------

Show or hide the form field label, `false`, true to show it, 'auto' to automatically
show or hide it based on form field value.