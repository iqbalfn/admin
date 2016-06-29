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
                    <h1><?= $title ?></h1>
                </div>
                
                <form method="post">
                    <div class="row">
                        <div class="col-md-8">
                            <?= $this->form->field('title'); ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $this->form->field('media'); ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->form->field('media_label'); ?>
                                </div>
                            </div>
                            
                            <?= $this->form->field('description'); ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if(ci()->can_i('delete-gallery_media') && property_exists($media, 'id')): ?>
                                    <a href="<?= base_url('/admin/gallery/' . $album->id . '/media/' . $media->id . '/remove') ?>" class="btn btn-danger btn-confirm" data-title="<?= _l('Delete Confirmation') ?>" data-confirm="<?= hs(_l('Are you sure want to delete this gallery media permanently?')) ?>"><?= _l('Delete') ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="form-group">
                                        <a href="<?= base_url('/admin/gallery/' . $album->id . '/media') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                        <button class="btn btn-primary"><?= _l('Save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
</body>
</html>