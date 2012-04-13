jQuery(function($){

	$('.placeholder').each(function(){
      var label = $(this).find('label:first');
      var input = $(this).find('input:first,textarea:first'); 

      if(input.val() != ''){
         label.stop().hide(); 
      }
       input.click(function(){
        label.stop().hide(); 
      });
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

        $('#nav_menu li.niv_principal a').hover(function() {
          $(this).stop().animate({
          fontSize: "24px",
            color: "#AA4673"
          }, 250, function() {
            // Animation complete.
          });
        });

        $('#nav_menu li.niv_principal a').mouseleave(function() {
          $(this).stop().animate({
          fontSize: "18px"
          }, 250, function() {
            // Animation complete.
        });
    });

    $('.dynamic-select').bind('change',function(){
      var url = $(this).val();
      window.location = url;
    });

    if($('#show_filter').hasClass('active')){
      $("#filtre_produit").show();
      $('#show_filter_text').html('Masquer les filtres');
      $('#show_filter_arrow').addClass('active_arrow');
    }
    else
      $("#filtre_produit").hide();

    $('#show_filter a').click(function(){
      var a = $('#show_filter_text');
      var active = a.parent('span').attr('class');

      if(active){
        a.html('Afficher les filtres');
        $('#filtre_produit').stop().slideUp(300);
        a.parent('span').removeClass('active');
        $('#show_filter_arrow').removeClass('active_arrow');
      }
      else{
        a.html('Masquer les filtres');
        $('#filtre_produit').stop().slideDown(300);
        a.parent('span').addClass('active');
        $('#show_filter_arrow').addClass('active_arrow');
      }
    });

    $('#show_form_comment').click(function(){
      $(this).toggleClass('active').parent().next('#guestbook_add').slideToggle(300);
    });
    $('#show_form_comment').each(function(){
      if($(this).hasClass('active')){
        $('#guestbook_add').show();
      }
    });

    if($('.notif').length > 0){
      $('.notif').delay(3000).slideUp('slow');    
    }
});