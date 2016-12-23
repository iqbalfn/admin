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
                    <h1>
                        <div class="row">
                            <div class="col-md-9">
                                <?= $title ?>
                            </div>
                            <div class="col-md-3">
                                <?php if(property_exists($user, 'id') && ci()->can_i('update-user_session')): ?>
                                <form method="post" class="text-right" action="<?= base_url('/admin/me/relogin') ?>">
                                    <input type="hidden" value="<?= $user->id ?>" name="id">
                                    <button class="btn btn-success"><?= _l('Login As') ?></button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </h1>
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
                                        <?= $this->form->field('status', $statuses) ?>
                                    </div>
                                </div>
                                <?php if(ci()->can_i('update-user_permission')): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend><?= _l('Permissions') ?></legend>
                                            
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <div class="btn-group btn-group-xs" role="group">
                                                        <button type="button" class="btn btn-default" onclick="selectAll()" title="Select All"><i class="glyphicon glyphicon-check"></i> All</button>
                                                        <button type="button" class="btn btn-default" onclick="unselectAll()" title="Select None"><i class="glyphicon glyphicon-unchecked"></i> None</button>
                                                    </div>
                                                    <div class="btn-group btn-group-xs" role="group">
                                                        <?php
                                                            $groups = [];
                                                            foreach($permissions as $perms){
                                                                foreach($perms as $perm){
                                                                    $workers = $perm->worker;
                                                                    if(!$workers)
                                                                        continue;
                                                                    $workers = explode(' ', $workers);
                                                                    foreach($workers as $worker){
                                                                        if(!in_array($worker, $groups))
                                                                            $groups[] = $worker;
                                                                    }
                                                                }
                                                            }
                                                            asort($groups);
                                                            foreach($groups as $group)
                                                                echo '<button type="button" onclick="selectByClass(\'' . $group . '\')" class="btn btn-default" title="Select All ' . $group . '">' . $group . '</button>';
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php $permissions = group_per_column($permissions, 3); ?>
                                            <?php foreach($permissions as $index => $perms): ?>
                                            <div class="row">
                                                <?php foreach($perms as $group => $perm): ?>
                                                <div class="col-md-4">
                                                    <h4>
                                                        <div class="btn-group btn-group-xs" role="group">
                                                            <button class="btn btn-default btn-xs" type="button" onclick="selectParentSub(this)" title="Select All"><i class="glyphicon glyphicon-check"></i></button>
                                                            <button class="btn btn-default btn-xs" type="button" onclick="unselectParentSub(this)" title="Select None"><i class="glyphicon glyphicon-unchecked"></i></button>
                                                        </div>
                                                        <?= $group ?>
                                                    </h4>
                                                    <?php foreach($perm as $per): ?>
                                                        <?php
                                                            $cls = '';
                                                            if($per->worker){
                                                                $cls = explode(' ', $per->worker);
                                                                $cls = array_map(function($e){ return 'prm-' . $e; }, $cls);
                                                                $cls = ' ' . implode(' ', $cls);
                                                            }
                                                        ?>
                                                    <div class="checkbox">
                                                        <input type="checkbox" class="prm-All<?= $cls ?>" id="perm-<?= $per->name ?>" name="perms[<?= $per->name ?>]"<?= ($per->checked?' checked="checked"':'')?>>
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
                                <a href="<?= base_url('/admin/user/' . $user->id . '/remove') ?>" class="btn btn-danger btn-confirm" data-title="<?= _l('Delete Confirmation') ?>" data-confirm="<?= hs(_l('Are you sure want to delete this user permanently?')) ?>"><?= _l('Delete') ?></a>
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
    <script>
    function selectParentSub(el){
        $(el).parent().parent().parent().find('input[type=checkbox]').prop('checked', true);
    }
    function unselectParentSub(el){
        $(el).parent().parent().parent().find('input[type=checkbox]').prop('checked', false);
    }
    function unselectAll(){
        $('.prm-All').prop('checked', false);
    }
    function selectAll(){
        $('.prm-All').prop('checked', true);
    }
    function selectByClass(cls){
        $('.prm-' + cls).prop('checked', true);
    }
    </script>
</body>
</html>