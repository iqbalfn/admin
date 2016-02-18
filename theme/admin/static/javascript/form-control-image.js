$(function(){
    $('.form-control-image').change(function(){
        var previewer = $(this).data('preview');
        var value = $(this).val();
        
        if(!value)
            return $('#'+previewer).html('');
        
        $('#'+previewer).html('<img src="' + value + '" alt="Image not found">');
    });
});