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
                    <?php if(ci()->can_i('create-site_param')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/setting/param/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead><tr><th>#</th><th>Name</th><th>Value</th><th></th>&#160;</tr></thead>
                            <tbody>
                            <?php foreach($params as $index => $param): ?>
                                <tr>
                                    <td><?= ($index + 1) ?>.</td>
                                    <td><?= $param->name ?></td>
                                    <td><?= $param->value ?></td>
                                    <td>
                                        <?php if(ci()->can_i('update-site_param')): ?>
                                        <a href="<?= base_url('/admin/setting/param/' . $param->id) ?>"><?= _l('Edit') ?></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>