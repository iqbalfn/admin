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
                        <div class="col-md-4">
                            <?= $this->form->field('image'); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->form->field('group'); ?>
                            <?= $this->form->field('title'); ?>
                            <?= $this->form->field('link'); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->form->field('index'); ?>
                            <?= $this->form->field('description'); ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-5">
                            <?php if(ci()->can_i('delete-slide_show') && property_exists($slide, 'id')): ?>
                            <a href="<?= base_url('/admin/setting/slideshow/' . $slide->id . '/remove') ?>?group=<?= $slide->group ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-7 text-right">
                            <div class="form-group">
                                <a href="<?= base_url('/admin/setting/slideshow') ?>?group=<?= $slide->group ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                <button class="btn btn-primary"><?= _l('Save') ?></button>
                            </div>
                        </div>
                    <div>
                </form>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
</body>
</html>