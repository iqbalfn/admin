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
                    <div class="col-md-12">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <?= $this->form->field('avatar') ?>
                                <?= $this->form->field('about') ?>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->form->field('name') ?>
                                        <?= $this->form->field('fullname') ?>
                                        <?= $this->form->field('email') ?>
                                    </div>
                                    <div class="col-md-6">  
                                        <?= $this->form->field('password') ?>
                                        <?= $this->form->field('website') ?>
                                        <?= $this->form->field('status', 'user.status') ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend><?= _l('Permissions') ?></legend>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <?php if(ci()->can_i('delete-user') && property_exists($user, 'id') && $user->id != 1): ?>
                                <a href="<?= base_url('/admin/user/' . $user->id . '/remove') ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7 text-right">
                                <div class="form-group">
                                    <a href="<?= base_url('/admin/user') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
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