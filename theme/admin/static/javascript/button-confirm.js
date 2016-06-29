$(function(){
    $('.btn-confirm').click(function(e){
        var $this = $(this);
        var title = $this.data('title') || 'Confirmation';
        var content = $this.data('confirm') || 'Are you sure?';
        var href = $this.attr('href');
        var label = $this.html();
        
        var classes = $this.attr('class').split(' ');
        classes.splice(classes.indexOf('btn-confirm'),1);
        if(!classes.length)
            classes = ['btn', 'btn-danger'];
        classes = classes.join(' ');
        
        // let create modal windows to confirm deletion
        var modal = '<div class="modal fade" tabindex="-1" role="dialog">'
                  +     '<div class="modal-dialog">'
                  +         '<div class="modal-content">'
                  +             '<div class="modal-header">'
                  +                 '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                  +                 '<h4 class="modal-title">' + title + '</h4>'
                  +             '</div>'
                  +             '<div class="modal-body">'
                  +                 '<p>' + content + '</p>'
                  +             '</div>'
                  +             '<div class="modal-footer">'
                  +                 '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'
                  +                 '<a class="' + classes + '" href="' + href + '">' + label + '</a>'
                  +             '</div>'
                  +         '</div>'
                  +     '</div>'
                  + '</div>';
        
        modal = $(modal);
        
        $('body').append(modal);
        modal.on('hidden.bs.modal', function(){
            modal.remove();
        });
        modal.modal('show');
        
        e.preventDefault();
    });
});