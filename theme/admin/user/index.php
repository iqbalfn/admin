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
                    <?php if(ci()->can_i('create-user')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/user/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <form method="get">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" name="q" placeholder="Find user" class="form-control" autofocus="autofocus" value="<?= $this->input->get('q') ?>">
                                    <?php if($this->input->get('status')): ?>
                                    <input type="hidden" name="status" value="<?= $this->input->get('status') ?>">
                                    <?php endif; ?>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                        
                        <div class="list-group">
                            <?php
                                $self_cond = array();
                                if($this->input->get('q'))
                                    $self_cond['q'] = $this->input->get('q');
                                
                                foreach($statuses as $id => $label){
                                    if(!$id)
                                        continue;
                                    $self_cond['status'] = $id;
                                    echo '<a href="?' . http_build_query($self_cond) . '" class="list-group-item' . ( $id == $this->input->get('status') ? ' active' : '') . '">' . $label . '</a>';
                                }
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <?php foreach($users as $user): ?>
                            <div class="col-md-4">
                                <div class="list-group">
                                    <a href="<?= base_url('admin/user/' . $user->id) ?>" class="list-group-item">
                                        <h4 class="list-group-item-heading"><?= $user->fullname ?></h4>
                                        <div class="list-group-item-text">
                                            <div class="text-ellipsis"><?= $user->name ?></div>
                                            <div class="text-ellipsis"><?= $user->email ?></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if($pagination): ?>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <ul class="pagination">
                                <?php foreach($pagination as $label => $link): ?>
                                    <?php $active = $link == '#'; ?>
                                    <li<?= ($active?' class="disabled"':'') ?>><a<?= (!$active?' href="' . $link . '"':'') ?>><?= $label ?></a></li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
</body>
</html>