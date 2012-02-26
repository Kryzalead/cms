<h1><?php echo $this->Html->image('icone-pages-add.png',array('width'=>62,'height'=>62)); ?>Ajouter une page</h1>
<?php echo $this->Form->create('Post') ?>

<div class="blocsCentral">
	<?php echo $this->Form->input('name',array('label'=>'Titre : ','style'=>'width:100%')) ?>
	   <br />
	<?php echo $this->Form->input('slug',array('label'=>'Url : ','style'=>'width:100%')) ?>
	   <br />
	<?php echo $this->Form->input('id'); ?>
            <?php echo $this->Form->input('user_id',array('label'=>false,'type'=>'hidden')) ?>
	<?php echo $this->Form->input('type',array('type'=>'hidden','value'=>'page')) ?>
	<?php echo $this->Form->input('content',array('label'=>'Contenu : ','rows'=>15,'style'=>'width:100%')) ?>
</div>

<div id="blocsAjoutCote">
    <div class="bloc_publier_image"><!-- Publier -->
            <h3>Publier :</h3>
                <div>
                    <p>
                        <?php echo $this->Form->input('status',array('label'=>false,'type'=>'select','options'=>$status),$selected) ?>
                    <p>
                    <p><input type="submit" name="preview" value="aperçu" class="submit"><p>
                    <p><input type="submit" value="publier" class="submit"></p>
                </div>
    </div>

    <div class="bloc_publier_image" id="bloc_img_une"><!-- image à la une -->
        <h3>Image à la une :</h3>
                <div>
                    <p><a href="">Ajouter une image à la une</a></p>
                </div>
    </div>
</div>
  
<?php echo $this->Form->end('Envoyer') ?>
<?php echo $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php 
// tout ce qui sera compris entre ces deux balises, sera envoyé au niveau du body grâce à inline=>false

/* config tinyMCE
 
 mode : defini le mode, 'textareas' pour tout les textareas
 tehme : défini le theme
 plugins : défini les plugins
    inlinepopups : affiche des popups pour l'ajout des images
    paste: gére tous les copier coller
 theme_advanced_buttonsx : défini les boutons de la rangée x
 theme_advanced_toolbar_location : position de la barre d'outil
 theme_advanced_statusbar_location : position de la barre de status
 theme_advanced_resizing: défini si le textarea peut être redimensionné
 paste_remove_styles : spécifie qu'on ne souhaite pas copier le style
 paste_remove_spans : spécifie qu'on ne souhaite pas les span
 paste_strip_class_attributes: signifie qu'on ne souhaite pas copier les class css
 image_explorer: lien vers l'action à appellerlosr du clic sur le bouton
 image_edit: action à appeller losr du clic sur le bouton lors d'une sélection
 relative_urls: met les url en absolue
 content_css: css utilisé par l'editeur
*/
 ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    tinyMCE.init({
        mode                    :   'textareas',
        theme                   :   'advanced',
        plugins                 :   'inlinepopups,paste,image,lien',
        theme_advanced_buttons1  : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image,|,formatselect,code',
        theme_advanced_buttons2  : '',
        theme_advanced_buttons3  : '',
        theme_advanced_buttons4  : '',
        theme_advanced_toolbar_location : 'top',
        theme_advanced_statusbar_location : 'bottom',
        theme_advanced_resizing: false,
        paste_remove_styles: true,
        paste_remove_spans: true,
        paste_strip_class_attributes: 'all',
        image_explorer: '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'tinymce')); ?>',
        image_edit: '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'tinymce','url')); ?>',
        lien_explorer: '<?php echo $this->Html->url(array('controller'=>'pages','action'=>'tinymce')) ?>',
        relative_urls: false,
        content_css: '<?php echo $this->Html->url('/css/wysiwyg.css') ?>'
    });

    // fonction qui permet de renvoyer du code à tinymce
    function send_to_editor(src,title){
        // on init l'editeur
        var ed = tinyMCE.activeEditor;
        tinyMCE.execCommand("mceReplaceContent",false,'<a href="'+src+'" title="'+title+'">{$selection}</a>');
        
        return true;
    }
<?php $this->Html->scriptEnd(); ?>