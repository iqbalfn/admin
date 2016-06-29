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
                                <?= $this->form->field('slug', null, (!$slug_editable ? ['readonly'=>'readonly'] : [])) ?>
                                <?= $this->form->field('location') ?>
                                
                                <?= (ci()->can_i('read-post_category') && $categories ? $this->form->field('category', $categories) : '')?>
                            </div>
                            <div class="col-md-4">
                                <?= $this->form->field('sources') ?>
                                
                                <?php if(ci()->can_i('read-gallery')): ?>
                                <?= $this->form->field('gallery', $galleries) ?>
                                <?php endif; ?>
                                
                                <?php if(ci()->can_i('read-post_tag')): ?>
                                <?= $this->form->field('tag', $tags, (ci()->can_i('create-post_tag') ? ['data-live-create' => 'postCreateTag'] : [])) ?>
                                <?php endif; ?>
                                
                                <?= $this->form->field('status', $statuses) ?>
                                
                                <div id="post-published-schedule-date">
                                <?= (ci()->can_i('create-post_published') ? $this->form->field('published') : '') ?>
                                </div>
                                
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
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <?php if(ci()->can_i('delete-post') && property_exists($post, 'id')): ?>
                                <a href="<?= base_url('/admin/post/' . $post->id . '/remove') ?>" class="btn btn-danger btn-confirm" data-title="<?= _l('Delete Confirmation') ?>" data-confirm="<?= hs(_l('Are you sure want to delete this post permanently?')) ?>"><?= _l('Delete') ?></a>
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
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12 bg-info">
                                <div>&#160;</div>
                                <?= $this->form->field('seo_schema', 'post.seo_schema') ?>
                                <?= $this->form->field('seo_title') ?>
                                <?= $this->form->field('seo_description') ?>
                                <?= $this->form->field('seo_keywords') ?>
                                <?= $this->form->field('ga_group') ?>
                            </div>
                        </div>
                        
                        <?php if($reporter): ?>
                        <div>&#160;</div>
                        <div class="row">
                            <div class="col-md-12 bg-success">
                                <div>&#160;</div>
                                <div class="thumbnail">
                                    <img src="<?= $reporter->avatar->_253x253 ?>" alt="<?= $reporter->fullname ?>">
                                    <div class="caption">
                                        <h4><?= $reporter->fullname ?></h4>
                                        <p><?= $reporter->about ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <form class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" id="post-tag-create">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= _l('Create New Tag') ?></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger hidden" id="post-tag-create-error"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="field-tag-name" class="control-label" id="field-tag-name-label">Name</label>
                                <input name="tag-name" id="field-tag-name" class="form-control" title="Name" placeholder="Name" required="required" type="text" aria-labelledby="field-tag-name-label">
                            </div>
                            <div class="form-group">
                                <label for="field-tag-slug" class="control-label" id="field-tag-slug-label">Slug</label>
                                <input name="tag-slug" id="field-tag-slug" class="slugify form-control" title="Slug" placeholder="Slug" data-source="#field-tag-name" required="required" type="text" aria-labelledby="field-tag-slug-label">
                            </div>
                            <div class="form-group">
                                <label for="field-tag-description" class="control-label" id="field-tag-description-label">Description</label>
                                <textarea name="tag-description" id="field-tag-description" class="form-control textarea-dynamic" title="Description" placeholder="Description" aria-labelledby="field-tag-description-label"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-loading-text="Creating...">Create</button>
                </div>
            </div>
        </div>
    </form>
    
    <?= $this->theme->file('foot') ?>
    <?= $this->form->focusInput(); ?>
    <script>
    
        $('#field-status').change(function(){
            var val = $(this).val();
            $('#post-published-schedule-date')[(val==3?'show':'hide')]();
        }).change();
        
        var postTagCreateForm = $('#post-tag-create');
        var postTagCreateError= $('#post-tag-create-error');
        
        postTagCreateForm.submit(function(){
            var saveBtn = postTagCreateForm.find('.btn-primary');
            saveBtn.button('loading');
            
            postTagCreateError.addClass('hidden');
        
            var allInputs = postTagCreateForm.find('input,textarea,button');
            var allFields = postTagCreateForm.find('input,textarea');
            
            var formValues = {};
            allFields.each(function(i,e){
                var field = $(e);
                var name  = field.attr('name').replace('tag-', '');
                var value = field.val();
                formValues[name] = value;
            });
            allInputs.attr('disabled', 'disabled');
            
            $.post('/admin/post/tag/0?ajax=1', formValues, function(res){
                allInputs.attr('disabled', false);
                saveBtn.button('reset');
                
                if(res.error){
                    var error = '';
                    for(var k in res.error)
                        error+= '<div>'+res.error[k]+'</div>';
                    return postTagCreateError.removeClass('hidden').html(error);
                }
                
                var targetSelect = $('#' + postTagCreateForm.data('target'));
                targetSelect.append('<option value="' + res.data.id + '" selected="selected">' + res.data.name + '</option>');
                targetSelect.selectpicker('refresh');
                postTagCreateForm.modal('hide');
            });
            
            return false;
        });
        
        function postCreateTag(el){
            postTagCreateForm.find('input,textarea').val('');
            postTagCreateForm.data('target', el);
            postTagCreateForm.modal('show');
        }
        
        postTagCreateForm.on('hidden.bs.modal', function(){
            postTagCreateError.addClass('hidden').html('');
        });
        
        postTagCreateForm.on('shown.bs.modal', function(){
            $('#field-tag-name').focus();
        });
    </script>
</body>
</html>