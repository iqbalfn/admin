$(function(){
    // btn-password-masker
    $('.btn-password-masker').click(function(e){
        var target = $('#' + $(this).data('target'));
        var targetType = target.attr('type');
        var nextType = targetType == 'password' ? 'text' : 'password';
        
        target.attr('type', nextType);
        
        var classToRemove = nextType != 'text' ? 'glyphicon-eye-close' : 'glyphicon-eye-open';
        var classToAdd    = nextType != 'text' ? 'glyphicon-eye-open' : 'glyphicon-eye-close';
        
        var i = $(this).children('i');
        i.removeClass(classToRemove).addClass(classToAdd);
    });

    $('.color-picker').colorpicker();
    $('.date-picker').datetimepicker({format: 'YYYY-MM-DD'});
    $('.datetime-picker').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('.month-picker').datetimepicker({format: 'MM'});
    $('.time-picker').datetimepicker({format: 'HH:mm:ss'});
    $('.textarea-dynamic').autosize();
    $('.btn-uploader').fileUploader();
    $('.slugify').slugify();
    
    $('.tokenfield').tokenfield();
    
    $('.select-box').selectpicker();
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent))
        $('.select-box').selectpicker('mobile');
    
    $('.object-filter')
        .selectpicker({
            liveSearch: true
        })
        .ajaxSelectPicker({
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
    
    // tinymce
    if($('.tinymce').get(0)){
        var options = {
                // main options
                selector: '.tinymce',
                menubar: false,
                plugins: 'link table image media fullscreen pagebreak contextmenu autoresize paste wordcount',
                toolbar: 'undo redo | styleselect | bold italic link | bullist numlist | table image media | pagebreak | fullscreen',
                content_css: '/theme/admin/static/css/tinymce-content.css',
                
                // autoresize plugins
                autoresize_min_height: 400,
                autoresize_bottom_margin: 0,
                
                // paste configuration
                paste_word_valid_elements: 'b,i,em,h1,h2,h3,a,li,ul,ol',
                paste_retain_style_properties: '',
                paste_preprocess: function(plugin, args){
                    // TODO clean user pasted content
                },
                
                // pagebreak plugins
                pagebreak_separator: '<!-- PAGE BREAK -->',
                
                // parser configuration
                convert_fonts_to_spans: true,
                element_format: 'html',
                fix_list_elements: true,
                invalid_styles: {'*': 'color font-size font-family align summary'},
                schema: 'html5',
                browser_spellcheck: true,
                
                // link plugins
                rel_list: [
                    { title: 'None', value: '' },
                    { title: 'No Follow', value: 'nofollow' }
                ],
                
                // image plugins
                image_dimensions: false,
                image_caption: true,
                image_prepend_url: false,
  
                // media plugins
                media_alt_source: false,
                media_dimensions: false,
                media_poster: false,
                video_template_callback: function(data){
                    if(!/facebook\.com\//.test(data.source1)){
                        return (
                            '<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' +
                                '<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' +
                                (data.source2 ? '<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') +
                            '</video>'
                        );
                    }else{
                        return (
                            '<div class="fb-video" contenteditable="false" data-href="' + data.source1 + '" data-allowfullscreen="true" data-width="500">' +
                                '<a href="' + data.source1 + '" target="_blank">&#160;</a>' +
                            '</div>'
                        );
                    }
                },
                
                file_browser_callback: function(form, url, type, wind, wah){
                    var accept = type == 'image' ? 'image/*' : undefined;
                    var cTextArea = $(tinyMCE.activeEditor.targetElm);
                    var opts = {'type': cTextArea.data('type')};
                    
                    if(cTextArea.data('object'))
                        opts.object = cTextArea.data('object');
                    
                    $.selectFile(accept, function(file){
                        opts.name = file.name;
                        
                        $.uploadFile(file, opts, function(err, data){
                            if(err)
                                return alert(err);
                            $('#'+form).val(data.media_file);
                        });
                    });
                }
            };
        
        tinymce.init(options);
    }
});