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
                    <?php if(ci()->can_i('create-gallery_media')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/gallery/' . $album->id . '/media/0') ?>"><?= _l('Create New Media') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            <?php foreach($albums as $alb): ?>
                            <a href="<?= base_url('/admin/gallery/' . $alb->id . '/media') ?>" class="list-group-item<?= ( $alb->id == $album->id ? ' active' : '' ) ?>">
                                <?= $alb->name ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php $can_see_album_media = ci()->can_i('update-gallery_media'); ?>
                        <?php foreach($media as $med): ?>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <?php if($can_see_album_media): ?>
                                <a href="<?= base_url('/admin/gallery/' . $album->id .'/media/' . $med->id ) ?>">
                                    <img src="<?= $med->media->_243x136 ?>" alt="<?= $med->title ?>" class="img-responsive">
                                </a>
                                <?php else: ?>
                                <div><img src="<?= $med->media->_243x136 ?>" alt="<?= $med->title ?>" class="img-responsive"></div>
                                <?php endif; ?>
                                
                                <h4><?= $med->title ?></h4>
                            </div>
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