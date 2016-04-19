<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->event_single($event); ?>
</head>
<body>
    <pre><?php print_r($event); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>