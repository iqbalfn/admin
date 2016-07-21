<!DOCTYPE html>
<html>
<head>
    <?= $this->ometa->post_category($category); ?>
</head>
<body>
    <pre><?php print_r($category); ?></pre>
    <pre><?php print_r($pagination); ?></pre>
    <pre><?php print_r($posts); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>