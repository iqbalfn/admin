---
layout: post
title: Model Methods
---

Example:
=======

{% highlight php %}
<?php

$this->load->model('User_model', 'User');

// Create new user
$user = array('name' => 'iqbal', 'fullname' => 'Iqbal Fauzi');
$user['id'] = $this->User->create($user);

// Get user by id
$user = $this->User->get($user['id']);
{% endhighlight %}

For every `$cond` parameters, pleaser refer to [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information.

avg
---

{% highlight php %}
<?php
/**
 * Get avg value of field.
 *
 * @param string field The field name to calculate.
 *
 * @return integer average or false.
 */
{% endhighlight %}

avgBy
-----

{% highlight php %}
<?php
/**
 * Get avg value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to calculate.
 *
 * @return integer average number or false.
 */
{% endhighlight %}

avgByCond
---------

{% highlight php %}
<?php
/**
 * Get avg value of field by field.
 *
 * @param array cond The conditions.
 * @param string field The field name to calculate.
 *
 * @return integer avg number or false.
 */
{% endhighlight %}

count
-----

{% highlight php %}
<?php
/**
 * Get total rows
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

countBy
-------

{% highlight php %}
<?php
/**
 * Get total rows by fields
 *
 * @param string field The field for condition.
 * @param mixed|array value The row `$field` value or list of `$field` values.
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

countByCond
-----------

{% highlight php %}
<?php
/**
 * Get total rows by conditions
 *
 * @param array cond The conditions.
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

countGrouped
------------

{% highlight php %}
<?php
/**
 * Get total rows
 *
 * @param string field The field to group by
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

countGroupedBy
--------------

{% highlight php %}
<?php
/**
 * Get total rows by fields
 *
 * @param string where_field The field for condition
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field for condition.
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

countGroupedByCond
------------------

{% highlight php %}
<?php
/**
 * Get total rows by conditions
 *
 * @param array cond The conditions.
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

create
------

{% highlight php %}
<?php
/**
 * Create new row
 *
 * @param array row The row to insert
 *
 * @return integer inserted id or false.
 */
{% endhighlight %}

create_batch
------------

{% highlight php %}
<?php
/**
 * Create multiple rows at once.
 *
 * @param array list of new rows to insert.
 *
 * @return number of inserted row or false.
 */
{% endhighlight %}

dec
---

{% highlight php %}
<?php
/**
 * Decrease table field by 1 by id.
 *
 * @param integer|array id The row id or list of row id.
 * @param string field The field name to update.
 * @param integer total Total number the field to decrease.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

decBy
-----

{% highlight php %}
<?php
/**
 * Decrease table field by 1 by table field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to update.
 * @param integer total Total number the field to decrease.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

decByCond
---------

{% highlight php %}
<?php
/**
 * Decrease table field by 1 by conditions
 *
 * @param array cond The conditions.
 * @param string field The field name to update.
 * @param integer total Total number the field to decrease.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

get
---

{% highlight php %}
<?php
/**
 * Get row(s) by id 
 *
 * @param integer|array the row id or list of row ids.
 * @param integer total Total row to get. Default 1.
 * @param integer page Page number, default 1.
 * @param array order The order condition. Default id => DESC
 *
 * @return object row or array list of object rows
 */
{% endhighlight %}

getBy
-----

{% highlight php %}
<?php
/**
 * Get row(s) by field
 *
 * @param string field The field name for condition.
 * @param mixed|array value The field value or list of field value.
 * @param integer total Total number to get, default 1.
 * @param integer page The page number. Default 1.
 * @param array order The order condition
 *
 * @return array list of object rows or object row
 */
{% endhighlight %}

getByCond
---------

{% highlight php %}
<?php
/**
 * Get row(s) by condition.
 *
 * @param array cond The selection condition.
 * @param integer total Total result expected. Default 1.
 * @param integer page The page number.
 * @param array order The order condition.
 *
 * @return array list of rows or single row object.
 */
{% endhighlight %}

inc
---

{% highlight php %}
<?php
/**
 * Increase table field by 1 by id.
 *
 * @param integer|array id The row id or list of row id.
 * @param string field The field name to update.
 * @param integer total Total number the field to increase.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

incBy
-----

{% highlight php %}
<?php
/**
 * Increase table field by 1 by table field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to update.
 * @param integer total Total number the field to increase.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

incByCond
---------

{% highlight php %}
<?php
/**
 * Increase table field by 1 by conditions
 *
 * @param array cond The conditions.
 * @param string field The field name to update.
 * @param integer total Total number the field to increase.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

max
---

{% highlight php %}
<?php
/**
 * Get max value of field.
 *
 * @param string field The field name to select.
 *
 * @return integer max number or false.
 */
{% endhighlight %}

maxBy
-----

{% highlight php %}
<?php
/**
 * Get max value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to calculate.
 *
 * @return integer max number or false.
 */
{% endhighlight %}

maxBy
-----

{% highlight php %}
<?php
/**
 * Get max value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to calculate.
 *
 * @return integer max number or false.
 */
{% endhighlight %}

maxByCond
---------

{% highlight php %}
<?php
/**
 * Get max value of field by field.
 *
 * @param array cond The conditions.
 * @param string field The field name to calculate.
 *
 * @return integer max number or false.
 */
{% endhighlight %}

min
---

{% highlight php %}
<?php
/**
 * Get min value of field.
 *
 * @param string field The field name to select.
 *
 * @return integer min number or false.
 */
{% endhighlight %}

minBy
-----

{% highlight php %}
<?php
/**
 * Get min value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to calculate.
 *
 * @return integer min number or false.
 */
{% endhighlight %}

minByCond
---------

{% highlight php %}
<?php
/**
 * Get min value of field by field.
 *
 * @param array cond The conditions.
 * @param string field The field name to calculate.
 *
 * @return integer min number or false.
 */
{% endhighlight %}

remove
------

{% highlight php %}
<?php
/**
 * Remove row by id.
 *
 * @param integer|array id The row id or list of row id.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

removeBy
--------

{% highlight php %}
<?php
/**
 * Remove rows by table field.
 *
 * @param string field The field name.
 * @param mixed|array value The field value for selection.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

removeByCond
------------

{% highlight php %}
<?php
/**
 * Remove table by conditions
 *
 * @param array cond The conditions.
 * @param string fields field-value pair of new data to update to table
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

set
---

{% highlight php %}
<?php
/**
 * Update table by id.
 *
 * @param integer|array id The row id or list of row id.
 * @param array fields field-value pair of the new row data to update.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

setBy
-----

{% highlight php %}
<?php
/**
 * Update table by table field.
 *
 * @param string field The field name.
 * @param mixed|array value The field value for selection.
 * @param array fields field-value pair of new data to update to table.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

setByCond
---------

{% highlight php %}
<?php
/**
 * Update table by conditions
 *
 * @param array cond The conditions.
 * @param string fields field-value pair of new data to update to table
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

sum
---

{% highlight php %}
<?php
/**
 * Get sum value of field.
 *
 * @param string field The field name to calculate.
 *
 * @return integer sum or false.
 */
{% endhighlight %}

sumBy
-----

{% highlight php %}
<?php
/**
 * Get sum value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of the values.
 * @param string field The field name to calculate.
 *
 * @return integer sum number or false.
 */
{% endhighlight %}

sumByCond
---------

{% highlight php %}
<?php
/**
 * Get sum value of field by field.
 *
 * @param array cond The conditions.
 * @param string field The field name to calculate.
 *
 * @return integer sum number or false.
 */
{% endhighlight %}