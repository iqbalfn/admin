<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->event_single($event); ?>
</head>
<body>
    <pre><?php
    $tx = str_replace('><', ">\n<", $this->ometa->event($event));
    echo hs($tx); ?></pre>
    <pre><?php print_r($event); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>