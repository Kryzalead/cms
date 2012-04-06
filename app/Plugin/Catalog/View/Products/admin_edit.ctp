<h1>
    <?php echo $this->Html->image($icon_for_layout,array('width'=>72,'height'=>72)); ?>
    <?php echo $title_for_layout ?>
</h1>

<?php echo $this->Form->create('Product',array('action'=>'edit')) ?>
<div class="blocsCentral">
	<?php echo $this->Form->input('Product.name',array('label'=>'Modèle : ','style'=>'width:100%')) ?>
	<br />
	<?php echo $this->Form->input('Product.slug',array('label'=>'Url : ','style'=>'width:100%')) ?>
	<br />
	<?php echo $this->Form->input('Product.id'); ?>
        <?php echo $this->Form->input('Product.user_id',array('label'=>false,'type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))) ?>
	<?php echo $this->Form->input('Product.product_type',array('type'=>'hidden','value'=>$type)) ?>
    <?php echo $this->Form->input('Product.action',array('label'=>null,'type'=>'hidden','value'=>$action)); ?>
	<?php echo $this->Form->input('Product.description',array('label'=>'Descriptif : ','style'=>'width:100%','rows'=>Configure::read('default_post_edit_rows'))) ?>
	<?php echo $this->Form->input('Product.price',array('label'=>"Prix de Vente ",'type'=>'text')); ?>
	<?php echo $this->Form->input('Product.product_buy_price',array('label'=>"Valeur d'Achat ",'type'=>'text')); ?>
</div>

<div id="blocsAjoutCote">
    <div class="bloc_publier_image"><!-- Publier -->
        <h3>Publier</h3>
            <div>
                <p>
                	<?php echo $this->Form->input('status',array('label'=>false,'type'=>'select','options'=>$list_status),$status_selected) ?>
                <p>
            </div>
    </div>

    <div class="bloc_publier_image" id="bloc_img_une"><!-- image à la une -->
        <h3>Image à la une</h3>
            <div>
                <p><?php echo $this->Html->link("Ajouter une image à la une",array('controller'=>'medias','action'=>'tinymce'),array('id'=>'add-post-thumbnail')); ?></p>
            </div>
    </div>        
</div>
<div id="overlayer" style="display:none"></div>
<?php echo $this->Form->end($texte_submit) ?>

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
        image_explorer: '<?php echo $this->Html->url(array('plugin'=>null,'controller'=>'medias','action'=>'tinymce')); ?>',
        image_edit: '<?php echo $this->Html->url(array('plugin'=>null,'controller'=>'medias','action'=>'tinymce','url')); ?>',
        lien_explorer: '<?php echo $this->Html->url(array('plugin'=>null,'controller'=>'posts','action'=>'tinymce')) ?>',
        relative_urls: false,
        content_css: '<?php echo $this->Html->url('/css/wysiwyg.css') ?>',
        entity_encoding : "raw",
        // Schema is HTML5 instead of default HTML4
        schema: "html5",
        // End container block element when pressing enter inside an empty block
        end_container_on_empty_block: true,

        // HTML5 formats
        style_formats : [
                {title : 'h1', block : 'h1'},
                {title : 'h2', block : 'h2'},
                {title : 'h3', block : 'h3'},
                {title : 'h4', block : 'h4'},
                {title : 'h5', block : 'h5'},
                {title : 'h6', block : 'h6'},
                {title : 'p', block : 'p'},
                {title : 'div', block : 'div'},
                {title : 'pre', block : 'pre'},
                {title : 'section', block : 'section', wrapper: true, merge_siblings: false},
                {title : 'article', block : 'article', wrapper: true, merge_siblings: false},
                {title : 'blockquote', block : 'blockquote', wrapper: true},
                {title : 'hgroup', block : 'hgroup', wrapper: true},
                {title : 'aside', block : 'aside', wrapper: true},
                {title : 'figure', block : 'figure', wrapper: true}
        ]
    });

    // fonction qui permet de renvoyer du code à tinymce
    function send_to_editor(content){
        // on init l'editeur
        var ed = tinyMCE.activeEditor;
        ed.execCommand('mceInsertContent',false,content);
    }
    
<?php $this->Html->scriptEnd(); ?>