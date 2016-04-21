---
layout: post
title: Library SiteTheme
category: Library
---

Library ini terload otomatis dan bisa langsung digunakan di tema atau di controller.
Bertugas mengangi semua yang berhubungan dengan tema.

### current([$name=''])

Mendapatkan tema yang sedang aktif. Optional menambahkan nama file/folder setelah
nama tema.

{% highlight php %}
<?php

// default
$theme = $this->theme->current();

// default/home.php
$theme_file = $this->theme->current('home.php');

// default/post/single.php
$theme_post = $this->theme->current('post/single.php');
{% endhighlight %}

### exists($name)

Cek jika tema file ada di folder tema.

{% highlight php %}
<?php

// check jika tema file dengan nama post/single.php ada
// hasilnya trus jika file di [nama_tema]/post/single.php ada.
$is_exists = $this->theme->exists('post/single');

{% endhighlight %}

### file($name[, $params=null])

Load tema file dengan optional parameters di kirim ke tema file.

{% highlight php %}
<header>
    <!-- print content dari file [nama_tema]/header.php di sini -->
    <?= $this->theme->file('header'); ?>
</header>
{% endhighlight %}

### load($name[, $params=null[, $return=false]])

Alternatif untuk `file` dengan optional return atau print. Set nilai property
`return` ke false akan memprint content.

{% highlight php %}
<header>
    <!-- print content dari file [nama_tema]/header.php di sini -->
    <?php $this->theme->load('header'); ?>
</header>
{% endhighlight %}

### asset($file)

Mendapatkan absolute URL ke theme asset. Digunakan untuk mencetak url seperti file
gambar, css, atau javascript.

{% highlight php %}
<?php $css_file = $this->theme->asset('static/css/style.css'); ?>
<link rel="stylesheet" href="<?= $css_file ?>">
{% endhighlight %}

Hasil akhir script di atas menjadi:

{% highlight php %}
<link rel="stylesheet" href="http://web.com/theme/default/static/css/style.css">
{% endhighlight %}