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

show_404
--------

{% highlight php %}
<?php
/**
 * Print 404 page
 */
{% endhighlight %}