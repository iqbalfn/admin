$(function(){
    if($('.tinymce').get(0)){
        var options = {
                // main options
                selector: '.tinymce',
                menubar: false,
                plugins: 'link table image media fullscreen pagebreak contextmenu autoresize paste wordcount',
                toolbar: 'undo redo | styleselect | bold italic link | bullist numlist | table image media | pagebreak | paste | fullscreen',
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