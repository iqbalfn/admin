<!DOCTYPE html>
<html>
<head>
    <?= $this->ometa->post_tag($tag); ?>
</head>
<body>
    <pre><?php print_r($tag); ?></pre>
    <pre><?php print_r($pagination); ?></pre>
    <pre><?php print_r($posts); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>