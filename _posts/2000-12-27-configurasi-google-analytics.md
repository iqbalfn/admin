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

## Parameter google_analytics_content_group

*Engine* CI Admin mendukung gruping konten post, untuk itu GA harus sudah bisa
menerima konten gruping dengan analytics. Untuk bisa menggunakan konten gruping,
ikuti langkah seperti berikut:

1. Buka halaman Google Analytics
2. Pilih website data, contohnya `All Web Site Data` untuk project ini.
3. Pada tab paling atas, pilih menu `Admin`
4. Pada submenu `view`, pilih `Content Grouping`
5. Buat konten gruping baru dengan mengklik tombol `NEW CONTENT GROUPING`
    1. Berikan nama grup untuk project
    2. Pada field `Group by Tracking Code` klik `Enable Tracking Code`.
    3. Pastikan `Enable` sudah menunjukkan teks `On`.
    4. Pada `Select Index`, pilih index yang belum digunakan, dan nilai index
       ini yang akan kita masukan sebagai nilai parameters `google_analytics_content_group`
       dari admin panel project ini.
    5. Klik `Done`.
6. Klik `Save`
7. Edit [site params]({{ site.baseurl }}{% post_url 2002-01-02-site-params %}) dengan name `google_analytics_content_group`
   sesuai dengan index yang kita pilih pada saat pembuatan grup sebelumnya.


Proses konfigurasi Google Analytics selesai.

[Configurasi Cronjob]({{ site.baseurl }}{% post_url 2000-12-26-configurasi-cronjob %})