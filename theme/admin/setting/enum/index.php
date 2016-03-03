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
                
                <div class="row">
                    <?php if(ci()->can_i('create-site_enum')): ?>
                    <div class="col-md-3">
                        <form method="get" class="form-group" action="<?= base_url('/admin/setting/enum/0') ?>">
                            <div class="input-group">
                                <input type="text" name="group" pattern="^([a-zA-Z\.\-_]+)$" placeholder="<?= _l('Create New Group') ?>" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                    
                    <?php foreach($enums as $group => $opts): ?>
                    <?php
                        $panel_id = 'enum-' . str_replace('.', '-', $group);
                        $panel_header = $panel_id . '-header';
                    ?>
                    <div class="col-md-3">
                        <div class="panel-group" role="tablist">
                            <div class="panel panel-default">
                                <div class="panel-heading" id="<?= $panel_header ?>" role="tab">
                                    <h4 class="panel-title">
                                        <a aria-controls="<?= $panel_id ?>" aria-expanded="true" data-toggle="collapse" href="#<?= $panel_id ?>" role="button"><?= $group ?></a>
                                        <?php if(ci()->can_i('create-site_enum')): ?>
                                        <a href="<?= base_url('/admin/setting/enum/0') ?>?group=<?= $group ?>" class="pull-right"><i class="glyphicon glyphicon-plus"></i></a>
                                        <?php endif; ?>
                                    </h4>
                                </div>
                                
                                <div aria-expanded="true" aria-labelledby="<?= $panel_header ?>" class="panel-collapse collapse" id="<?= $panel_id ?>" role="tabpanel">
                                    <div class="list-group">
                                        <?php foreach($opts as $opt): ?>
                                            <?php if(ci()->can_i('update-site_enum')): ?>
                                                <a href="<?= base_url('/admin/setting/enum/'.$opt->id) ?>" class="list-group-item"><?= $opt->label ?></a>
                                            <?php else: ?>
                                                <div class="list-group-item"><?= $opt->label ?></div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>