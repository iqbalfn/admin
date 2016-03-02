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
                    <?php if(ci()->can_i('create-gallery')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/gallery/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <?php $can_see_album_media = ci()->can_i('read-gallery_media'); ?>
                    <?php foreach($albums as $album): ?>
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <?php if($can_see_album_media): ?>
                            <a href="<?= base_url('/admin/gallery/' . $album->id .'/media' ) ?>">
                                <img src="<?= $album->cover->_253x142 ?>" alt="<?= $album->name ?>" class="img-responsive">
                            </a>
                            <?php else: ?>
                            <div><img src="<?= $album->cover->_253x142 ?>" alt="<?= $album->name ?>" class="img-responsive"></div>
                            <?php endif; ?>
                            
                            <h4><?= $album->name ?></h4>
                            <div class="text-right">
                                <a href="<?= base_url('/admin/gallery/' . $album->id) ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-pencil"></i></a>
                            </div>
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