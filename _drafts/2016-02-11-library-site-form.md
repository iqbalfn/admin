---
layout: post
title: Library SiteForm
---

To handle various admin form.

Usage
-----

{% highlight php %}
<?php

// somewhere on controller method
public function edit(){
    $this->load->library('SiteForm', '', 'form');
    $this->form->setForm($form_name);

    $params = array();

    if(!($object = $this->form->validate($preset_object)))
        return $this->respond($params);

    /* $object is now contain new object value, insert or update DB. */
}

{% endhighlight %}


field
=====

{% highlight php %}
<?php
/**
 * Create field element.
 * @param string name The field name.
 * @param array options List of value-label pair of the options.
 * @return string html tag of the input form
 */
{% endhighlight %}


focusInput
==========

{% highlight php %}
<?php
/**
 * Script that create script to focus error element or first element.
 * @return string javascript
 */
{% endhighlight %}


setError
========

{% highlight php %}
<?php
/**
 * Set error
 * @param string name The field name.
 * @param string error The error message.
 * @return $this
 */
{% endhighlight %}


setForm
=======

{% highlight php %}
<?php
/**
 * Set current active form
 * @param string name The form name.
 * @return $this
 */
{% endhighlight %}


setObject
=========

{% highlight php %}
<?php
/**
 * Set the object
 * @param object object The form object.
 * @return $this
 */
{% endhighlight %}


validate
========

{% highlight php %}
<?php
/**
 * Validate the form based on posted data.
 * @param preset_object The preset object that need to ignore on same.
 * @return array field-value pair of new data
 * @return false on error found
 * @return true on no error and no new data exists.
 */
{% endhighlight %}