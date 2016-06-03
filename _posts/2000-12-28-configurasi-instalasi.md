---
layout: post
title: Configurasi Instalasi
category: Instalasi
---

Begitu project sudah di clone dan database sudah di install, engine perlu tahu
nama domain mana yang diakui oleh server. Buka file `application/config/config.php`
dan isikan nama domain project ini di bagian `$config['base_url']` pada baris `~46`.
Isikan dengan format `http://NAMADOMAIN.EXT/`. Nilai config ini harus full website
dan dengan diakhiri '/'.

Pastikan folder `./media` dan `./application/cache` bisa dibaca dan ditulis oleh
user yang menjalankan script PHP.

Jika Anda ingin menggunakan system ini untuk TimeZone yang bukan area `Asia/Jakarta`,
ubah juga konfigurasi timezone di file `application/config/config.php` di bagian
`$config['time_reference']` pada baris `~501`.

Selanjutnya, edit konfigurasi `.htaccess` jika Anda menggunakan ApacheHTTP. Hilangkan
tanda `#` di baris 3 and 4 untuk mengalihkan semua request dari website versi `www`
ke non `www`.

Jika Anda langsung ingin menggunakan env produksi, sunting juga file `./env` ubah
isinya menjadi `production`. Tapi jika masih dalam proses development, biarkan
nilai file ini menjadi `development`.

Hilangkan juga tanda tersebut di baris 11 sampai 32 jika aplikasi CI Admin sudah 
dimasukan ke env produksi, tapi jika masih dalam proses development sebaiknya
tambahkan tanda pagar tersebut. Fungsi baris 11 sampai 32 adalah untuk men-cache
file static seperti javascript, css, dan gambar.

Tambahkan tema baru ke folder `/theme`.

Lanjutkan dengan konfigurasi site setting dari admin panel. Masuk ke `http://NAMADOMAIN.EXT/admin`
dan login dengan nama `root` dan password `123456`. Kemudian klik menu `Setting > Site Params`.
Edit semua data setting sesuai kebutuhan. Lihat [Site Params]({{ site.baseurl }}{% post_url 2002-01-02-site-params %})
untuk informasi lebih lanjut tentang masing-masing konfigurasi.

[Configurasi Google Analytics &#187;]({{ site.baseurl }}{% post_url 2000-12-27-configurasi-google-analytics %})