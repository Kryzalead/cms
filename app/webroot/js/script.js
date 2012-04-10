jQuery(function($){

	$('.placeholder').each(function(){
        var label = $(this).find('label:first');
        var input = $(this).find('input:first,textarea:first'); 

        if(input.val() != ''){
           label.stop().hide(); 
        }
        input.focus(function(){
           if($(this).val() == ''){
                label.stop().fadeTo(500,0.5);  
           }
           $(this).parent().removeClass('error').find('.error-message').fadeOut(); 
        });
        input.blur(function(){
           if($(this).val() == ''){
                label.stop().fadeTo(500,1);  
           }
        });
        input.keypress(function(){
          label.stop().hide(); 
        });
        input.keyup(function(){
           if($(this).val() == ''){
                label.stop().fadeTo(500,0.5); 
           }
        });
        input.bind('cut copy paste', function(e) {
            label.stop().hide(); 
        });
    }); 

    $('.close').click(function(){$(this).parent().fadeTo(500,0).slideUp();});

        $('#nav_menu li.niv_principal a').hover(
        function() {
        $(this).stop().animate({
        fontSize: "24px",
          color: "#AA4673"
        }, 250, function() {
          // Animation complete.
        });
        });

        $('#nav_menu li.niv_principal a').mouseleave(
        function() {
        $(this).stop().animate({
        fontSize: "18px"
        }, 250, function() {
          // Animation complete.
        });
    });
});