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
                
                <form class="row" method="post">
                    <div class="col-md-3">
                        <?= $this->form->field('name') ?>
                        <?= $this->form->field('value') ?>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <?php if(ci()->can_i('delete-site_param') && property_exists($param, 'id')): ?>
                                <a href="<?= base_url('/admin/setting/param/' . $param->id . '/remove') ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7 text-right">
                                <div class="form-group">
                                    <a href="<?= base_url('/admin/setting/param') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                    <button class="btn btn-primary"><?= _l('Save') ?></button>
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