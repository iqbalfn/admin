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
                            <?= $this->form->field('group'); ?>
                            <?= $this->form->field('post', $posts); ?>
                            <?= $this->form->field('index'); ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <?php if(ci()->can_i('delete-post_selector') && property_exists($selection, 'id')): ?>
                                    <a href="<?= base_url('/admin/post/selector/' . $selection->id . '/remove') ?>?group=<?= $selection->group ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-7 text-right">
                                    <div class="form-group">
                                        <a href="<?= base_url('/admin/post/selector') ?>?group=<?= $selection->group ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                        <button class="btn btn-primary"><?= _l('Save') ?></button>
                                    </div>
                                </div>
                            <div>
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