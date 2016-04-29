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
                    <?php if(ci()->can_i('create-post_suggestion')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/post/suggestion/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <?php 
                    $can_edit = ci()->can_i('update-post_suggestion');
                    foreach($posts as $post): ?>
                    <?php $done = $post->local ? ' list-group-item-success' : ''; ?>
                    <div class="col-md-12">
                        <div class="list-group">
                            <?php if($can_edit): ?>
                            <a href="<?= base_url('/admin/post/suggestion/' . $post->id) ?>" class="list-group-item<?= $done ?>">
                            <?php else: ?>
                            <div class="list-group-item<?= $done ?>">
                            <?php endif; ?>
                                <h4 class="list-group-item-heading"><?= $post->title ?></h4>
                                <p class="list-group-item-text">
                                    <?= $post->source ?>
                                    <?php if($post->local): ?>
                                    <br>
                                    <?= $post->local ?>
                                    <?php endif; ?>
                                </p>
                            <?= ($can_edit ? '</a>' : '</div>') ?>
                            <a href="<?= $post->source ?>" class="list-group-closer btn btn-default btn-xs"><i class="glyphicon glyphicon-new-window"></i></a>
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