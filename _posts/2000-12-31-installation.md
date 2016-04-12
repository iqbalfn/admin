---
layout: post
title: Instalasi
category: Instalasi
---

*Engine* CI Admin sudah terintegrasi dengan google analytics, alexa dan similarweb
rank checker dan mungkin akan terus bertambah untuk mempermudah proses administrasi
website.

Hal ini yang membuat proses instalasi sedikit lebih rumit dibanding menggunakan
CMS biasa.

## Persiapan

Sebelum melakukan instalasi, pastikan server sudah terinstal dev~ di bawah:

1. ApacheHTTPD / Nginx
    1. httpd dengan .htaccess
2. PHP 5.4.x atau lebih baru
    1. libcurl
3. MySQL 5.6.x

## Proses Instalasi

1. [Clone Project dari Github]({{ site.baseurl }}{% post_url 2000-12-30-clone-project-dari-github %})
2. [Instal Database]({{ site.baseurl }}{% post_url 2000-12-29-instalasi-database %})
3. [Configurasi Google Analytics]({{ site.baseurl }}{% post_url 2000-12-28-configurasi-google-analytics %})