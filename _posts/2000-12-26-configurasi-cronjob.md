---
layout: post
title: Configurasi Cronjob
category: Instalasi
---

Untuk penyempurnaan system, dan management data, *Engine* CI Admin perlu melakukan
hal-hal di bawah diluar dari standar user request. Untuk itu, system perlu mendaftarkan
beberapa cronjob/crontab agar semua kebutuhan *engine* ini terpenuhi.

Buatkan cronjob/crontab untuk memanggil URL dibawah sesuai waktu yang di tentukan:

{% highlight bash %}
NO | MINUTE | HOUR | DAY | MONTH | WEEKDAY | COMMANT
---+--------+------+-----+-------+---------+------------------------------------
 1 | 0      | *    | *   | *     | *       | curl HOSTNAME/admin/post/publish
 2 | 0      | 2    | *   | *     | *       | curl HOSTNAME/admin/post/trending
 3 | 0      | 0,12 | *   | *     | *       | curl HOSTNAME/admin/stat/calculate/alexa
 4 | 0      | 0,12 | *   | *     | *       | curl HOSTNAME/admin/stat/calculate/similarweb
{% endhighlight %}

Keterangan:

1. Mempublish semua scheduled post yang sudah seharusnya di publish.
2. Menghitung ulang semua trending post.
3. Menghitung ranking alexa perhari ini.
4. Menghitung ranking similarweb perhari ini.