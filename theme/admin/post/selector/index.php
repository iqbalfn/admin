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
                    <?php if(ci()->can_i('create-post_selector') && $current_group): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/post/selector/0') ?>?group=<?= $current_group ?>"><?= _l('Create New Post Selection') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <?php if($groups): ?>
                        <div class="list-group">
                            <?php foreach($groups as $group => $total): ?>
                            <a href="?group=<?= $group ?>" class="list-group-item<?= ($group==$current_group?' active':'') ?>"><?= $group ?></a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if(ci()->can_i('create-post_selector')): ?>
                        <form method="get" class="form-group" action="<?= base_url('/admin/post/selector/0') ?>">
                            <div class="input-group">
                                <input type="text" name="group" pattern="^([a-zA-Z\.\-_]+)$" placeholder="<?= _l('Create New Group') ?>" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                </span>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                        <?php foreach($selections as $selection): ?>
                            <div class="list-group">
                                <a class="list-group-item" href="<?= base_url('/admin/post/selector/' . $selection->id) ?>">
                                    <h4 class="list-group-item-heading"><?= $selection->post->title ?></h4>
                                    <p class="list-group-item-text"><?= base_url($selection->post->page) ?></p>
                                </a>
                                <a class="list-group-closer btn btn-default btn-xs" href="<?= base_url($selection->post->page) ?>"><i class="glyphicon glyphicon-new-window"></i></a>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>