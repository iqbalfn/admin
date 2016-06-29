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
                                <div class="col-md-6">
                                    <?= $this->form->field('cover'); ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->form->field('name'); ?>
                                    <?= $this->form->field('description'); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if(ci()->can_i('delete-gallery') && property_exists($album, 'id')): ?>
                                    <a href="<?= base_url('/admin/gallery/' . $album->id . '/remove') ?>" class="btn btn-danger btn-confirm" data-title="<?= _l('Delete Confirmation') ?>" data-confirm="<?= hs(_l('Are you sure want to delete this gallery permanently?')) ?>"><?= _l('Delete') ?></a>
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
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
</body>
</html>