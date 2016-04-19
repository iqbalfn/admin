<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->user_single($user); ?>
</head>
<body>
    <pre><?php print_r($user); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>