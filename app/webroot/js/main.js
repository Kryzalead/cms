jQuery(function($){

    /**
    * SettingButton
    * */
    $('#settings a.backgroundChanger').each(function(){
        $(this).css('background',$(this).attr('href'));
    });

    $('#settings a.backgroundChanger').unbind('click').click(function(){
        $('#settings a.backgroundChanger').removeClass('active'); 
        $(this).addClass('active'); 
        $('#sidebar img').each(function(){
            $(this).attr('src', $(this).attr('src').replace('/dark/','/')  );
        });
        if($(this).hasClass('dark')){
            $('body').addClass('dark'); 
            $('#sidebar').attr('class','black'); 
        }else{
            $('body').removeClass('dark'); 
            $('#sidebar').attr('class','grey'); 
        }
        var link = $(this).attr('href'); 
        $('body').css('background',link);
        return false;
    });
    
    
    $('#settings a.blocChanger').unbind('click').click(function(){
        $('#settings a.blocChanger').removeClass('active'); 
        $(this).addClass('active'); 
        $('#content').attr('class',$(this).attr('href')); 
        return false;
    });
    
    $('#settings a.sidebarChanger').unbind('click').click(function(){
        $('#settings a.sidebarChanger').removeClass('active'); 
        $(this).addClass('active'); 
        $('#sidebar').attr('class',$(this).attr('href')); 
        if($(this).attr('href')=='white'){
            $('#sidebar img').each(function(){
                $(this).attr('src', $(this).attr('src').replace('/menu/','/menu/dark/')  );
            }); 
        }else{
            $('#sidebar img').each(function(){
                $(this).attr('src', $(this).attr('src').replace('/dark/','/')  );
            });
        }
        return false;
    });

    $('#settings').css('marginRight',-150);
    var toggled = false; 
    $('#settings a.settingbutton').click(function(){
        if(toggled){
            $('#settings').animate({marginRight:-$('#settings').width()},500);
        }else{
            $('#settings').animate({marginRight:0},500);
        }
        toggled = !toggled; 
        return false
    });

	
    /** 
     * Sidebar menus
     * Slidetoggle for menu list
     * */
    var currentMenu = null; 
    $('#sidebar>ul>li').each(function(){
        if($(this).find('li').length == 0){
            $(this).addClass('nosubmenu');
        }
    });

    $('#sidebar>ul>li:not([class*="current"])>ul').hide();
    $('#sidebar>ul>li:not([class*="nosubmenu"])>a').click(function(){
       e = $(this).parent();
       if(e.hasClass('current')){ e.removeClass('current').find('ul:first').slideUp(); return false;  }
       $('#sidebar>ul>li.current').removeClass('current').find('ul:first').slideUp();
       e.addClass('current').find('ul:first').slideDown(); 
       return false; 
    });

    var htmlCollapse = $('#menucollapse').html(); 
    
    if($.cookie('isCollapsed') === 'true'){
        $('body').addClass('collapsed'); 
        $('#menucollapse').html('&#9654;');
    } 
    
    $('#menucollapse').click(function(){
        var body = $('body'); 
        body.toggleClass('collapsed');
        isCollapsed = body.hasClass('collapsed');
        if(isCollapsed){
        $(this).html('&#9654;');
        }else{
            $(this).html(htmlCollapse); 
        }
        $.cookie('isCollapsed',isCollapsed); 
        return false; 
    });


    /**
    * Slide toggle for blocs
    * */
    $('.bloc .title').append('<a href="#" class="toggle"></a>');
    $('.bloc .title .tabs').parent().find('.toggle').remove(); 
    $('.bloc .title .toggle').click(function(){
        $(this).toggleClass('hide').parent().parent().children('.content').slideToggle(300);
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

    /**
    * Animation connexion Login couleur
    * */
    $('#login').prepend('<div id="maskContainer"><div id="logmask"></div></div>');

    $("#maskContainer").css("opacity",0);
    $("input").focus(function(){
        $("#maskContainer").stop().fadeTo(500,1);
    });
    $("input").blur(function(){
        $("#maskContainer").fadeTo(500,0);
    });
    animateGlow($("#logmask"));

    /*
    * Check le nom du menu avant validation
    */
    $('#MenuEditForm').submit(function(){
        var menu_id = $(this).find('#MenuId').val();
        if(menu_id == 0){
            var menu_name = $(this).find('#MenuName');
            if(menu_name.val() == ''){
            $(menu_name).css('border','1px solid red');
                return false;
            }
        }
    });

    /**
     * Fake Placeholder
     * User labels as placeholder for the next input
     * */
     
    $('.placeholder,#content.login .input').each(function(){
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

    /**
     * Hide notification when close button is pressed
    **/
    $('.notif .close').click(function(){
        $(this).parent().fadeTo(500,0).slideUp(); 
        return false; 
    });

    /*
    *   Affichage ou non du select des pages pour le choix de la page d'acceuil
    */
    $("#OptionShowOnFrontPage").click(function(){
        if($(this).is(':checked'))
            $('#page_on_front').removeAttr('disabled');
    });

    $("#OptionShowOnFrontPost").click(function(){
        if($(this).is(':checked'))
            $('#page_on_front').attr('disabled','disabled');
    });
});


function animateGlow(div){
    div.css({backgroundPositionX:0})
    .animate({backgroundPositionX:-3000},25000,"linear",function(){animateGlow(div); })
}