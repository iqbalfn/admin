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

create
======

{% highlight php %}
<?php
/**
 * Insert new row to the table.
 *
 * @param array row The row to insert.
 *
 * @return integer id The new created id or false
 */
{% endhighlight %}

create_batch
============

{% highlight php %}
<?php
/**
 * Insert multiple rows at once.
 *
 * @param array rows List of the row to insert.
 *
 * @return number of inserted rows or false.
 */
{% endhighlight %}

get
===

{% highlight php %}
<?php
/**
 * Get row(s) by id.
 *
 * @param integer|array id The row(s) id.
 * @param integer total Total row to get, default to 1.
 * @param integer page Page number, only if `$total` is not 1 and not true.
 * @param array order field-order pair of the row to order. default id = DESC
 *
 * @return object if $total = [ 1 or true ]
 *         array if $total > 1
 *         false otherwise.
 */
{% endhighlight %}

getBy
=====

{% highlight php %}
<?php
/**
 * Get row(s) by some table field.
 *
 * @param string field The field name.
 * @param mixed|array value The `$field` row(s) value.
 * @param integer total Total row to get, default to 1.
 * @param integer page Page number, only if total is not 1 and not true.
 * @param array order field-order pair of the row to order. default id = DESC
 *
 * @return object if $total = [ 1 or true ]
 *         array if $total > 1
 *         false otherwise.
 */
{% endhighlight %}

getByCond
=========

{% highlight php %}
<?php
/**
 * Get row(s) by condition.
 *
 * @param string field The field name.
 * @param mixed|array value The `$field` row(s) value.
 * @param integer total Total row to get, default to true which mean all.
 * @param integer page Page number, only if total is not 1 and not true.
 * @param array order field-order pair of the row to order. default id = DESC
 *
 * @return object if $total = [ 1 or true ]
 *         array if $total > 1
 *         false otherwise.
 */
{% endhighlight %}

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

inc
===

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
=====

{% highlight php %}
<?php
/**
 * Increase table field by 1 by table field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
 * @param string field The field name to update.
 * @param integer total Total number the field to increase.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

incByCond
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

dec
===

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
=====

{% highlight php %}
<?php
/**
 * Decrease table field by 1 by table field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
 * @param string field The field name to update.
 * @param integer total Total number the field to decrease.
 *
 * @return true on success, false otherwise.
 */
{% endhighlight %}

decByCond
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

set
===

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
=====

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
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

remove
======

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
========

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
============

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

max
===

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
=====

{% highlight php %}
<?php
/**
 * Get max value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
 * @param string field The field name to calculate.
 *
 * @return integer max number or false.
 */
{% endhighlight %}

maxByCond
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

min
===

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
=====

{% highlight php %}
<?php
/**
 * Get min value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
 * @param string field The field name to calculate.
 *
 * @return integer min number or false.
 */
{% endhighlight %}

minByCond
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

count
=====

{% highlight php %}
<?php
/**
 * Get total rows
 *
 * @return integer total rows or false.
 */
{% endhighlight %}

countBy
=======

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
===========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

avg
===

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
=====

{% highlight php %}
<?php
/**
 * Get avg value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
 * @param string field The field name to calculate.
 *
 * @return integer average number or false.
 */
{% endhighlight %}

avgByCond
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.

sum
===

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
=====

{% highlight php %}
<?php
/**
 * Get sum value of field by field.
 *
 * @param string where_field The field for condition.
 * @param mixed|array value The row `$where_field` value or list of `$where_field` values.
 * @param string field The field name to calculate.
 *
 * @return integer sum number or false.
 */
{% endhighlight %}

sumByCond
=========

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

Read [model condition]({{ site.baseurl }}{% post_url 2016-02-11-model-condition %})
for more information about `$cond` parameter.