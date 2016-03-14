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
                        
                        <?php if($categories): ?>
                        <div class="form-group">
                            <select class="selectpicker" name="category" title="<?= _l('Category') ?>">
                                <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat->id ?>"<?= ($cat->id == $this->input->get('category') ? ' selected="selected"' : '') ?>><?= $cat->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($tags): ?>
                        <div class="form-group">
                            <select class="selectpicker" name="tag" title="<?= _l('Tag') ?>">
                                <?php foreach($tags as $tag): ?>
                                <option value="<?= $tag->id ?>"<?= ($tag->id == $this->input->get('tag') ? ' selected="selected"' : '') ?>><?= $tag->name ?></option>
                                <?php endforeach; ?>
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
                            <?php foreach($posts as $post): ?>
                            <div class="list-group">
                                <a class="list-group-item" href="<?= base_url('/admin/post/' . $post->id) ?>">
                                    <h4 class="list-group-item-heading"><?= $post->title ?></h4>
                                    <p class="list-group-item-text"><?= base_url($post->page) ?></p>
                                </a>
                                <a class="list-group-closer btn btn-default btn-xs" href="<?= base_url($post->page) ?>"><i class="glyphicon glyphicon-new-window"></i></a>
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