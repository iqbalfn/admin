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
                    <form class="col-md-3">
                        <div class="form-group">
                            <input type="search" name="q" class="form-control" placeholder="<?= _l('Search') ?>" value="<?= hs($this->input->get('q')) ?>">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary"><?= _l('Find') ?></button>
                        </div>
                        
                        <div class="panel panel-default">
                            <div class="panel-body">
                            Total galleries: <?= number_format($total, 0, '.', '.'); ?>
                            </div>
                        </div>
                    </form>
                    <?php if($albums): ?>
                        <?php $albums = group_per_column($albums, 3); ?>
                        <?php $can_see_album_media = ci()->can_i('read-gallery_media'); ?>
                        <?php $can_edit_album = ci()->can_i('update-gallery'); ?>
                    <div class="col-md-9">
                        <?php foreach($albums as $albs): ?>
                        <div class="row">
                            <?php foreach($albs as $album): ?>
                            <div class="col-md-4">
                                <div class="thumbnail">
                                    <?php if($can_edit_album): ?>
                                    <div class="thumbnail-closer btn-group btn-group-xs">
                                        <?php if($can_see_album_media): ?>
                                        <a href="<?= base_url('/admin/gallery/' . $album->id . '/download') ?>" class="btn btn-default"><i class="glyphicon glyphicon-download-alt"></i></a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('/admin/gallery/' . $album->id) ?>" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($can_see_album_media): ?>
                                    <a href="<?= base_url('/admin/gallery/' . $album->id .'/media' ) ?>">
                                        <img src="<?= $album->cover->_253x142 ?>" alt="<?= $album->name ?>" class="img-responsive">
                                    </a>
                                    <?php else: ?>
                                    <div><img src="<?= $album->cover->_253x142 ?>" alt="<?= $album->name ?>" class="img-responsive"></div>
                                    <?php endif; ?>
                                    
                                    <h4><?= $album->name ?></h4>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if($pagination): ?>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <ul class="pagination">
                                <?php foreach($pagination as $label => $link): ?>
                                    <?php $active = $link == '#'; ?>
                                    <li<?= ($active?' class="disabled"':'') ?>><a<?= (!$active?' href="' . $link . '"':'') ?>><?= $label ?></a></li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>