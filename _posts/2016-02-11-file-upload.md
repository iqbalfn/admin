---
layout: post
title: File Upload
---

This is the best way to do file upload.

List of properties on request that need to be exists:

1. `file` *Blob* The file that is uploaded.
2. `name` *String* The original file name.
3. `type` The rule name to use to validate the file. It need to contain `file_type` property.
See [Form Validation]({% post_url 2016-02-11-form-validation %}) for more information.
4. `object` The owner id of the file.

The respond on success will be:

{% highlight javascript %}
{
   "data":{
      "id":4,
      "original_name":"profile.jpg",
      "media_file":"\/media\/55\/03\/d6\/5503d626c067fcd31ac5f85588775309.jpg",
      "media_folder":"\/media\/55\/03\/d6\/",
      "file_ext":"jpg",
      "file":"5503d626c067fcd31ac5f85588775309.jpg",
      "file_name":"5503d626c067fcd31ac5f85588775309"
   },
   "error":false
}
{% endhighlight %}