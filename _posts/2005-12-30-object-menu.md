---
layout: post
title: ObjectMenu
category: Object
---

Ini adalah properti yang dimiliki object menu. Masing-masing object menu memiliki
properti seperti di bawah:

* `id` *Integer*
* `group` *String*  
Nama grup menu.
* `label` *String*  
Menu label.
* `url` *String*  
Target URL menu.
* `parent` *Integer*  
Parent ID menu.
* `index` *Integer*  
Nomor urut menu.
* `created` *Date*  
Tanggal pembuatan menu.
* `active` *Boolean*  
Identitas jika menu ini aktif.
* `submenu_active` *Boolean*  
Identitas jika salah satu submenu aktif.

## Contoh

{% highlight html %}
stdClass Object
(
    [id] => 10
    [group] => top-menu
    [label] => Parent One
    [url] => /parent1
    [parent] => 1
    [index] => 0
    [created] => 2016-04-15 11:52:39
    [active] => 
    [submenu_active] => 
)
{% endhighlight %}