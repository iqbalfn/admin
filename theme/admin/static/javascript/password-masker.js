// btn-password-masker
$(function(){
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
});