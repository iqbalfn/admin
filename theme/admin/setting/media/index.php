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
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title" id="media-cleanup-title"><?= _l('Media Cleanup Confirmation') ?></h3>
                            </div>
                            <div class="panel-body">
                                <div id="media-cleanup-confirmation">
                                    <div><?= _l('There are') ?> <?= number_format($total,0) ?> <?= _l('media folders to clean up') ?></div>
                                    <div><?= _l('Are you sure want to clean them all') ?>?</div>
                                    <div class="text-right">
                                        <button class="btn btn-danger" type="button" onclick="cleanMedia()"><?= _l('Clean') ?></button>
                                    </div>
                                </div>
                                <div id="media-cleanup-progress" class="hidden">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            <span id="media-cleanup-current"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    
    <script>
        var folders = <?= json_encode($folders); ?>;
        var total  = folders.length;
        
        var el = {
                progress: $('#media-cleanup-progress'),
                confirmation: $('#media-cleanup-confirmation'),
                confirmationTitle: $('#media-cleanup-title'),
                progressLabel: $('#media-cleanup-current')
            };
        
        function cleanMedia(){
            el.confirmation.addClass('hidden');
            el.progress.removeClass('hidden');
            
            if(!folders.length){
                el.confirmationTitle.html('Success');
                el.confirmation.removeClass('hidden');
                el.progress.addClass('hidden');
                el.confirmation.html('<div class="alert alert-success"><strong>Congratulation!</strong> All media cleaned up.</div>');
                return;
            }
            
            var media = folders.shift();
            el.progressLabel.html( ( ( total - folders.length ) + ' / ' + total ) );
            
            el.confirmationTitle.html('Cleaning `'+media+'/*`...');
            $.post('/admin/setting/media/execute', { folder: media }, function(res){
                if(res.error){
                    el.confirmationTitle.html('Error');
                    el.confirmation.removeClass('hidden');
                    el.progress.addClass('hidden');
                    el.confirmation.html('<div class="alert alert-danger">'+res.error+'</div>');
                }else{
                    if(res.data != 'success')
                        console.log(res);
                    setTimeout(cleanMedia, 500);
                }
            }, 'json').error(function(res){
                el.confirmationTitle.html('Error');
                el.confirmation.removeClass('hidden');
                el.progress.addClass('hidden');
                el.confirmation.html('<div class="alert alert-danger">Something not go right, please try again later or hit refresh.</div>');
            });
        }
    </script>
</body>
</html>