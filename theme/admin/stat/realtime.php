<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->theme->file('head') ?>
    <?php if($ga_token): ?>
    <script>
    (function(w,d,s,g,js,fs){
    g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
    js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
    js.src='https://apis.google.com/js/platform.js';
    fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
    }(window,document,'script'));
    </script>
    <?php endif; ?>
</head>
<body>
    <?= $this->theme->file('header') ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header"><h1><?= $title ?></h1></div>
            </div>
            <?php if($ga_token): ?>
            <div class="col-md-4">
                <fieldset>
                    <legend><?= _l('Online User') ?></legend>
                    <div class="text-center" id="realtime-online-total" style="font-size:90px">0</div>
                    <i class="glyphicon glyphicon-stop text-success"></i> <?= _l('Mobile') ?>
                    <i class="glyphicon glyphicon-stop text-warning"></i> <?= _l('Desktop') ?>
                    <i class="glyphicon glyphicon-stop text-info"></i> <?= _l('Tablet') ?>
                    <i class="glyphicon glyphicon-stop text-default"></i> <?= _l('Other') ?>
                    <div class="progress">
                        <div title="Mobile" id="realtime-device-mobile" class="progress-bar progress-bar-success" style="width: 25%"></div>
                        <div title="Desktop" id="realtime-device-desktop" class="progress-bar progress-bar-warning" style="width: 25%"></div>
                        <div title="Tablet" id="realtime-device-tablet" class="progress-bar progress-bar-info" style="width: 25%"></div>
                        <div title="Other" id="realtime-device-other" class="progress-bar progress-bar-default" style="width: 25%"></div>
                    </div>
                </fieldset>
                
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#realtime-keywords-container" aria-controls="home" role="tab" data-toggle="tab"><?= _l('Keywords') ?></a></li>
                        <li role="presentation"><a href="#realtime-cities-container" aria-controls="home" role="tab" data-toggle="tab"><?= _l('Cities') ?></a></li>
                        <li role="presentation"><a href="#realtime-countries-container" aria-controls="home" role="tab" data-toggle="tab"><?= _l('Country') ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="realtime-keywords-container">
                            <div>&#160;</div>
                            <table class="table table-bordered">
                                <thead><tr><th><?= _l('Keyword') ?></th><th><?= _l('Users') ?></th></tr></thead>
                                <tbody id="realtime-keywords"></tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="realtime-cities-container">
                            <div>&#160;</div>
                            <table class="table table-bordered">
                                <thead><tr><th><?= _l('City') ?></th><th><?= _l('Users') ?></th></tr></thead>
                                <tbody id="realtime-cities"></tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="realtime-countries-container">
                            <div>&#160;</div>
                            <table class="table table-bordered">
                                <thead><tr><th><?= _l('Country') ?></th><th><?= _l('Users') ?></th></tr></thead>
                                <tbody id="realtime-countries"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">  
                <fieldset>
                    <legend><?= _l('Pages') ?></legend>
                    <table class="table table-bordered">
                        <thead><tr><th><?= _l('Page') ?></th><th><?= _l('User') ?></th></tr></thead>
                        <tbody id="realtime-pages"></tbody>
                    </table>
                </fieldset>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    
    <?php if($ga_token): ?>
    <script>
        GAGetProfileID('<?= $ga_token ?>', function(viewId){
            if(!viewId)
                return;
            
            GAListenRealtime(viewId, function(res){
                if(res.error)
                    return top.location.reload();
                
                // total online user
                var totalOnlineUser = parseInt(res.totalsForAllResults['rt:activeUsers']);
                
                if($('#realtime-online-total').html() != totalOnlineUser)
                    $('#realtime-online-total').html( (totalOnlineUser).toLocaleString() );
                
                var devices = { mobile: 0, desktop: 0, tablet: 0, other: 0 };
                var keywords = {};
                var pages = {};
                var cities = {};
                var countries = {};
                
                for(var i=0;i<res.rows.length; i++){
                    var row = res.rows[i];
                    var device = row[3].toLowerCase();
                    var users = parseInt(row[6]);
                    var keyword = row[2];
                    var page = row[0];
                    var title = row[1];
                    var city = row[4];
                    var country = row[5];
                    
                    if(devices.hasOwnProperty(device))
                        devices[device]+= users;
                    
                    if(!pages[page])
                        pages[page] = { title: null, total: 0, url: page };
                    pages[page].total+= users;
                    if(title != '(not set)')
                        pages[page].title = title;
                    
                    if(keyword != '(not set)'){
                        if(!keywords[keyword])
                            keywords[keyword] = 0;
                        keywords[keyword]+= users;
                    }
                    
                    if(!cities[city])
                        cities[city] = 0;
                    cities[city]+= users;
                    
                    if(!countries[country])
                        countries[country] = 0;
                    countries[country]+= users;
                }
                
                // devices statistic
                for(var k in devices){
                    var percent = ( parseInt(devices[k]) / totalOnlineUser ) * 100;
                    var percentLabel = Math.round(percent);
                    var el = $('#realtime-device-'+k);
                    el.attr('title', '' + percentLabel + '%');
                    el.width(percent+'%');
                    el.html('');
                    if(percent > 10)
                        el.html(percentLabel + '%');
                }
                
                // keywords
                var keywordsSorted = [];
                for(var k in keywords)
                    keywordsSorted.push([k, keywords[k]]);
                keywordsSorted.sort(function(a,b){ return b[1] - a[1]; });
                
                var ERealtimeKeywords = $('#realtime-keywords');
                ERealtimeKeywords.html('');
                for(var i=0; i<keywordsSorted.length; i++){
                    var keywords = keywordsSorted[i][0];
                    var total    = (keywordsSorted[i][1]).toLocaleString();
                    $('<tr><td>' + keywords + '</td><td>' + total + '</td></tr>').appendTo(ERealtimeKeywords);
                }
                
                // cities
                var citiesSorted = [];
                for(var k in cities)
                    citiesSorted.push([k, cities[k]]);
                citiesSorted.sort(function(a,b){ return b[1] - a[1]; });
                
                var ERealtimeCities = $('#realtime-cities');
                ERealtimeCities.html('');
                for(var i=0; i<citiesSorted.length; i++){
                    var city = citiesSorted[i][0];
                    var total    = (citiesSorted[i][1]).toLocaleString();
                    $('<tr><td>' + city + '</td><td>' + total + '</td></tr>').appendTo(ERealtimeCities);
                }
                
                // country
                var countriesSorted = [];
                for(var k in countries)
                    countriesSorted.push([k, countries[k]]);
                countriesSorted.sort(function(a,b){ return b[1] - a[1]; });
                
                var ERealtimeCountries = $('#realtime-countries');
                ERealtimeCountries.html('');
                for(var i=0; i<countriesSorted.length; i++){
                    var country = countriesSorted[i][0];
                    var total    = (countriesSorted[i][1]).toLocaleString();
                    $('<tr><td>' + country + '</td><td>' + total + '</td></tr>').appendTo(ERealtimeCountries);
                }
                
                // pages
                var pagesSorted = [];
                for(var k in pages)
                    pagesSorted.push(pages[k]);
                pagesSorted.sort(function(a,b){ return b.total - a.total; });
                
                var ERealtimePages = $('#realtime-pages');
                ERealtimePages.html('');
                for(var i=0; i<pagesSorted.length; i++){
                    var row = pagesSorted[i];
                    var href = '<?= base_url() ?>' + row.url.slice(1);
                    var label= row.url;
                    var title= row.title;
                    var total= (row.total).toLocaleString();
                    
                    $('<tr><td><a href="'+href+'" title="'+title+'" target="_blank">'+label+'</a></td><td>'+total+'</td></tr>').appendTo(ERealtimePages);
                }
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>