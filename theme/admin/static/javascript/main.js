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
    
    // color picker
    $('.color-picker').colorpicker();
    $('.date-picker').datetimepicker({format: 'YYYY-MM-DD'});
    $('.datetime-picker').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('.month-picker').datetimepicker({format: 'MM'});
    $('.time-picker').datetimepicker({format: 'HH:mm:ss'});
    $('.textarea-dynamic').autosize();
    $('.select-box').selectpicker();
    
    if($('.tinymce').get(0)){
        tinymce.init({
            selector: '.tinymce',
            menubar: false,
            statusbar: false,
            plugins: 'link table image media fullscreen pagebreak contextmenu autoresize paste',
            toolbar: 'undo redo | styleselect | bold italic link | bullist numlist | table image media | pagebreak | fullscreen',
            
            content_css: '/theme/admin/static/css/tinymce-content.css',
            
            autoresize_min_height: 400,
            
            autoresize_bottom_margin: 0,
            
            paste_as_text: true,
            paste_word_valid_elements: 'b,strong,i,em,h1,h2,h3',
            paste_retain_style_properties: '',
            
            pagebreak_separator: '<!-- PAGE BREAK -->',
            
            convert_fonts_to_spans: true,
            element_format: 'html',
            fix_list_elements: true,
            invalid_styles: {'*': 'color font-size font-family'},
            schema: 'html5',
            browser_spellcheck: true
        });
    }
});