---
layout: post
title: Configurasi Google Analytics
category: Instalasi
---

*Engine* CI Admin sudah terintegrasi dengan Google Analytics untuk mempermudah
pengecekan realtime user dan visitor statistic serta penghitungan trending post
juga menggunakan google analytics. Untuk itu, CI Admin membutuhkan akses ke 
google analytics agar semua fitur di atas bisa berjalan dengan CI Admin.

Pertama, buatkan Google Analytics untuk project ini.

## Parameter code_google_analytics_view

Edit [site params]({{ site.baseurl }}{% post_url 2002-01-02-site-params %}) dengan
nama `code_google_analytics_view` dan isikan nilainya dengan kode google analytics view.

Untuk mendapatkan view id ( profile id ) Google Analytics, silahkan ikuti step di
[sini](http://iqbalfn.com/tool/2016/04/13/menemukan-google-analytics-view-id.html).

## Parameter google_analytics_statistic

Untuk parameter ini, kita akan isikan dengan nama file google analytics access json
file. Sebelum bisa menentukan nilai dari parameter ini, silahkan buatkan file ga 
access dengan cara seperti di bawah:

1. Buka [Google Developer Console](https://console.developers.google.com).
2. Di menu kanan atas, klik menu [Select a project] dan klik [Create a project...]
3. Isikan nama project baru untuk project CI Admin ini. Tunggu beberapa saat sampai
project selesai dibuatkan.
4. Pada halaman baru yang terbuka, klik navigasi [Credentials].
5. Pada popup yang muncul, klik [Create credentials], dan pilih [Service account key].
6. Pada halaman baru, di bagian [Service account], pilih [App Engine default service account].
Dan pada bagian Key type, pilih JSON. Lanjutkan dengan menekan tombol [Create].
7. Jendela unduh terbuka, simpan file yang terunduh ke folder `./protected`.
8. Lihat nama file yang baru terunduh, dan isikan nama file tersebut ke [site params]({{ site.baseurl }}{% post_url 2002-01-02-site-params %})
dengan nama `google_analytics_statistic`. Contoh nama file yang tergenerasi adalah
`ci-admin-9bb83354b929.json`.
9. Masih di halaman [Credentials], klik [Manage service account] dan copy alamat
email ( Service account ID ) yang Key ID nya bukan 'No keys'. Begitu di copy, tambahkan
email tersebut ke akun menejemen google analytics dengan akses `Read & Analyze`.
9. Kembali ke google dev~ console, pada menu sebelah kiri, klik [Overview]. Dan
pilih tab [Google APIs]. Pada form pencarian, masukan `Analytics API`, akan muncul
beberapa pilihan Analytics API. Klik `Analytics Reporting API V4` dan pada halaman
yang baru, klik [Enable]. Lakukan hal yang sama pada hasil pencarian `Analytics API`.

Proses konfigurasi Google Analytics selesai.

[Tema &#187;]({{ site.baseurl }}{% post_url 2001-12-31-referensi-tema %})