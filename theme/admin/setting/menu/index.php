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
                    <?php if(ci()->can_i('create-site_menu') && $current_group): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/setting/menu/0') ?>?group=<?= $current_group ?>"><?= _l('Create New Menu Item') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <?php if(ci()->can_i('create-site_menu')): ?>
                        <form method="get" class="form-group" action="<?= base_url('/admin/setting/menu/0') ?>">
                            <div class="input-group">
                                <input type="text" name="group" pattern="^([a-zA-Z\.\-_]+)$" placeholder="<?= _l('Create New Group') ?>" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                </span>
                            </div>
                        </form>
                        <?php endif; ?>
                        <?php if($groups): ?>
                        <div class="list-group">
                            <?php foreach($groups as $group => $total): ?>
                            <a href="?group=<?= $group ?>" class="list-group-item<?= ($group==$current_group?' active':'') ?>"><?= $group ?></a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                            if($menus){
                                $menus = group_by_prop($menus, 'parent');
                                $can_edit = ci()->can_i('update-site_menu');
                                
                                $recursiver = function($parent) use($menus, $can_edit, &$recursiver){
                                    if(!array_key_exists($parent, $menus))
                                        return;
                                    $local_menus = $menus[$parent];
                                    
                                    $tx = '<ul>';
                                    foreach($local_menus as $local_menu){
                                        $tx.= '<li>';
                                        if(!$can_edit)
                                            $tx.= '<span title="' . $local_menu->url . '" data-toggle="tooltip">' . $local_menu->label . '</span>';
                                        else
                                            $tx.= '<a href="' . base_url('/admin/setting/menu/' . $local_menu->id) . '" title="' . $local_menu->url . '" data-toggle="tooltip">' . $local_menu->label . '</a>';;
                                        if(array_key_exists($local_menu->id, $menus))
                                            $tx.= $recursiver($local_menu->id);
                                        $tx.= '</li>';
                                    }
                                    $tx.= '</ul>';
                                    
                                    return $tx;
                                };
                                
                                echo $recursiver(0);
                            }
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    <script>$('[data-toggle="tooltip"]').tooltip();</script>
</body>
</html>