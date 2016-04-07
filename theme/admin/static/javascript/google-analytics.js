function GAGetProfileID(access_token, cb){
    var noop = function(){};
    
    gapi.analytics.ready(function() {
        
        gapi.analytics.auth.authorize({
            serverAuth: {
                access_token: access_token
            }
        });
        
        gapi.client.analytics.management.accounts.list()
        .then(function(res){
            if(!res.result.items || !res.result.items.length)
                return (cb||noop)(false);
            
            var firstId = res.result.items[0].id;
            gapi.client.analytics.management.webproperties.list({'accountId': firstId})
            .then(function(res){
                if(!res.result.items || !res.result.items.length)
                    return (cb||noop)(false);
                
                var firstAccountId  = res.result.items[0].accountId;
                var firstPropertyId = res.result.items[0].id;
                
                gapi.client.analytics.management.profiles.list({'accountId': firstAccountId,'webPropertyId': firstPropertyId})
                .then(function(res){
                    if(!res.result.items || !res.result.items.length)
                        return (cb||noop)(false);
                    
                    var firstProfileId = res.result.items[0].id;
                    (cb||noop)(firstProfileId);
                });
            });
        });
    });
    
}

function GAListenRealtime(viewId, cb){
    var rtOpts = {
        'ids': 'ga:' + viewId,
        'dimensions': 'rt:pagePath,rt:pageTitle,rt:keyword,rt:deviceCategory,rt:city,rt:country',
        'metrics': ['rt:activeUsers','rt:pageviews'],
        'sort': '-rt:activeUsers'
    };
    
    var rt = gapi.client.analytics.data.realtime.get(rtOpts);
    
    rt.execute(function(res){
        (cb||noop)(res);
        
        if(res.error)
            return;
        
        setTimeout(function(viewId, cb){
            GAListenRealtime(viewId, cb);
        }, 5000, viewId, cb);
    });
}