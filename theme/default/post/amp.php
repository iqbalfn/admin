<!doctype html>
<html ⚡>
<head>
    <meta charset="utf-8">
    <title><?= $post->title ?> - <?= ci()->setting->item('site_name') ?></title>
    <link rel="canonical" href="<?= base_url($post->page) ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <style amp-custom></style>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "<?= ($post->seo_schema->value ? $post->seo_schema : 'Article') ?>",
      "headline": "<?= $post->title->clean() ?>",
      "image": [
        "<?= $post->cover ?>"
      ],
      "datePublished": "<?= $post->published->format('c') ?>"
    }
    </script>
    
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <?php foreach($post->components as $comp): ?>
    <script async custom-element="<?= $comp ?>" src="https://cdn.ampproject.org/v0/<?= $comp ?>-0.1.js"></script>
    <?php endforeach; ?>
    <?php $ga_code = ci()->setting->item('code_google_analytics'); ?>
    <?php if($ga_code): ?>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <?php endif; ?>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>
<body>
    <?php if($ga_code): ?>
    <amp-analytics type="googleanalytics" id="analytics1">
        <script type="application/json">
        {
        "vars": {
            "account": "<?= $ga_code ?>"
        },
        "triggers": {
            "default pageview": {
            "on": "visible",
            "request": "pageview"
            }
        }
        }
        </script>
    </amp-analytics>
    <?php endif; ?>
    
    <pre><?php print_r($post->amp_content); ?></pre>
</body>
</html>