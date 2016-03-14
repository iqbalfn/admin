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
                            <div class="col-md-12">
                                <?= $this->form->field('title') ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->form->field('content') ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <?= $this->form->field('embed') ?>
                                <?= $this->form->field('cover') ?>
                                <?= $this->form->field('cover_label') ?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->form->field('slug') ?>
                                <?= $this->form->field('location') ?>
                                
                                <?= (ci()->can_i('read-post_category') ? $this->form->field('category', $categories) : '')?>
                                
                                <div class="row">
                                    <?php if(ci()->can_i('create-post_featured')): ?>
                                    <div class="col-md-6">
                                        <?= $this->form->field('featured') ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(ci()->can_i('create-post_editor_pick')): ?>
                                    <div class="col-md-6">
                                        <?= $this->form->field('editor_pick') ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <?= $this->form->field('sources') ?>
                                
                                <?php if(ci()->can_i('read-gallery')): ?>
                                <?= $this->form->field('gallery') ?>
                                <?php endif; ?>
                                
                                <?= $this->form->field('status', $statuses) ?>
                                
                                <?= (ci()->can_i('read-post_tag') ? $this->form->field('tag', $tags) : '') ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <?php if(ci()->can_i('delete-post') && property_exists($post, 'id')): ?>
                                <a href="<?= base_url('/admin/post/' . $post->id . '/remove') ?>" class="btn btn-danger"><?= _l('Delete') ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7 text-right">
                                <div class="form-group">
                                    <a href="<?= base_url('/admin/post') ?>" class="btn btn-default"><?= _l('Cancel') ?></a>
                                    <button class="btn btn-primary"><?= _l('Save') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 bg-info">
                        <div>&#160;</div>
                        <?= $this->form->field('seo_schema', 'post.seo_schema') ?>
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