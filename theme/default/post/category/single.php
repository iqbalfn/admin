<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->post_category_single($category); ?>
</head>
<body>
    <pre><?php print_r($category); ?></pre>
    <pre><?php print_r($pagination); ?></pre>
    <pre><?php print_r($posts); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>