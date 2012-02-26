/*
*	Plugin tinyMCE pour l'ajout des images
*/

(function(){
	
	// on crée le plugin
	// 2ème paramètre est un objet qui contient les différentes fonctionnalité de notre plugin
	tinymce.create('tinymce.plugins.image',{
		
		// 1ère action fait par tinymcs est la fonction init
		// ed : editeur
		// url : url du plugin
		init:function(ed,url){
			
			// on ajoute une commande
			// open_image : nom de la commande
			// function : fonction de la commande
			ed.addCommand('open_image',function(){
				
				// on récupère si un element a été sélectioné
				var el = ed.selection.getNode();
				// on stocke l'url
				var url = ed.settings.image_explorer;

                // el.nodeName contient le type de l'élément
				if(el.nodeName == 'IMG'){                     
					url = ed.settings.image_edit;
					url += '?src='+ed.dom.getAttrib(el,'src')+'&title='+ed.dom.getAttrib(el,'title')+'&alt='+ed.dom.getAttrib(el,'alt')+'&class='+ed.dom.getAttrib(el,'class');
				}

				// on ouvre une fenêtre avec l'objet windowManager de tinymce
				// il permet de gérer tout ce qui est ouverture et fermeture des fenetre

				ed.windowManager.open({
					// url : url du fichier à appeller
					// id  : id de la syntaxe html
					// inline : précise si l'on souhaite utiliser le plugin inlinepopup
					// title : titre de la fenêtre
					file	: url,
					id		: 'image',
					width	: 670,
					height	: 566,
					inline 	: true,
					title 	: 'Insérer une image'
				},{
					// url du plugin
					plugin_url : url
				});

			});

			// on crée le bouton pour lancer la commande
			// image : nom du bouton
			// title : attr title du bouton
			// cmd   : commande à appeller lors du clic sur le bouton
			ed.addButton('image',{
				title 	: 'Insérer une image',
				cmd 	: 'open_image'
			});
		}
	});

	// on ajoute notre plugin à tinymce
	tinymce.PluginManager.add('image',tinymce.plugins.image);
})();