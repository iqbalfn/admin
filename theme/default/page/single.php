<!DOCTYPE html>
<html>
<head>
    <?php $this->meta->page_single($page); ?>
</head>
<body>
    <pre><?php
    $tx = str_replace('><', ">\n<", $this->ometa->page($page));
    echo hs($tx); ?></pre>
    <pre><?php print_r($page); ?></pre>
    <?= $this->meta->footer() ?>
</body>
</html>