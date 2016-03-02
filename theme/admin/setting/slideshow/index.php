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
                    <?php if(ci()->can_i('create-slide_show') && $current_group): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/setting/slideshow/0') ?>?group=<?= $current_group ?>"><?= _l('Create New SlideShow Image') ?></a>
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
                        <?php if(ci()->can_i('create-slide_show')): ?>
                        <form method="get" class="form-group" action="<?= base_url('/admin/setting/slideshow/0') ?>">
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
                        <?php foreach($slides as $slide): ?>
                            <div class="col-md-4">
                                <a class="thumbnail" href="<?= base_url('/admin/setting/slideshow/' . $slide->id) ?>">
                                    <img src="<?= $slide->image->_253x142 ?>" alt="<?= $slide->title ?>" class="img-responsive">
                                </a>
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