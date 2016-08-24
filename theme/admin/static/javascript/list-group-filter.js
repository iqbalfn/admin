$(function(){
    var listGroup = $('.list-group-filter');
    if(!listGroup.get(0))
        return;
    
    listGroup.each(function(i,e){
        var cont = $(e);
        var form = cont.find('.list-group-filter-form');
        var formQuery = form.find('input.list-group-filter-query');
        var formSort = form.find('select.list-group-filter-sort');
        
        formQuery.keyup(function(){
            var items = cont.find('.list-group-filter-item');
            var value = $(this).val();
            if(!value)
                return items.removeClass('hidden');
            
            var re = new RegExp(value, 'i');
            items.each(function(i,e){
                var $e = $(e);
                var name = $e.data('order-title') || $e.data('order-name');
                var method = re.test(name) ? 'removeClass' : 'addClass';
                $e[method]('hidden');
            });
        });
        
        cont.find('.list-group-filter-sort-desc').click(function(){
            setTimeout(function(){ formSort.change(); }, 200);
        });
        
        formSort.change(function(){
            var value = $(this).val();
            var items = cont.find('.list-group-filter-item');
            var itemsCont = cont.find('.list-group-filter-items');
            var itemSortCond = cont.find('.list-group-filter-sort-desc');
            var sortCond = 'ASC';
            if(itemSortCond.get(0))
                sortCond = itemSortCond.hasClass('active') ? 'DESC' : 'ASC';
            
            itemsCont.html('');
            
            items.sort(function(a,b){
                var aVal = $(a).data('order-'+value);
                var bVal = $(b).data('order-'+value);
                
                // ranking rank always start from 1, 0 mean infinity
                if(value == 'rank'){
                    if(sortCond == 'ASC'){
                        aVal = aVal > 0 ? aVal : 100000;
                        bVal = bVal > 0 ? bVal : 100000;
                    }else{
                        aVal = aVal > 0 ? aVal : -1;
                        bVal = bVal > 0 ? bVal : -1;
                    }
                }
                
                if(sortCond === 'ASC')
                    return aVal < bVal ? -1 : aVal > bVal ? 1 : 0;
                return aVal > bVal ? -1 : aVal < bVal ? 1 : 0;
            });
            
            items.each(function(i,e){
                itemsCont.append(e);
            });
        });
    });
});