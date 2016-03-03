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
                    <?php if(ci()->can_i('create-banner')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/banner/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <?php foreach($banners as $ban): ?>
                    <div class="col-md-4">
                        <div class="list-group">
                            <a href="<?= base_url('/admin/banner/' . $ban->id ) ?>" class="list-group-item<?= ( $ban->expired->time < time() ? ' list-group-item-danger' : '' ) ?>">
                                <h4 class="list-group-item-heading"><?= $ban->name ?></h4>
                                <p class="list-group-item-text">
                                    Expired: <?= $ban->expired->format('M d, Y') ?>
                                </p>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>