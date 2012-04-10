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
    $('.bloc .bloc_titre').append('<a href="#" class="toggle"></a>');
    
    $('.bloc .bloc_titre .toggle').click(function(){
        $(this).toggleClass('hide').parent().parent().children('.bloc_contenu').slideToggle(300);
        return false; 
    });
    $('.bloc.hidden').each(function(){
        var e = $(this); 
        e.find('.bloc_contenu').hide(); 
        e.find('.toggle').addClass('hide');
    });

    /**
    * CheckAll, if the checkbox with checkall class is checked/unchecked all checkbox would be checked
    * */
    $('#content .checkall').change(function(){
        $(this).parents('table:first').find('input').attr('checked', $(this).is(':checked')); 
    });

    

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

    /*
    *   Affichage de l'aide
    */
    $(".show-settings").click(function(){
        link = $(this);
        var href = $(this).attr('href');
        var id = $(this).attr('id');
    
        if(id == 'contextual-help-link'){
            if(link.hasClass('active')){
                $('#bouton_options_ecran').show();
                link.removeClass('active');
            }
                
            else{
                link.addClass('active');
                $('#bouton_options_ecran').hide();
            }
                
        }
        else{
            if(link.hasClass('active')){
                link.removeClass('active');
                $('#contextual-help-link-wrap').show();
            }
                
            else{
                link.addClass('active');
                $('#contextual-help-link-wrap').hide();
            }
               
        }
        $(href).slideToggle(300);
        return false;
    });

    $('.colonne_menu ul li a').click(function(){
        var link = $(this);
        var href = $(this).attr('href');

        var old = $('.colonne_menu ul li.active');
        var old_href = old.children('a').attr('href');
        
        old.removeClass('active');
        $(old_href).removeClass('active');

        link.parent('li').addClass('active');
        $(href).addClass('active');
        return false;
    });

    $('#show-dialog').click(function(){
        var link = $(this).attr('href');
        var div = $('<div id="dialog"></div>')
            .html('<iframe frameborder="0" style=" width: 680px; height: 501px; " src="' + link + '"></iframe>')
            .dialog({
                autoOpen: false,
                modal: false,
                height: 501,
                width: 670,
                title: 'Ajouter une image',
                resizable: false,
                open: function (event, ui) {
                    $('#dialog').css('overflow', 'hidden');
                }
            });
            div.dialog('open');
        return false;
    });
});


