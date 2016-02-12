---
layout: post
title: Controller Methods
---

ajax
----

{% highlight php %}
<?php
/**
 * Return to client as ajax respond.
 *
 * @param mixed data The data to return.
 * @param mixed error The error data.
 * @param mixed append Additional data to append to result.
 */
{% endhighlight %}

enum
----

{% highlight php %}
<?php
/**
 * The system enum setter/getter
 *
 * @param mixed group The enum group name.
 * @param mixed value The option value, for setter label, or label getter.
 * @param mixed label The option label, for setter label only
 */
{% endhighlight %}

redirect
--------

{% highlight php %}
<?php
/**
 * Redirect to some URL.
 *
 * @param string next Target URL.
 * @param integer status Redirect status.
 */
{% endhighlight %}

respond
-------

{% highlight php %}
<?php
/**
 * Print page.
 * @param string view The view to load.
 * @param array params The parameters to send to view.
 */
{% endhighlight %}

setting
-------

Get or set system setting. Saving won't save it to database anyway. See
[Site Params]({{ site.baseurl }}{% post_url 2016-02-11-site-params %}) for preset
site setting ( site params ).

{% highlight php %}
<?php
/**
 * Get or set system setting
 *
 * @param string name The setting name.
 * @param mixed value The value, only for setter.
 *
 * @return mixed setting value.
 */
{% endhighlight %}

show_404
--------

{% highlight php %}
<?php
/**
 * Print 404 page
 */
{% endhighlight %}