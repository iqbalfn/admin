<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->user_single($user); ?>
</head>
<body>
    <pre><?php
    $tx = str_replace('><', ">\n<", $this->ometa->user($user));
    echo hs($tx); ?></pre>
    <pre><?php print_r($user); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>