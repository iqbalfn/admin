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
                    <?php if(ci()->can_i('create-post_tag')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/post/tag/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <?php 
                    $can_edit = ci()->can_i('update-post_tag');
                    foreach($tags as $tag): ?>
                    <div class="col-md-4">
                        <div class="list-group">
                            <?php if($can_edit): ?>
                            <a href="<?= base_url('/admin/post/tag/' . $tag->id) ?>" class="list-group-item">
                            <?php else: ?>
                            <div class="list-group-item">
                            <?php endif; ?>
                                <h4 class="list-group-item-heading"><?= $tag->name ?></h4>
                                <p class="list-group-item-text"><?= base_url($tag->page) ?></p>
                            <?= ($can_edit ? '</a>' : '</div>') ?>
                            <a href="<?= base_url($tag->page) ?>" class="list-group-closer btn btn-default btn-xs"><i class="glyphicon glyphicon-new-window"></i></a>
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