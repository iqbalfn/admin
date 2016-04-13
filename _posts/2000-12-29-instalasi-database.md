---
layout: post
title: Instalasi Database
category: Instalasi
---

Database yang didukung oleh *engine* CI Admin untuk adalah MySQL v5.6.x:

Buatkan sebuat database untuk engine ini, bisa dengan CLI atau dengan phpMyAdmin:

{% highlight bash %}
mysql
create database `website`;
exit;
{% endhighlight %}

Kemudian import schema database dari `_dev/schema.sql`.

{% highlight bash %}
mysql website < _dev/schema.sql
{% endhighlight %}

Ubah data di `_dev/data.sql` ( optional ). Atau bisa juga diubah dari admin panel
ketika proses instalasi selesai. Kemudian import data tabel dari file tersebut:

{% highlight bash %}
mysql website < _dev/data.sql
{% endhighlight %}

Kemudian edit koneksi database di file `application/config/database.php`.

Hapus folder `_dev` untuk memastikan data tabel Anda aman.

[Configurasi Instalasi &#187;]({{ site.baseurl }}{% post_url 2000-12-28-configurasi-instalasi %})