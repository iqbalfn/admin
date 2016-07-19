// object filterer

$(function(){
    $('.object-filter')
        .selectpicker({
            liveSearch: true
        })
        .ajaxSelectPicker({
//             preserveSelected: true,
            ajax: {
                url: '/admin/object-filter',
                data: function(){
                    var el = this.plugin.$element;
                    var params = {
                            q: '{{{q}}}',
                            table: el.data('table')
                        };
                    return params;
                },
                method: 'get'
            },
            preprocessData: function(data){
                if(data.error)
                    return [];
                
                var el = this.plugin.$element;
                var lbl = el.data('label');
                var vlu = el.data('value');
                
                data = data.data;
                var result = [];
                for(var i=0; i<data.length; i++){
                    result.push({
                        value: data[i][vlu],
                        text: data[i][lbl],
                        disabled: false
                    });
                }
                
                return result;
            }
        });
    $('.object-filter-cleaner').each(function(i,e){
        $(e).click(function(){
            var target = $($(this).data('target'));
            target.selectpicker('val', '');
        });
    });
});