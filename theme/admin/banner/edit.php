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
            </div>
        </div>
                
        <form class="row" method="post">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <?= $this->form->field('name') ?>
                        <fieldset>
                            <legend><?= _l('Media Banner') ?></legend>
                            <?= $this->form->field('media') ?>
                            <?= $this->form->field('link') ?>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <?= $this->form->field('expired') ?>
                        <fieldset>
                            <legend><?= _l('Code Banner') ?></legend>
                            <?= $this->form->field('code') ?>
                        </fieldset>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <?php if(ci()->can_i('delete-banner') && property_exists($banner, 'id')): ?>
                        <a href="<?= base_url('/admin/banner/' . $banner->id . '/remove') ?>" class="btn btn-danger btn-confirm" data-title="<?= _l('Delete Confirmation') ?>" data-confirm="<?= hs(_l('Are you sure want to delete this banner permanently?')) ?>"><?= _l('Delete') ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7 text-right">
                        <div class="form-group">
                            <a href="<?= base_url('/admin/banner') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                            <button class="btn btn-primary"><?= _l('Save') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
</body>
</html>