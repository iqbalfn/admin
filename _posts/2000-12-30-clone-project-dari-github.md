---
layout: post
title: Clone Project dari Github
category: Instalasi
---

*Source Code* CI Admin di simpan di github dengan lisensi MIT. Silahkan *clone* 
atau unduh versi zip nya untuk mulai menggunakan engine ini.

Masuk ke folder dimana Anda ingin meng-install *engine* ini, dan jalankan perintah 
di bawah untuk meng-*clone* project dari github.

{% highlight bash %}
git clone git@github.com:iqbalfn/admin.git .
rm -Rf .git
{% endhighlight %}

Baris kedua untuk memastikan project yang baru Anda unduh tidak terhubung lagi
dengan project CI Admin di github.

Begitu project ter-*clone* atau ter-*extract* jika Anda mengunduh versi zip, Anda
seharusnya melihat struktur folder seperti di bawah:

    .gitignore
    .htaccess
    env
    index.php
    LICENSE
    README.md
    _dev/
    application/
    media/
    protected/
    theme/

[Instal Database &#187;]({{ site.baseurl }}{% post_url 2000-12-29-instalasi-database %})