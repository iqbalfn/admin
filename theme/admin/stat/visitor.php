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
            <div class="col-md-12">
                
                <div class="row">
                    <div class="col-md-12">
                        <fieldset id="statistic-hourly-container">
                            <legend><?= _l('Hourly') ?> <sub>(<span class="tt-session" title="<?= _l('Sessions') ?>"></span> / <span class="tt-user" title="<?= _l('Users') ?>"></span> )</sub></legend>
                            <canvas width="1140" height="250" id="statistic-hourly"></canvas>
                        </fieldset>
                    </div>
                </div>
                
                <div>&#160;</div>
                
                <div class="row">
                    
                    <div class="col-md-6">
                        <fieldset id="statistic-daily-container">
                            <legend><?= _l('Daily') ?> <sub>(<span class="tt-session" title="<?= _l('Sessions') ?>"></span> / <span class="tt-user" title="<?= _l('Users') ?>"></span> )</sub></legend>
                            <canvas width="555" height="250" id="statistic-daily"></canvas>
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6">
                        <fieldset id="statistic-monthly-container">
                            <legend><?= _l('Monthly') ?> <sub>(<span class="tt-session" title="<?= _l('Sessions') ?>"></span> / <span class="tt-user" title="<?= _l('Users') ?>"></span> )</sub></legend>
                            <canvas width="555" height="250" id="statistic-monthly"></canvas>
                        </fieldset>
                    </div>
                    
                </div>
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
            
            var numToMonth = {
                    '01': 'Jan',
                    '02': 'Feb',
                    '03': 'Mar',
                    '04': 'Apr',
                    '05': 'May',
                    '06': 'Jun',
                    '07': 'Jul',
                    '08': 'Aug',
                    '09': 'Sep',
                    '10': 'Oct',
                    '11': 'Nov',
                    '12': 'Dec'
                };
            
            for(var name in gaData){
                +function (name, query, id){
                    query['end-date'] = 'today';
                    query['metrics']  = 'ga:sessions,ga:users';
                    query['ids'] = 'ga:' + id;
                    
                    var report = new gapi.analytics.report.Data({query: query});
                    report.on('success', function(res) {
                        if(!res.rows || !res.rows.length)
                            return;
                        
                        var chartC = $('#statistic-'+name+'-container');
                        var chartCanvas = chartC.find('canvas');
                        
                        var charts = [];
                        chartC.find('.tt-session').html( (parseInt(res.totalsForAllResults['ga:sessions'])).toLocaleString() );
                        chartC.find('.tt-user').html( (parseInt(res.totalsForAllResults['ga:users'])).toLocaleString() );
                        
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
        });
    </script>
    <?php endif; ?>
</body>
</html>