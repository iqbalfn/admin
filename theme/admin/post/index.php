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
                    <?php if(ci()->can_i('create-post')): ?>
                    <a class="btn btn-primary pull-right" href="<?= base_url('/admin/post/0') ?>"><?= _l('Create New') ?></a>
                    <?php endif; ?>
                    <h1><?= $title ?></h1>
                </div>
                
                <div class="row">
                    <form class="col-md-3" method="get">
                        <div class="form-group">
                            <input type="search" autofocus="autofocus" class="form-control" placeholder="Find posts" name="q" value="<?= $this->input->get('q') ?>">
                        </div>
                        
                        <?php if(ci()->can_i('read-post_other_user')): ?>
                        <div class="form-group">
                            <select name="user" class="object-filter" title="<?= _l('User') ?>" placeholder="<?= _l('User') ?>" data-table="user" data-label="fullname" data-value="id">
                            <?php if($user): ?>
                            <option value="<?= $user->id ?>" selected="selected"><?= $user->fullname ?></option>
                            <?php endif; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($categories): ?>
                        <div class="form-group">
                            <select class="selectpicker" name="category" title="<?= _l('Category') ?>">
                                <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat->id ?>"<?= ($cat->id == $this->input->get('category') ? ' selected="selected"' : '') ?>><?= $cat->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(ci()->can_i('read-post_tag')): ?>
                        <div class="form-group">
                            <select name="tag" class="object-filter" title="<?= _l('Tag') ?>" placeholder="<?= _l('Tag') ?>" data-table="post_tag" data-label="name" data-value="id">
                            <?php if($tag): ?>
                            <option value="<?= $tag->id ?>" selected="selected"><?= $tag->name ?></option>
                            <?php endif; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($statuses): ?>
                        <div class="form-group">
                            <select class="selectpicker" name="status" title="Status">
                                <?php foreach($statuses as $stat => $label): ?>
                                <option value="<?= $stat ?>"<?= ($stat == $this->input->get('status') ? ' selected="selected"' : '') ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <div class="form-group text-right">
                            <button class="btn btn-primary"><?= _l('Filter') ?></button>
                        </div>
                    </form>
                    
                    <div class="col-md-9">
                        <?php if($posts): ?>
                            <?php
                                $can_edit = ci()->can_i('update-post');
                                $can_edit_other = ci()->can_i('update-post_other_user');
                            ?>
                            <?php foreach($posts as $post): ?>
                            <?php
                                $html_tag = 'div';
                                if($post->user == $this->user->id && $can_edit)
                                    $html_tag = 'a';
                                if($post->user != $this->user->id && $can_edit_other)
                                    $html_tag = 'a';
                            ?>
                            <div class="list-group">
                                <<?= $html_tag ?> class="list-group-item" href="<?= base_url('/admin/post/' . $post->id) ?>">
                                    <h4 class="list-group-item-heading"><?= $post->title ?></h4>
                                    <p class="list-group-item-text"><?= base_url($post->page) ?></p>
                                </<?= $html_tag ?>>
                                <div class="list-group-closer">
                                    <?php if($post->status->value == 1): ?>
                                    <span class="label label-default">draft</span>
                                    <?php elseif($post->status->value == 2): ?>
                                    <span class="label label-warning" title="<?= _l('Editor') ?>">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </span>
                                    <?php elseif($post->status->value == 3): ?>
                                    <span class="label label-info">
                                        <i class="glyphicon glyphicon-time"></i>
                                        <?= $post->published->format('M d, H:i'); ?>
                                    </span>
                                    <?php else: ?>
                                    <a href="<?= base_url($post->page) ?>" class="btn btn-default btn-xs">
                                        <i class="glyphicon glyphicon-new-window"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
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