<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->post_single($post); ?>
</head>
<body>
    <pre><?php
    $tx = str_replace('><', ">\n<", $this->ometa->post($post));
    echo hs($tx); ?></pre>
    <pre><?php print_r($post); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>