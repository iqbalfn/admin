---
layout: post
title: Referensi Tema
category: Tema
---

Semua tema disimpan di folder `theme`. Di folder tersebut sudah ada preset theme
yaitu `admin` untuk admin panel, `errors` untuk menampilkan pesan system error,
`default` untuk standar *front-page*, dan `robot` untuk rss feed, dan sitemap.

## Ketentuan

Penamaan tema hanya boleh menggunakan karakter `a-z, 0-9, dan '-'`. Untuk mengubah
tema, ganti nilai setting `site_theme` di [site params]({{ site.baseurl }}{% post_url 2002-01-02-site-params %})
dengan nama folder tema yang ingin digunakan.

## package.json

Semua tema membutuhkan file `package.json` yang berisi informasi singkat tentang
tema tersebut. Contoh isi dari file ini seperti di bawah:

{% highlight json %}
{
  "name": "default",
  "version": "0.0.1",
  "description": "Default CI Admin template",
  "author": "Iqbal Fauzi <iqbalfawz@gmail.com> (http://iqbalfn.com/)",
  "license": "MIT"
}
{% endhighlight %}

## preview.png

File ini juga dibutuhkan oleh tema untuk mempermudah admin melihat pratampil tema
yang ingin digunakan. File `preview.png` diharapkan berukuran 500x500 pixel.

## Halaman Home

File ini adalah file yang di panggil ketika user sampai di halaman depan website.
Tidak ada data yang di kirim dari controller ke halaman ini, silah minta ke dev~
untuk menyediakan data yang di butuhkan tema.

## Halaman 404

Setiap tema membutuhkan file `404.php` untuk menampilkan halaman *Not found* jika
terjadi. Tidak ada parameter dari controller yang di kirim ke halaman ini. Sebaiknya
gunakan halaman ini hanya untuk menampilkan pesan error, dan bukan daftar posts.

## Folder Static

Folder `static` digunakan untuk menyimpan semua file-file static tema, seperti
file javascript, css, dan gambar. Di dalam folder ini **harus** ada subfolder 
`image` yang di dalamnya berisi folder `logo`. Folder logo tersebut kemudian berisi
logo-logo website dalam berbagai ukuran dan format untuk memenuhi berbagai kebutuhan
robot. Lihat di struktur folder untuk lebih jelas nama-nama logo dan ukurannya.

Sebaiknya file-file javascript di simpan di folder `static/js`, gambar
di `static/image`, font di `static/fonts`, dan css di `static/css`.

## Struktur Folder

Semua tema untuk *front-page* membutuhkan file-file dibawah:

* {nama-tema}/
    * 404.php
    * home.php
    * package.json
    * preview.png
    * [event/]({{ site.baseurl }}{% post_url 2001-12-25-tema-event %})
        * single.php
    * [gallery/]({{ site.baseurl }}{% post_url 2001-12-24-tema-gallery %})
        * single.php
    * [page/]({{ site.baseurl }}{% post_url 2001-12-23-tema-page %})
        * single.php
    * [post/]({{ site.baseurl }}{% post_url 2001-12-22-tema-post %})
        * single.php
        * [category/]({{ site.baseurl }}{% post_url 2001-12-21-tema-post-category %})
            * single.php
        * [tag/]({{ site.baseurl }}{% post_url 2001-12-20-tema-post-tag %})
            * single.php
    * [user/]({{ site.baseurl }}{% post_url 2001-12-19-tema-user %})
        * single.php
    * static/
        * image/
            * logo/
                * apple-touch-icon.png [ 100x100 ]
                * apple-touch-icon-72x72.png [ 72x72 ]
                * apple-touch-icon-114x114.png [ 114x114 ]
                * feed.jpg [ 72x72 ]
                * logo.png [ 500x500 ]
                * logo-200x60.png [ 200x60 ]
                * shortcut-icon.png [ 48x48 ]

