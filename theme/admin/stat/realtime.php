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
                <div class="page-header"><h1><?= $title ?></h1></div>
            </div>
        </div>
        <div class="row">
        <?php if($ga_token): ?>
            
        <?php endif; ?>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    
    <?php if($ga_token): ?>
    <script>
    function GAInit(){
        gapi.auth.setToken({access_token: '<?= $ga_token ?>'});
        getData();
    }
    function getData(){
        var config = {
                path: 'https://www.googleapis.com/analytics/v3/data/realtime',
                method: 'GET',
                params: {
                    ids: 'ga:<?= $ga_view ?>',
                    metrics: 'rt:pageviews',
                    dimensions: 'rt:pagePath,rt:pageTitle'
                }
            };
        
        gapi.client.request(config).execute(function(res){
            console.log(res);
        });
    }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=GAInit"></script>
    <?php endif; ?>
</body>
</html>