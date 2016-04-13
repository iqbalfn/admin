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
                                        <?php if(ci()->can_i('update-user_password') || !property_exists($user, 'id')): ?>
                                        <?= $this->form->field('password') ?>
                                        <?php endif; ?>
                                        <?= $this->form->field('website') ?>
                                        <?= $this->form->field('status', 'user.status') ?>
                                    </div>
                                </div>
                                <?php if(ci()->can_i('update-user_permission')): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend><?= _l('Permissions') ?></legend>
                                            
                                            <?php $permissions = group_per_column($permissions, 3); ?>
                                            <?php foreach($permissions as $index => $perms): ?>
                                            <div class="row">
                                                <?php foreach($perms as $group => $perm): ?>
                                                <div class="col-md-4">
                                                    <h4><?= $group ?></h4>
                                                    <?php foreach($perm as $per): ?>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="perm-<?= $per->name ?>" name="perms[<?= $per->name ?>]"<?= ($per->checked?' checked="checked"':'')?>>
                                                        <label for="perm-<?= $per->name ?>" title="<?= $per->description ?>"><?= $per->label ?></label>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php endforeach; ?>
                                        </fieldset>
                                    </div>
                                </div>
                                <?php endif; ?>
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