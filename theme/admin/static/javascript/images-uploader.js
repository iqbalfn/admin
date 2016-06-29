+function(window, $){
    'use strict';
    
    $.fn.imageUploader = function(){
        
        this.change(function(){
            var $this = $(this);
            var dataTarget = $this.attr('id');
            var images = $this.val().trim().split(',');
            var thumberDiv = $('#' + $this.attr('id') + '-thumber' );
            thumberDiv.html('');
            
            if(!images.length)
                return;
            
            for(var i=0; i<images.length; i++){
                var image = images[i];
                if(!image)
                    continue;
                
                image = image.replace(/\.([a-zA-Z]+)$/, '_242x121.$1');
                $('<div class="thumbnail"></div>')
                    .append('<a class="btn btn-default btn-xs thumbnail-closer" data-index="'+i+'" title="Delete" data-target="'+dataTarget+'"><i class="glyphicon glyphicon-remove"></i></a>')
                    .append('<img alt="IMAGE" src="'+image+'">')
                    .appendTo(thumberDiv);
            }
            
            thumberDiv.find('.thumbnail-closer').click(function(){
                var el = $(this);
                var target = $('#' + el.data('target'));
                var index = el.data('index');
                var lastVal = target.val().trim().split(',');
                lastVal.splice(index,1);
                target.val(lastVal.join(','));
                target.change();
            });
        });
        
        this.change();
    };
    
    $.fn.imageUploaderBtn = function(){
        
        this.click(function(){
            var $this = $(this);
            var targetId = $this.data('target');
            var target   = $('#' + targetId);
            var accept   = target.data('accept');
            var type     = target.data('type');
            var object   = target.data('object');
            
            $.selectFile(accept, function(file){
                var opts = {'type': type};
                if(object)
                    opts.object = object;
                opts.name = file.name;
                
                $.uploadFile(file, opts, function(err, res){
                    if(err)
                        return alert(err);
                    
                    var lastVal = target.val().trim().split(',');
                    lastVal.push(res.media_file);
                    target.val(lastVal.join(','));
                    target.change();
                });
            });
        });
        
    }
    
}(window, jQuery);

$(function(){
    $('.images-uploader').imageUploader();
    $('.images-uploader-file').imageUploaderBtn();
});