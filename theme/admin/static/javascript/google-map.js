// google map location pickup
$(function(){
    $('.form-control-location').each(function(i,e){
        var $e = $(e);
        var pickerId = $e.attr('id') + '-location-pickup';
        var sboxCreated = false;
        var opts = {
                radius: 0,
                enableAutocomplete: true,
                onchanged: function(cloc, rad, isdrop){
                    if(!isdrop)
                        return;
                    $e.val(cloc.latitude + ',' + cloc.longitude);
                },
                oninitialized: function(component){
                    if(sboxCreated)
                        return;
                    
                    var mapContext = $(component).locationpicker('map');
                    var map = mapContext.map;
                    var input = $('<input type="search" class="form-control input-sm" placeholder="Find Location" style="margin-left:10px;margin-top:10px;width:75%;">').get(0);
                    var searchBox = new google.maps.places.SearchBox(input);
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                    
                    $(input).keypress(function(e){
                        if(e.keyCode == 13)
                            return false;
                    })
                    
                    map.addListener('bounds_changed', function() {
                        $(input).val('');
                    });
                    
                    searchBox.addListener('places_changed', function() {
                        var places = searchBox.getPlaces();
                        var geometry = places[0].geometry;
                        var loc = geometry.location.lat() + ',' + geometry.location.lng();
                        $e.val(loc);
                        $e.change();
                    });
                    
                    sboxCreated = true;
                }
            };
        if($e.val()){
            var eloc = $e.val().split(',');
            opts.location = {
                latitude: parseFloat(eloc[0]),
                longitude: parseFloat(eloc[1])
            }
        }
        $('#'+pickerId).locationpicker(opts);
        
        $e.change(function(){
            if(!$e.val())
                return;
            
            delete opts.location;
            var eloc = $e.val().split(',');
            opts.location = {
                latitude: parseFloat(eloc[0]),
                longitude: parseFloat(eloc[1])
            }
            
            $('#'+pickerId).locationpicker(opts);
        });
    });
});