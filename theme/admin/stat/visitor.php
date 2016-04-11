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
            <?php if($ga_token): ?>
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="selectpicker" title="<?= _l('Timely') ?>" id="timely">
                            <option value="hourly" selected="selected"><?= _l('Hourly') ?></option>
                            <option value="daily"><?= _l('Daily') ?></option>
                            <option value="monthly"><?= _l('Montly') ?></option>
                            <option value="yearly"><?= _l('Yearly') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12" id="timely-chart-cont">
                    <canvas id="timely-chart" width="1140" height="350"></canvas>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12"><hr></div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4">
                            <span><?= _l('Sessions') ?></span>
                            <div class="lead" id="total-sessions"></div>
                        </div>
                        <div class="col-md-4">
                            <span><?= _l('Users') ?></span>
                            <div class="lead" id="total-users"></div>
                        </div>
                        <div class="col-md-4">
                            <span><?= _l('Pageviews') ?></span>
                            <div class="lead" id="total-pageviews"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php endif; ?>
        </div>
    </div>
    
    <?= $this->theme->file('foot') ?>
    
    <?php if($ga_token): ?>
    <script>
    function GAInit(){
        var navProgress = $('#nav-progress');
        
        gapi.auth.setToken({access_token: '<?= $ga_token ?>'});
        $('#timely').change(function(){
            
            var progresBar = $('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span>Loading...</span></div></div>');
            navProgress.append(progresBar);
            
            var now = new Date();
            var timely = $(this).val();
            var config = {
                    path: 'https://analyticsreporting.googleapis.com/v4/reports:batchGet',
                    method: 'POST',
                    body: {reportRequests:[]}
                };
            var query = {
                    viewId: '<?= $ga_view ?>',
                    metrics: [
                        { expression: 'ga:pageviews' },
                        { expression: 'ga:sessions' },
                        { expression: 'ga:users' }
                    ]
                };
            
            if(timely == 'hourly'){
                query.dateRanges = [{
                    startDate: now.toISOString().substr(0,10),
                    endDate: now.toISOString().substr(0,10)
                }];
                query.orderBys = [{fieldName: 'ga:hour'}];
                query.dimensions = [{ name: 'ga:hour' }];
                
            }else if(timely == 'daily'){
                var startDate = new Date();
                startDate = new Date(startDate.getFullYear(), startDate.getMonth(), 1, 8);
                
                query.dateRanges = [{
                    startDate: startDate.toISOString().substr(0,10),
                    endDate: now.toISOString().substr(0,10)
                }];
                
                query.orderBys = [{fieldName: 'ga:month'}, {fieldName: 'ga:day'}];
                query.dimensions = [{ name: 'ga:month' }, { name: 'ga:day' }];
                
            }else if(timely == 'monthly'){
                var startDate = new Date();
                startDate = new Date(startDate.getFullYear(), 0, 1, 8);
                
                query.dateRanges = [{
                    startDate: startDate.toISOString().substr(0,10),
                    endDate: now.toISOString().substr(0,10)
                }];
                
                query.orderBys = [{fieldName: 'ga:year'}, {fieldName: 'ga:month'}];
                query.dimensions = [{ name: 'ga:year' }, { name: 'ga:month' }];
                
            }else if(timely == 'yearly'){
                var startDate = new Date();
                startDate = new Date(startDate.getFullYear()-5, 0, 1, 8);
                
                query.dateRanges = [{
                    startDate: startDate.toISOString().substr(0,10),
                    endDate: now.toISOString().substr(0,10)
                }];
                
                query.orderBys = [{fieldName: 'ga:year'}];
                query.dimensions = [{ name: 'ga:year' }];
            }
            
            config.body.reportRequests.push(query);
            
            $('#timely-chart-cont').html('<canvas id="timely-chart" width="1140" height="350"></canvas>');
            $('#total-pageviews').html('');
            $('#total-sessions').html('');
            $('#total-users').html('');
            
            gapi.client.request(config).execute(function(res){
                progresBar.remove();
                
                if(res.error)
                    return alert(res.error.message);
                
                if(!res.reports[0].data.rows)
                    return;
                
                var totals = res.reports[0].data.totals[0].values;
                var res = res.reports[0].data.rows;
                
                var ctx = $('#timely-chart').get(0).getContext("2d");
                
                var data = {
                        labels: [],
                        datasets: [
                            { label: 'Pageviews', data: [], fillColor: 'rgba(240,173,78,0.2)', strokeColor: 'rgb(240,173,78)', pointColor: 'rgb(240,173,78)', pointStrokeColor: 'rgb(240,173,78)', pointHighlightFill: '#FFF', pointHighlightStroke: 'rgb(240,173,78)' },
                            { label: 'Sessions',   data: [], fillColor: 'rgba(91,192,222,0.2)', strokeColor: 'rgb(91,192,222)', pointColor: 'rgb(91,192,222)', pointStrokeColor: 'rgb(91,192,222)', pointHighlightFill: '#FFF', pointHighlightStroke: 'rgb(91,192,222)' },
                            { label: 'Users',      data: [], fillColor: 'rgba(92,184,92,0.2)',  strokeColor: 'rgb(92,184,92)',  pointColor: 'rgb(92,184,92)',  pointStrokeColor: 'rgb(92,184,92)',  pointHighlightFill: '#FFF', pointHighlightStroke: 'rgb(92,184,92)' }
                        ] 
                    };
                
                for(var i=0; i<res.length; i++){
                    if(timely == 'hourly'){
                        data.labels.push(res[i].dimensions[0] + ':00');
                    }else if(timely == 'daily'){
                        var dataLabel = new Date(2016, parseInt(res[i].dimensions[0])-1, parseInt(res[i].dimensions[1]))
                        data.labels.push(dataLabel.toDateString().substr(4,6));
                    }else if(timely == 'monthly'){
                        var dataLabel = new Date(res[i].dimensions[0], parseInt(res[i].dimensions[1])-1)
                        data.labels.push(dataLabel.toDateString().substr(4,3) + ' \'' + (dataLabel.getFullYear()+'').substr(2));
                    }else if(timely == 'yearly'){
                        data.labels.push(res[i].dimensions[0]);
                    }
                    
                    data.datasets[0].data.push(res[i].metrics[0].values[0]);
                    data.datasets[1].data.push(res[i].metrics[0].values[1]);
                    data.datasets[2].data.push(res[i].metrics[0].values[2]);
                }
                (new Chart(ctx).Line(data, {
                    bezierCurve: false,
                    responsive: true,
                    animation: false,
                    scaleLabel: function(v){ return parseInt(v.value).toLocaleString(); },
                    multiTooltipTemplate: function(tip){ return tip.datasetLabel + ' : ' + parseInt(tip.value).toLocaleString() }
                }));
                
                $('#total-pageviews').html(parseInt(totals[0]).toLocaleString());
                $('#total-sessions').html(parseInt(totals[1]).toLocaleString());
                $('#total-users').html(parseInt(totals[2]).toLocaleString());
            });
        });
        
        $('#timely').change();
    }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=GAInit"></script>
    <?php endif; ?>
</body>
</html>