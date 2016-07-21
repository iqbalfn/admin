<!DOCTYPE html>
<html>
<head>
    <?= $this->ometa->user($user); ?>
</head>
<body>
    <pre><?php print_r($user); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>