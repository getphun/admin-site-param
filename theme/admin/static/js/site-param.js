$(function(){
    $total = $('#params-total');
    var selectedGroup = '*';
    
    $('.group-selector a').click(function(){
        var $this = $(this);
        selectedGroup = $this.data('group');
        
        $('#params-filter').change().focus();
        $this.parent().find('a').removeClass('active');
        $this.addClass('active');
        
        return false;
    });
    
    $('#params-filter').on('keyup change paste', function(){
        $this = $(this);
        var value = $this.val();
        var items = $('.param-item');
        
        var length = 0;
        items.each(function(){
            var $item = $(this);
            var text  = $item.data('text');
            var group = $item.data('group');
            
            if(selectedGroup != '*' && group != selectedGroup)
                return $item.addClass('hidden');
            
            var method = 'addClass';
            if(~text.indexOf(value)){
                method = 'removeClass';
                length++;
            }
            $item[method]('hidden');
        });
        
        $total.html( length.toLocaleString().replace(/,/g,'.') );
    });
});