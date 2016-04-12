---
layout: post
title: Controller Property Theme
---

Contain information and method required by theme.

current
=======

{% highlight php %}
<?php
/**
 * Get current used theme.
 *
 * @param string name The view name to append to the current theme name.
 * @return string current theme, optionally with suffix $name.
 *
 */
{% endhighlight %}

file
====

{% highlight php %}
<?php
/**
 * Load the theme file based on current active theme.
 *
 * @param string name The view name.
 * @param array params List of var-value pair of data to send to view.
 *
 * @return string the view html content
 */
{% endhighlight %}

load
====

{% highlight php %}
<?php
/**
 * Load the theme view
 *
 * @param string name The view name.
 * @param array params List of var-value data to send to view.
 * @param boolean return Return the HTML instead of print it to output buffer.
 *
 * @return string html on $return, void otherwise.
 */
{% endhighlight %}

static
======

{% highlight php %}
<?php
/**
 * Get absolute path to theme static file.
 *
 * @param string name The theme static file name.
 *
 * @return string absolute path to theme static file.
 */
{% endhighlight %}