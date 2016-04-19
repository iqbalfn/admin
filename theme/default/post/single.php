<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->post_single($post); ?>
</head>
<body>
    <pre><?php print_r($post); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>