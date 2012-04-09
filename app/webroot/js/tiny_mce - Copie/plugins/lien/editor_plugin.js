/*
*	Plugin tinyMCE pour l'ajout des lien
*/

(function(){
	
	// on crée le plugin
	// 2ème paramètre est un objet qui contient les différentes fonctionnalité de notre plugin
	tinymce.create('tinymce.plugins.lien',{
		
		// 1ère action fait par tinymce est la fonction init
		// ed : editeur
		// url : url du plugin
		init:function(ed,url){
			this.editor = ed;
			// on ajoute une commande
			// open_image : nom de la commande
			// function : fonction de la commande
			ed.addCommand('open_lien',function(){

				// on stocke l'url
				var url = ed.settings.lien_explorer;
				var el = ed.selection.getNode();
				var se = ed.selection;

				// No selection and not in link
				if (se.isCollapsed() && !ed.dom.getParent(se.getNode(), 'A'))
					return;

				// si l'élement sélectionné est un lien
				if(el.nodeName == 'A'){
					// on récupère le contenu ainsi que les attributs du lien
					src		=	ed.dom.getAttrib(el,'href');
					title 	=	ed.dom.getAttrib(el,'title');
				}
				else{
					src		=	'';
					title 	=	'';
				}

				content=se.getContent();

				url += '?content='+content+'&src='+src+'&title='+title;

				// on ouvre une fenêtre avec l'objet windowManager de tinymce
				// il permet de gérer tout ce qui est ouverture et fermeture des fenetre

				ed.windowManager.open({
					// url : url du fichier à appeller
					// id  : id de la syntaxe html
					// inline : précise si l'on souhaite utiliser le plugin inlinepopup
					// title : titre de la fenêtre
					file	: url,
					id		: 'lien',
					width	: 670,
					height	: 566,
					inline 	: true,
					title 	: 'Insérer / Editer un lien'
				},{
					// url du plugin
					plugin_url : url
				});

				ed.onNodeChange.add(function(ed, cm, n, co) {
					cm.setDisabled('link', co && n.nodeName != 'A');
					cm.setActive('link', n.nodeName == 'A' && !n.name);
				});

			});

			// on crée le bouton pour lancer la commande
			// image : nom du bouton
			// title : attr title du bouton
			// cmd   : commande à appeller lors du clic sur le bouton
			ed.addButton('link',{
				title 	: 'Insérer un lien',
				cmd 	: 'open_lien'
			});
		}
	});

	// on ajoute notre plugin à tinymce
	tinymce.PluginManager.add('lien',tinymce.plugins.lien);
})();