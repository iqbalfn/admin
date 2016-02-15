---
layout: post
title: Controller Property Enum
---

Contain information about system enum

item
====

{% highlight php %}
<?php
/**
 * Get/Set enum value
 *
 * @param string group The enum group name.
 * @param mixed value The enum value, for database and query.
 *                    Required for getting enum label or setter.
 * @param string label The enum label, for user. Required for setter only.
 *
 * @return array if value and label is null,
 *         string if at value or label is not null.
 */
{% endhighlight %}