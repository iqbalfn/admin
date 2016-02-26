---
layout: post
title: ObjectFormatter
---

The library that format the object to match required view. The config named `object_formatter.php`
that located at `application/config`.

Usage
-----

{% highlight php %}
<?php

// somewhere on controller
public function main(){
    $object = $this->Object->get(1); // get the object form table `object`
    $this->load->library('ObjectFormatter', '', 'format');
    if($object)
        $object = $this->format->object($object);
}
{% endhighlight %}

__call
------

To format the object, call `format->{the table name}` method, and make sure the
format config name `{the table name}` exists.

{% highlight php %}
/**
 * Start formatting the object.
 * @param object|array objects Single object or list of object to format.
 * @param boolean arraykey Set field as the array key. Default false. True for id.
 * @param array|boolean fetch List of field to format/force fetch the data from
 *  database for format type start with @.
 * @return formatted object.
 */
{% endhighlight %}

config
------

This is an example of format config in file `object_formatter.php`:

{% highlight php %}
<?php

$config['object_formatter'] = array(
    'post' => array(
        'id'        => 'integer',
        'featured'  => 'boolean'
    )
);

{% endhighlight %}

where `post` is the name of table. while other format type described as below:

### @chain[other_table]

Get the value from chained table. The other table expect to have field the same
as current table. Example usage of this format is on post category as post may
have multiple category or tag. The rule to follow:

1. Example, current table/format name is `post`, and the chained table is `post_category`.
The format on config should be `@chain[post_category]`.
2. Table named `post_category_chain` should exists.
3. Table `post_category_chain` should have field `post_category` and `post`.

### @member[other_table]

Check current user status on this table based on `other_table`. Example usage of 
this type is to check if current user is member of some group. Please follow rule
below to define the value.

1. Example current table/format name is `post`, and the member table is `post_red`
2. Table named `post_red` should have property `post` and `user`.

### @parent[other_table]

Convert the value to object that taken from `other_table` where the id of the `other_table`
is current property value.

### boolean

Convert the value to `boolean`. String '0', Integer 0, String 'false' converted to
`false`, other value converted to `true`.

### date

The value converted to `objDate` object that have `format` method. The format
method is actually short-hand for `date(format, $value)` php function with the
first parameter of is the date format.

{% highlight php %}
$object->created->format('Y-m-d') == date('Y-m-d', $object->created);
{% endhighlight %}

### delete

The property will be deleted.

### enum

The value converted to `objEnum` object. The object has `value`, and `label` property.
{% highlight php %}
$object->type->value === 1;
$object->type->label === 'Draft';
{% endhighlight %}

### integer

The value converted to standar integer, at least for now.

### join

The value and other property will be joined. Each property or string separated by comma.

{% highlight php %}
$obj = (object)array(
    'first_name' => 'Iqbal',
    'last_name'  => 'Fauzi'
);

// config
//  'obj' => array(
//      'fullname' => 'join(Mr. |$first_name| |$last_name)'
//  )

// do the format

$obj->fullname === 'Mr. Iqbal Fauzi'
{% endhighlight %}

### media

The value converted to `objMedia` that have magic method to define the size of 
the media to return. Calling the magic method will only work for image extension
file. If config named `media_host`, the result will also prefixed the config value.

{% highlight php %}
$object->cover = '/media/aa/bb/aabbccddeeffgg.png';
// do random stuff to format he object.

$object->cover->_100x150;   // /media/aa/bb/aabbccddeeffgg_100x150.png
$object->cover->_x100       // /media/aa/bb/aabbccddeeffgg_x100.png
$object->cover->_50x        // /media/aa/bb/aabbccddeeffgg_50x.png
{% endhighlight %}

### string

The value converted to standar string.

### text

The value converted to `objText` that has various method.

1. clean()  
Clean the value from all HTML tags and also remove new lines.
2. chars(*len*)  
Get the first *len* characters of the value after cleaning.
3. words(*len*)  
Get the first *len* words of the value after cleaning.