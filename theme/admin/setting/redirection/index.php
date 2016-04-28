<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->theme->file('head') ?>
</head>
<body>
    <?= $this->theme->file('header') ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <?php if(ci()->can_i('create-url_redirection')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/setting/redirection/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                    <?php $editable = ci()->can_i('update-url_redirection'); ?>
                    <?php foreach($urls as $url): ?>
                        <div class="list-group">
                            <?php if($editable): ?>
                            <a href="<?= base_url('/admin/setting/redirection/' . $url->id ) ?>" class="list-group-item">
                                <h4 class="list-group-item-heading"><?= $url->source ?></h4>
                                <p class="list-group-item-text"><?= $url->target ?></p>
                            </a>
                            <?php else: ?>
                            <div class="list-group-item">
                                <h4 class="list-group-item-heading"><?= $url->source ?></h4>
                                <p class="list-group-item-text"><?= $url->target ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>