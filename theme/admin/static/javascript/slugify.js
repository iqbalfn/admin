(function ($) {
    'use strict';
    
    $.fn.slugify = function(){
        return this.each(function(i,e){
            if($(e).val())
                return;
            
            var dirty;
            $(e).focus(function(){ dirty = true; });
            
            var source = $($(e).data('source'));
            source.on('change keyup', function(){
                if(dirty)
                    return;
                var slug = source.val().toLowerCase();
                slug = slug.replace(/[^a-z0-9]/g, '-');
                slug = slug.replace(/\-+/g, '-').replace(/^([^a-z0-9]+)|([^a-z0-9]+)$/g, '');
                $(e).val(slug);
            });
        });
    };
    
})(jQuery);

$(function(){
    $('.slugify').slugify();
});