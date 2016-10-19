(function ($) {
    'use strict';
    
    var navProgress = $('#nav-progress');
    
    $.uploadFile = function(file, opts, cb){
        var progresBar = $('<div class="progress">'
                       +    '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'
                       +        '<span>' + file.name  + '</span></div></div>');
        navProgress.append(progresBar);
        
        var formData = new FormData(),
            xhr = new XMLHttpRequest();
        
        for(var k in opts)
            formData.append(k, opts[k]);
        formData.append('file', file, file.name);
        
        xhr.open('POST', '/upload', true);
        
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
                if(xhr.status == 200){
                    var res = window.JSON.parse(xhr.responseText);
                    progresBar.remove();
                    cb(res.error, res.data);
                }
            }
        }
        
        xhr.send(formData);
    }
    
    $.selectFile = function(accept, cb){
        // create the input file element.
        var input = $('<input type="file">');
        if(accept)
            input.attr('accept', accept);
        
        input.change(function(){
            var file = $(this).get(0).files[0];
            input.remove();
            cb(file);
        });
        
        window.setTimeout(function(){ input.click(); });
    }
    
    $.fn.fileUploader = function(){
        
        $(this).click(function(){
            var targetId = $(this).data('target');
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
                    
                    target.val(res.media_file);
                    target.change();
                });
            });
        });
        
    };
    
})(jQuery);

$(function(){
    $('.btn-uploader').fileUploader();
});