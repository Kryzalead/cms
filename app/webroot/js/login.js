jQuery(function($){

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
});

function animateGlow(div){
    div.css({backgroundPositionX:0})
    .animate({backgroundPositionX:-3000},25000,"linear",function(){animateGlow(div); })
}