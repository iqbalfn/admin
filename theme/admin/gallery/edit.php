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
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $this->form->field('name'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $this->form->field('cover'); ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->form->field('slug'); ?>
                                    <?= $this->form->field('description'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if(ci()->can_i('delete-gallery') && property_exists($album, 'id')): ?>
                                    <a href="<?= base_url('/admin/gallery/' . $album->id . '/remove') ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <div class="form-group">
                                        <a href="<?= base_url('/admin/gallery') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                        <button class="btn btn-primary"><?= _l('Save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 bg-info">
                            <div>&#160;</div>
                            <?= $this->form->field('seo_schema', 'gallery.seo_schema') ?>
                            <?= $this->form->field('seo_title') ?>
                            <?= $this->form->field('seo_description') ?>
                            <?= $this->form->field('seo_keywords') ?>
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