<!DOCTYPE html>
<html>
<head>
    <?= $this->ometa->event($event) ?>
</head>
<body>
    <pre><?php print_r($event); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>