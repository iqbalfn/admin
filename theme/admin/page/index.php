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
                    <?php if(ci()->can_i('create-page')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/page/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                    <?php foreach($pages as $page): ?>
                        <div class="btn-group btn-group-lg" role="group">
                            <a href="<?= base_url('/admin/page/' . $page->id) ?>" class="btn btn-default"><?= $page->title ?></a>
                            <a href="<?= base_url($page->page) ?>" target="_blank" class="btn btn-default"><i class="glyphicon glyphicon-new-window"></i></a>
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