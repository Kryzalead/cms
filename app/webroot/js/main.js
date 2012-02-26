jQuery(function($){
	
	/** 
     * Sidebar menus
     * Slidetoggle for menu list
     * */
    var currentMenu = null; 
    $('#sidebar>ul>li').each(function(){
        if($(this).find('li').length == 0){
            $(this).addClass('nosubmenu');
        }
    })
    $('#sidebar>ul>li:not([class*="current"])>ul').hide();
    $('#sidebar>ul>li:not([class*="nosubmenu"])>a').click(function(){
       e = $(this).parent();
       if(e.hasClass('current')){ e.removeClass('current').find('ul:first').slideUp(); return false;  }
       $('#sidebar>ul>li.current').removeClass('current').find('ul:first').slideUp();
       e.addClass('current').find('ul:first').slideDown();  
       return false;
    });

    /**
     * Slide toggle for blocs
     * */
     $('.bloc .title').append('<a href="#" class="toggle"></a>');
     $('.bloc .title .tabs').parent().find('.toggle').remove(); 
     $('.bloc .title .toggle').click(function(){
         $(this).toggleClass('hide').parent().parent().find('.content').slideToggle(300);
         return false; 
     });
     $('.bloc.hidden').each(function(){
      var e = $(this); 
      e.find('.content').hide(); 
      e.find('.toggle').addClass('hide');
     });

     /**
     * CheckAll, if the checkbox with checkall class is checked/unchecked all checkbox would be checked
     * */
    $('#content .checkall').change(function(){
        $(this).parents('table:first').find('input').attr('checked', $(this).is(':checked')); 
    });
});