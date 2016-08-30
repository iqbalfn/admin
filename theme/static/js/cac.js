$(function(){
    var ajaxContentEls = $('.ajax-content');
    
    if(!ajaxContentEls.length)
        return;
    
    var storage = {
            exists: function(name){ return window.localStorage && window.localStorage[name]; },
            value : function(name){ return window.localStorage && window.localStorage[name] ? window.localStorage[name] : false },
            set   : function(name, value){ window.localStorage && window.localStorage.setItem(name, value); },
        };
        
    ajaxContentEls.each(function(i,e){
        var $e = $(e);
        var source = $e.data('source');
        var rule = $e.data('rule');
        
        if(storage.exists(source))
            $e.html(storage.value(source));
    });
    
    $.getJSON('/update.json', function(res){
        var toUpdate = [];
        var lastUpdate = storage.exists('_update_json') ? JSON.parse(storage.value('_update_json')) : {};
        
        if(!/debug/.test(location.href)){
            for(var k in res){
                if(lastUpdate[k] && res[k] == lastUpdate[k])
                    continue;
                toUpdate.push(k);
            }
            storage.set('_update_json', JSON.stringify(res));
        }else{
            for(var k in res)
                toUpdate.push(k);
        }
            
        // get list of data to fetch
        ajaxContentEls.each(function(i,e){
            var $e = $(e);
            var source = $e.data('source');
            var rules = $e.data('rule').split('|');
            var update = false;
            
            for(var i=0; i<rules.length; i++){
                
                if(~toUpdate.indexOf(rules[i])){
                    update = true;
                    break;
                }
            }
            
            if(!update)
                return;
            
            $.get(source, function(res){
                $e.html(res);
                storage.set(source, res);
            });
        });
    });
});