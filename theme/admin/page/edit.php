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
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->form->field('title') ?>
                            </div>
                            <div class="col-md-6">
                                <?= $this->form->field('slug') ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->form->field('content') ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <?php if(ci()->can_i('delete-page') && property_exists($page, 'id')): ?>
                                <a href="<?= base_url('/admin/page/' . $page->id . '/remove') ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7 text-right">
                                <div class="form-group">
                                    <a href="<?= base_url('/admin/page') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                    <button class="btn btn-primary"><?= _l('Save') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?= $this->form->field('seo_schema', 'page.seo_schema') ?>
                        <?= $this->form->field('seo_title') ?>
                        <?= $this->form->field('seo_description') ?>
                        <?= $this->form->field('seo_keywords') ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
</body>
</html>