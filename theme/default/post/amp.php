<!doctype html>
<html ⚡>
<head>
    <?= $this->ometa->post_amp($post); ?>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>
    <noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <?php if($post->components): ?>
        <?php foreach($post->components as $comp): ?>
        <script async custom-element="<?= $comp ?>" src="https://cdn.ampproject.org/v0/<?= $comp ?>-0.1.js"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <style amp-custom>
    .container{ font:15px/29px arial;width:95%;margin:0 auto;}
    #main { padding-top:10px;}
    #main h1{ line-height:34px;}
    #header{ background-color:#343334;padding:10px 0;}
    #header h2{ margin:0;padding:0;font-weight:400;font-size:20px;}
    #header h2 a{ color:white;text-decoration:none;}
    #link-back{background-color:#e3a01b;color:white;font-weight:700;display:block;padding:10px;text-align:center;margin:10px 0;text-decoration:none;}
    </style>
</head>
<body>
    <?php
        $ga_code = ci()->setting->item('code_google_analytics');
        if($ga_code){
            echo '<amp-analytics type="googleanalytics" id="analytics1">';
            echo '<script type="application/json">{"vars":{"account": "' . $ga_code . '"},"triggers":{"default pageview":{"on":"visible","request":"pageview"}}}</script>';
            echo '</amp-analytics>';
        }
    ?>
    
    <div id="header">
        <div class="container"><h2><a href="<?= base_url($post->page) ?>"><?= ci()->setting->item('site_name') ?></a></h2></div>
    </div>
    
    <div class="container" id="main">
        <amp-img src="<?= $post->cover->_400x250 ?>" alt="<?= $post->title->clean() ?>" width="400" height="250" layout="responsive"></amp-img>
        <h1><?= $post->title->clean(); ?></h1>
        <div><?= $post->published->format('M d, Y') ?></div>
        <?= $post->amp_content ?>
        <a href="<?= base_url($post->page) ?>" id="link-back">Baca Original Artikel</a>
    </div>
</body>
</html>