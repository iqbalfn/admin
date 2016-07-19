<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->home(); ?>
</head>
<body>
    <pre><?php
    $tx = str_replace('><', ">\n<", $this->ometa->home());
    echo hs($tx); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>