<!doctype html>
<html ⚡>
<head>
    <?php $this->meta->post_amp($post, $post->components); ?>
    <style amp-custom></style>
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
    <pre><?php print_r($post); ?></pre>
</body>
</html>