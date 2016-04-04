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
            <div class="col-md-8">
            
                <?php if($ranks): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header"><h2>Ranks</h2></div>
                    </div>
                    
                    <?php if(array_key_exists('alexa', $ranks)): ?>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>
                                <a href="<?= base_url('/admin/stat/calculate/alexa') ?>" title="<?= _l('Refresh') ?>"><sup class="glyphicon glyphicon-refresh"></sup></a>
                                Alexa
                                <sub>
                                (
                                    <span title="<?= _l('International') ?>"><?= number_format($ranks['alexa'][(count($ranks['alexa'])-1)]['data'][0]['label']) ?></span>
                                    /
                                    <span title="<?= _l('Local') ?>"><?= number_format($ranks['alexa'][(count($ranks['alexa'])-1)]['data'][1]['label']) ?></span>
                                )
                                </sub>
                            </legend>
                        </fieldset>
                        <canvas width="360" height="200" class="chart" data-chart='<?= json_encode($ranks['alexa'], JSON_UNESCAPED_SLASHES) ?>'></canvas>
                        <div>&#160;</div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(array_key_exists('similarweb', $ranks)): ?>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>
                                <a href="<?= base_url('/admin/stat/calculate/similarweb') ?>" title="<?= _l('Refresh') ?>"><sup class="glyphicon glyphicon-refresh"></sup></a>
                                SimilarWeb
                                <sub>
                                (
                                    <span title="<?= _l('International') ?>"><?= number_format($ranks['similarweb'][(count($ranks['similarweb'])-1)]['data'][0]['label']) ?></span>
                                    /
                                    <span title="<?= _l('Local') ?>"><?= number_format($ranks['similarweb'][(count($ranks['similarweb'])-1)]['data'][1]['label']) ?></span>
                                )
                                </sub>
                            </legend>
                        </fieldset>
                        <canvas width="360" height="200" class="chart" data-chart='<?= json_encode($ranks['similarweb'], JSON_UNESCAPED_SLASHES) ?>'></canvas>
                        <div>&#160;</div>
                    </div>
                    <?php endif; ?>
                    
                </div>
                <?php endif; ?>
                
                <div class="row">
                
                    <?php if($ga_token): ?>
                    
                    <div class="col-md-12 hidden" id="chart-session-hourly">
                        <div class="page-header"><h2>Sessions</h2></div>
                        
                        <fieldset>
                            <legend>
                                Hourly
                                <sub>
                                (
                                    <span title="<?= _l('Sessions') ?>" class="cs-sess"></span>
                                    /
                                    <span title="<?= _l('Users') ?>" class="cs-user"></span>
                                )
                                </sub>
                            </legend>
                        </fieldset>
                        <canvas width="750" height="200" class="chart"></canvas>
                        <div>&#160;</div>
                    </div>
                    
                    <div class="col-md-6 hidden" id="chart-session-daily">
                        <fieldset>
                            <legend>
                                Daily
                                <sub>
                                (
                                    <span title="<?= _l('Sessions') ?>" class="cs-sess"></span>
                                    /
                                    <span title="<?= _l('Users') ?>" class="cs-user"></span>
                                )
                                </sub>
                            </legend>
                        </fieldset>
                        <canvas width="360" height="200" class="chart"></canvas>
                        <div>&#160;</div>
                    </div>
                    
                    <div class="col-md-6 hidden" id="chart-session-monthly">
                        <fieldset>
                            <legend>
                                Monthly
                                <sub>
                                (
                                    <span title="<?= _l('Sessions') ?>" class="cs-sess"></span>
                                    /
                                    <span title="<?= _l('Users') ?>" class="cs-user"></span>
                                )
                                </sub>
                            </legend>
                        </fieldset>
                        <canvas width="360" height="200" class="chart"></canvas>
                        <div>&#160;</div>
                    </div>
                    
                    <?php endif; ?>
                </div>
                
            </div>
            
            <div class="col-md-4">
                <?php if($ga_token): ?>
                <div class="page-header"><h2>RealTime</h2></div>
                
                <fieldset>
                    <legend>Online User</legend>
                    <pre class="lead text-center" id="realtime-total">0</pre>
                </fieldset>
                
                <fieldset>
                    <legend>Keywords</legend>
                    <table class="table table-hover table-bordered">
                        <tbody id="realtime-keywords"></tbody>
                    </table>
                </fieldset>
                
                <fieldset>
                    <legend>Active Page</legend>
                    <table class="table table-hover table-bordered">
                        <tbody id="realtime-page"></tbody>
                    </table>
                </fieldset>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    
    <?php if($ga_token): ?>
    <script>
        
        var tenMonthAgo = new Date();
        tenMonthAgo.setMonth(tenMonthAgo.getMonth() - 10);
        tenMonthAgo = tenMonthAgo.toISOString().substr(0,10);
        var gaData = {
                hourly: {
                    'start-date': 'today',
                    'dimensions': 'ga:hour',
                    'sort': 'ga:hour'
                },
                daily: {
                    'start-date': '10daysAgo',
                    'dimensions': 'ga:day,ga:month',
                    'sort': 'ga:month,ga:day'
                },
                monthly: {
                    'start-date': tenMonthAgo,
                    'dimensions': 'ga:month,ga:year',
                    'sort': 'ga:year,ga:month'
                }
            };
        
        var numToMonth = {'01': 'Jan','02': 'Feb','03': 'Mar','04': 'Apr','05': 'May','06': 'Jun','07': 'Jul','08': 'Aug','09': 'Sep','10': 'Oct','11': 'Nov','12': 'Dec'};
        
        function gaCharts(viewId){
            for(var name in gaData){
            
                +function (name, query, id){
                    query['end-date'] = 'today';
                    query['metrics']  = 'ga:sessions,ga:users';
                    query['ids'] = 'ga:' + id;
                    
                    var report = new gapi.analytics.report.Data({query: query});
                    report.on('success', function(res) {
                        if(!res.rows || !res.rows.length)
                            return;
                        
                        var chartC = $('#chart-session-' + name);
                        var chartCanvas = chartC.find('canvas');
                        chartC.removeClass('hidden');
                        
                        var charts = [];
                        chartC.find('.cs-sess').html( (parseInt(res.totalsForAllResults['ga:sessions'])).toLocaleString() );
                        chartC.find('.cs-user').html( (parseInt(res.totalsForAllResults['ga:users'])).toLocaleString() );
                        
                        for(var i=0; i<res.rows.length; i++){
                            var row = res.rows[i];
                            var chartName,
                                currMax,
                                value1, value2,
                                label1, label2;
                            
                            if(name == 'hourly'){
                                chartName = row[0] + ':00';
                                label1 = value1 = parseInt(row[1]);
                                label2 = value2 = parseInt(row[2]);
                                
                            }else if(name == 'daily'){
                                chartName = row[0] + ' ' + numToMonth[row[1]];
                                label1 = value1 = parseInt(row[2]);
                                label2 = value2 = parseInt(row[3]);
                                
                            }else if(name == 'monthly'){
                                chartName = numToMonth[row[0]] + ' \'' + row[1].substr(2);
                                label1 = value1 = parseInt(row[2]);
                                label2 = value2 = parseInt(row[3]);
                                
                            }
                            
                            var chart = {
                                    name: chartName,
                                    data: [
                                        { label: label1, value: value1, title: 'Sessions' },
                                        { label: label2, value: value2, title: 'Users' }
                                    ]
                                };
                            
                            charts.push(chart);
                        }
                        
                        chartCanvas.chart(charts);
                    });
                    
                    report.execute();
                }(name, gaData[name], viewId);
            }
        }
        
        function gaRealtime(viewId){
        
            var fetchTotalUserOnline = function(){
                var rtOpts = {
                    'ids': 'ga:' + viewId,
                    'dimensions': 'rt:pagePath,rt:pageTitle,rt:keyword',
                    'metrics': ['rt:activeUsers','rt:pageviews'],
                    'sort': '-rt:activeUsers'
                };
                
                var rt = gapi.client.analytics.data.realtime.get(rtOpts);
                rt.execute(function(res){
                    
                    if(res.totalsForAllResults)
                        $('#realtime-total').html( (parseInt( res.totalsForAllResults['rt:activeUsers'] )).toLocaleString() );
                    
                    var tKeywords = $('#realtime-keywords');
                    tKeywords.html('');
                    var tPages = $('#realtime-page');
                    tPages.html('');
                    
                    var keywords = {};
                    var pages = {};
                    for(var i=0; i<res.rows.length; i++){
                        var row = res.rows[i];
                        var keyword = row[2];
                        if(!keywords[keyword])
                            keywords[keyword] = 0;
                        keywords[keyword]++;
                        
                        if(!pages[row[0]])
                            pages[row[0]] = { title: row[1], total: 0 };
                        pages[row[0]].total+= parseInt(row[3]);
                    }
                    
                    var pagesSorted = [];
                    for(var k in pages)
                        pagesSorted.push([k, pages[k].title, pages[k].total]);
                    pagesSorted.sort(function(a,b){ return b[2] - a[2]; });
                    
                    for(var i=0; i<pagesSorted.length; i++){
                        var row = pagesSorted[i];
                        var a = '<a href="' + row[0] + '" target="_blank" title="' + row[1] + '">' + row[0] + '</a>';
                        var ttl = (row[2]).toLocaleString();
                        var tr = $('<tr><td>' + a + '</td><td>' + ttl + '</td></tr>');
                        
                        tPages.append(tr);
                        
                        if(i>8)
                            break;
                    }
                    
                    var keywordsSorted = [];
                    for(var k in keywords)
                        keywordsSorted.push([k, keywords[k]]);
                    keywordsSorted.sort(function(a,b){ return b[1] - a[1]; });
                    
                    for(var i=0; i<keywordsSorted.length; i++){
                        var row = keywordsSorted[i];
                        var tr = $('<tr><td>' + row[0] + '</td><td>' + (parseInt(row[1])).toLocaleString() + '</td></tr>');
                        tKeywords.append(tr);
                        if(i>8)
                            break;
                    }
                });
            }
            
            setInterval(fetchTotalUserOnline, 5000);
            fetchTotalUserOnline();
        }
        
        gapi.analytics.ready(function() {
            gapi.analytics.auth.authorize({
                serverAuth: {
                    access_token: '<?= $ga_token ?>'
                }
            });
            
            gapi.client.analytics.management.accounts.list()
            .then(function(res){
                if(!res.result.items || !res.result.items.length)
                    return;
                
                var firstId = res.result.items[0].id;
                gapi.client.analytics.management.webproperties.list({'accountId': firstId})
                .then(function(res){
                    if(!res.result.items || !res.result.items.length)
                        return;
                    
                    var firstAccountId  = res.result.items[0].accountId;
                    var firstPropertyId = res.result.items[0].id;

                    gapi.client.analytics.management.profiles.list({'accountId': firstAccountId,'webPropertyId': firstPropertyId})
                    .then(function(res){
                        if(!res.result.items || !res.result.items.length)
                            return;
                        
                        /**
                         * Finally!
                         * What the fuck is wrong with you Google API 
                         * Why do I need to do this long steps only to 
                         * get this single 9 chars numbers
                         */
                        var firstProfileId = res.result.items[0].id;
                        gaCharts(firstProfileId);
                        gaRealtime(firstProfileId);
                    });
                });
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>