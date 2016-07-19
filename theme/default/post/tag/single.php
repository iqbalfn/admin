<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->post_tag_single($tag); ?>
</head>
<body>
    <pre><?php
    $tx = str_replace('><', ">\n<", $this->ometa->post_tag($tag));
    echo hs($tx); ?></pre>
    <pre><?php print_r($tag); ?></pre>
    <pre><?php print_r($pagination); ?></pre>
    <pre><?php print_r($posts); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>