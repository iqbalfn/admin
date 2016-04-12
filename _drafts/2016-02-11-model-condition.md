---
layout: post
title: Model Condition
---

Model condition is the one that convert standart array to query where condition.
This parameters used by `getByCond`, `incByCond`, `decByCond`, `setByCond`, and
method `removeByCond` of model.

Complete Syntax:

{% highlight php %}
<?php

$cond = array(
    // WHERE `fld_0` = 1
    'fld_0' => 1,
    
    // WHERE `fld_1` IN (1,2,3)
    'fld_1' => array(1,2,3),
    
    // WHERE `fld_2` > 1
    'fld_2' => (object)array('>', 1),
    
    // WHERE `fld_3` LIKE '%lorem%'
    'fld_3' => (object)array('LIKE', 'lorem'),
    'fld_4' => (object)array('LIKE', 'lorem', 'both'),
    
    // WHERE `fld_5` LIKE '%lorem'
    'fld_5' => (object)array('LIKE', 'lorem', 'before'),
    
    // WHERE `fld_6` LIKE 'lorem%'
    'fld_6' => (object)array('LIKE', 'lorem', 'after'),
    
    // WHERE `fld_7` NOT LIKE '%lorem%'
    'fld_7' => (object)array('NOT LIKE', 'lorem'),
    
    // WHERE `fld_8` IN (1,2,3)
    'fld_8' => (object)array('IN', array(1,2,3)),
    
    // WHERE `fld_9` NOT IN (1,2,3)
    'fld_9' => (object)array('NOT IN', array(1,2,3))
);
{% endhighlight %}

Each array key become table field, while array value become field value on where
condition.