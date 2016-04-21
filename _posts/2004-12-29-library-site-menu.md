---
layout: post
title: Library SiteMenu
category: Library
---

Bertugas memenej menu di website.

### item($name)

Mendapatkan semua menu berdasarkan grup menu. Nilai yang di kembalikan adalah 
daftar [ObjectMenu]({{ site.baseurl }}{% post_url 2005-12-30-object-menu %})

{% highlight php %}
<?php

$menus = $this->menu->item('top-menu');

// $menus sekarang berisi daftar lengkap menu yang berada di grup `top-menu`
// dimana masing-masing menu di grup berdasarkan `parent` nya.
print_r( $menus );
{% endhighlight %}

Contoh printah `print_r` di atas akan menghasilkan kurang lebih
seperti ini:

{% highlight html %}
Array
(
    [1] => Array
        (

            [0] => stdClass Object
                (
                    [id] => 8
                    [group] => top-menu
                    [label] => About US
                    [url] => /page/about-us
                    [parent] => 1
                    [index] => 1
                    [created] => 2016-04-15 11:38:07
                    [active] => 
                    [submenu_active] => 
                )

            [1] => stdClass Object
                (
                    [id] => 9
                    [group] => top-menu
                    [label] => Contact Us
                    [url] => /page/contact-us
                    [parent] => 1
                    [index] => 2
                    [created] => 2016-04-15 11:38:17
                    [active] => 1
                    [submenu_active] => 
                )

        )

    [0] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 1
                    [group] => top-menu
                    [label] => Depan
                    [url] => /
                    [parent] => 0
                    [index] => 1
                    [created] => 2016-04-15 11:22:52
                    [active] => 
                    [submenu_active] => 1
                )

        )
)
{% endhighlight %}