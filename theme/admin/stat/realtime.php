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
        <?php if($ga_token): ?>
        <div class="row">
            <div class="col-md-3">
                <fieldset>
                    <legend><?= _l('Active Users') ?></legend>
                    <div id="realtime-total" style="font-size:80px;" class="text-center"></div>
                    <i class="glyphicon glyphicon-stop text-success"></i> <?= _l('Mobile') ?>
                    <i class="glyphicon glyphicon-stop text-danger"></i> <?= _l('Desktop') ?>
                    <i class="glyphicon glyphicon-stop text-info"></i> <?= _l('Tablet') ?>
                    <i class="glyphicon glyphicon-stop text-default"></i> <?= _l('Other') ?>
                    <div class="progress">
                        <div id="realtime-device-mobile" class="progress-bar progress-bar-success" style="width: 25%"><span></span></div>
                        <div id="realtime-device-desktop" class="progress-bar progress-bar-danger" style="width: 25%"><span></span></div>
                        <div id="realtime-device-tablet" class="progress-bar progress-bar-info" style="width: 25%"><span></span></div>
                        <div id="realtime-device-other" class="progress-bar progress-bar-default" style="width: 25%"><span></span></div>
                    </div>
                </fieldset>
                
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#realtime-keywords-container" role="tab" data-toggle="tab"><?= _l('Keywords') ?></a></li>
                        <li role="presentation"><a href="#realtime-sources-container" role="tab" data-toggle="tab"><?= _l('Sources') ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="realtime-keywords-container">
                            <table class="table table-hover">
                                <thead><tr><th><?= _l('Keyword') ?></th><th class="text-right"><?= _l('Users') ?></th></tr></thead>
                                <tbody id="realtime-keywords"></tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="realtime-sources-container">
                            <table class="table table-hover">
                                <thead><tr><th><?= _l('Source') ?></th><th class="text-right"><?= _l('Users') ?></th></tr></thead>
                                <tbody id="realtime-sources"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <legend><?= _l('Active Pages') ?></legend>
                            <table class="table table-hover">
                                <thead><tr><th><?= _l('Page') ?></th><th class="text-right"><?= _l('Users') ?></th></tr></thead>
                                <tbody id="realtime-pages"></tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
                    metrics: 'rt:activeUsers',
                    dimensions: 'rt:pagePath,rt:pageTitle,rt:deviceCategory,rt:keyword,rt:source,rt:referralPath'
                }
            };
        
        gapi.client.request(config).execute(function(res){
            if(res.error)
                return alert(res.error.message);
            
            var totalUsers = parseInt(res.totalsForAllResults['rt:activeUsers']);
            $('#realtime-total').html((totalUsers).toLocaleString());
            
            var devices = {tablet:0,mobile:0,desktop:0,other:0};
            var pages = {};
            var keywords = {};
            var sources = {};
            
            for(var i=0; i<res.rows.length; i++){
                var row = res.rows[i];
                var users = parseInt(row[(row.length-1)]);
                
                var url = row[0];
                var title = row[1];
                var device = row[2].toLowerCase();
                var keyword = row[3];
                var source = row[4];
                
                if(!devices.hasOwnProperty(device))
                    device = 'other';
                
                devices[device]+= users
                
                if(!pages[url])
                    pages[url] = { url: url, title: title, users: 0 };
                pages[url].users+= users;
                if(!pages[url].title || pages[url].title == '(not set)')
                    pages[url].title = title;
                
                if(keyword != '(not set)'){
                    if(!keywords[keyword])
                        keywords[keyword] = 0;
                    keywords[keyword]+= users;
                }
                
                if(!sources[source])
                    sources[source] = 0;
                sources[source]+= users;
            }
            
            pages = sortObject(pages, 'users');
            var el = $('#realtime-pages');
            el.html('');
            for(var k in pages){
                var page = pages[k];
                var tr = $('<tr></tr>');
                var td0= $('<td></td>');
                var td1= $('<td class="text-right"></td>');
                var a  = $('<a target="_blank"></a>');
                
                a.attr('href', k).html(k);
                a.attr('title', page.title);
                td0.append(a);
                td1.html((page.users).toLocaleString());
                tr.append(td0,td1);
                el.append(tr);
            }
            
            for(var k in devices){
                var el = $('#realtime-device-'+k);
                var total = devices[k];
                var percent = ( total / totalUsers * 100 );
                var label = Math.round(percent);
                var elLabel = el.find('span');
                
                elLabel.html((percent > 15 ? label + '%' : ''));
                el.width(percent+'%');
                el.attr('title', label+'%');
            }
            
            keywords = sortObject(keywords);
            var el = $('#realtime-keywords');
            el.html('');
            for(var k in keywords){
                var total = (keywords[k]).toLocaleString();
                var tr = $('<tr></tr>');
                var td0= $('<td></td>');
                var td1= $('<td class="text-right"></td>');
                
                if(k == '(not provided)'){
                    td0.html(k);
                }else{
                    var a = $('<a href="https://www.google.com/search?q='+encodeURI(k)+'&ie=utf-8&oe=utf-8" target="_blank"></a>');
                    a.html(k);
                    td0.append(a);
                }
                td1.html(total);
                tr.append(td0,td1);
                el.append(tr);
            }
            
            sources = sortObject(sources);
            var el = $('#realtime-sources');
            el.html('');
            for(var k in sources){
                var total = (sources[k]).toLocaleString();
                var tr = $('<tr></tr>');
                var td0= $('<td></td>');
                var td1= $('<td class="text-right"></td>');
                
                td0.html(k);
                td1.html(total);
                tr.append(td0,td1);
                el.append(tr);
            }
            
            setTimeout(getData, 5000);
        });
    }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=GAInit"></script>
    <?php endif; ?>
</body>
</html>