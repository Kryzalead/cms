jQuery(function($){
	$('#UserPassword').keyup(function(){
		var options = {
			verdects:	["très faible","faible","moyen","fort","très fort","court","simple"],
			colors: 	["#f00","#c06", "#f60","#3c0","#3f0","#f00","#ccc"],
			scores: 	[10,15,30,40],
			common:		["motdepasse","123456","123","1234","azerty"],
			minPasswordLength:	7,
		}
		var strength = 0;
		var div = $('#pass_strength_result');
		var password = $(this).val();
		var bar = $("#strength_bar");
		var text = $("#strength_text");

		if(password.length < options.minPasswordLength) // beaucoup trop court
			strength -= 100;
		else if (password.length >= options.minPasswordLength && password.length <= (options.minPasswordLength + 2)) // court
			strength += 6;
		else if (password.length >= options.minPasswordLength+3 && password.length <= (options.minPasswordLength + 4)) // moyen
			strength += 12;
		else if (password.length >= (options.minPasswordLength + 5)) // long
			strength += 18;	
		if(password.match(/[a-z]/)) // vérifie qu'il y a au moins une lettre minuscule
			strength += 1;
		if(password.match(/[A-Z]/)) // vérifie qu'il y a au moins une lettre majuscule
			strength += 5;
		if(password.match(/\d+/)) // vérifie qu'il y a au moins un chiffre
			strength += 5;
		if(password.match(/(.*[0-9].*[0-9].*[0-9])/)) // vérifie qu'il y a 3 chiffres
			strength += 7;
		if(password.match(/.\W/)) // vérifie qu'il y a un caractère spécial
			strength += 5;
		if(password.match(/(.*\W.*\W)/)) // vérifie qu'il y a deux caractères spéciaux
			strength += 7;
		if(password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) // vérifie qu'il y a des majuscules et des minuscules
			strength += 2;
		if(password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) // vérifie qu'il y a des lettres et des chiffres
			strength += 3;
		if(password.match(/([a-zA-Z0-9].*\W)|(\W.*[a-zA-Z0-9])/)) // chiffres, lettres et caractères spécial
			strength += 3;	
		if(password.match(/(\w)\1{2}/)) // mot de passe contient 3 caractères identiques à la suite
			strength -= 10;
		if(password.match(/[a-z]{4}/i))	// mot de passe contient 3 caractères alpha à la suite
			strength -= 5;
		
		//calcule le ratio entre caractères alpha, numéric et spéciaux:
		var split = password.split(/\d/);
		var cnt_num = split.length-1;
		split = password.split(/\W/);
		var cnt_special = split.length-1;
		var cnt_alpha = password.length-cnt_alpha-cnt_special;
		var diff_alphanum = cnt_alpha-cnt_num;
		if(diff_alphanum <= password.length/3 || diff_alphanum >= -password.length/3) {
			intScore += 7;
		}
		var diff_alphaspecial = cnt_alpha-cnt_special;
		if(diff_alphaspecial <= password.length/3 || diff_alphaspecial >= -password.length/3) {
			intScore += 7;
		}	
		for (var i=0; i < options.common.length; i++) {
			//check that the password doesn't contain a common word
			if (password.toLowerCase() == options.common[i]) {
				intScore = -200;
			} else if (password.toLowerCase().indexOf(options.common[i]) >= 0) {
				intScore -= 20;
			}
		}
		// affichage
		if(strength <= -200){
			strColor = options.colors[6];
			strText = options.verdects[6];
			$(bar).css({width: "0%"});
		}
		else if(strength <= 0 && strength >= -199){
			strColor = options.colors[5];
			strText = options.verdects[5];
			$(bar).css({width: "1%"});
		}
		else if(strength >= 0 && strength <= 10){
			strColor = options.colors[0];
			strText = options.verdects[0];
			$(bar).css({width: "1%"});
		}
		else if (strength > options.scores[0] && strength <= options.scores[1]){
	   		strColor = options.colors[1];
			strText = options.verdects[1];
			$(bar).css({width: "25%"});
		}
		else if (strength > options.scores[1] && strength <= options.scores[2]){
		   	strColor = options.colors[2];
			strText = options.verdects[2];
			$(bar).css({width: "50%"});
		}
		else if (strength > options.scores[2] && strength <= options.scores[3]){
		   	strColor = options.colors[3];
			strText = options.verdects[3];
			$(bar).css({width: "75%"});
		}
		else{
		   	strColor = options.colors[4];
			strText = options.verdects[4];
			$(bar).css({width: "99%"});
		}
		bar.css({borderColor: strColor});
		text.css({color: strColor});
		text.html(strText);
	});	
});
