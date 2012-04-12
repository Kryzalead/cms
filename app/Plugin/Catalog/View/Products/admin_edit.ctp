<h1>
    <?php echo $this->Html->image($icon_for_layout,array('width'=>72,'height'=>72)); ?>
    <?php echo $title_for_layout ?>
</h1>

<?php echo $this->Form->create('Product',array('action'=>'edit','type'=>'file','id'=>'edit_post')) ?>
<div class="blocsCentral">
	<?php echo $this->Form->input('Product.name',array('label'=>'Saisissez le nom du modèle ici : ','id'=>'title_form','div'=>array('class'=>'placeholder'))) ?>
	<br />
	<?php echo $this->Form->input('Product.slug',array('label'=>"Saisissez l'url ici ",'id'=>'slug_form','div'=>array('class'=>'placeholder'))) ?>
	<br />
	<?php echo $this->Form->input('Product.id'); ?>
    <?php echo $this->Form->input('Product.user_id',array('label'=>false,'type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))) ?>
	<?php echo $this->Form->input('Product.product_type',array('type'=>'hidden')) ?>
    <?php echo $this->Form->input('Product.action',array('label'=>null,'type'=>'hidden')); ?>
	<?php echo $this->Form->input('Product.description',array('label'=>false,'rows'=>Configure::read('default_post_edit_rows'))) ?>
    <div class="bloc" id="produit_images">
        <h3 class="bloc_titre">
            Autres images
            <?php echo $this->Html->link("Ajouter une image",array('action'=>'addattachment','controller'=>'products','?'=>array('product_id'=>$product['Product']['id'])),array('id'=>'show_form_attachment')); ?>
        </h3>
        <div class="bloc_contenu">
             <?php if (!empty($product['Product_attachement'])): ?>
                 <ul class="liste_produits_image">
                     <?php foreach ($product['Product_attachement'] as $k => $v): ?>
                        <?php 
                        $dimension = getimagesize (IMAGES_URL.$v['url_min']); 
                        $largeur = 100;$hauteur = 100;
                        if ($dimension[1] > $hauteur OR $dimension[0] > $largeur) { 
                        // X plus grand que Y 
                            if ($dimension[1] < $dimension[0]) { 
                                 $width = $hauteur; 
                                 $y = floor($width * ($dimension[1]/$dimension[0])); 
                            } 
                            // Y plus grand que X 
                            else{ 
                                 $height = $largeur; 
                                 $width = floor($height * ($dimension[0]/$dimension[1])); 
                            } 
                        } 
                        else { 
                             $width = $dimension[0]; 
                             $height = $dimension[1]; 
                        }?>
                        <li>
                            <?php echo $this->Html->image($v['url_min'],array('width'=>$width,'height'=>$height)) ?>
                            <?php echo $this->Html->link("X",array('action'=>'admin_delattachment','?'=>array('attachment_id'=>$v['id'])),array('class'=>'del_thumb')); ?>
                        </li>
                     <?php endforeach ?>
                 </ul>
             <?php endif ?>
        </div>
    </div>	
</div>
<div id="blocsAjoutCote">
    <div class="add_meta bloc" id="bloc_post_publier"><!-- Publier -->
        <h3 class="bloc_titre">Publier</h3>
        <div class="inside bloc_contenu">
            <p>
                <?php echo $this->Form->input('status',array('label'=>'Etat : ','type'=>'select','options'=>$list_status),$status_selected) ?>
                <?php echo $this->Form->submit($texte_submit) ?>
            <p>
        </div>
    </div>
    <div class="add_meta bloc" id="bloc_image_une"><!-- Publier -->
        <h3 class="bloc_titre">Image principale</h3>
        <div class="inside bloc_contenu">
            <?php if (!empty($product['Product']['url_min'])): ?>
                <p class="product_thumb">
                    <?php 
                        $dimension = getimagesize ($product['Product']['url_min']); 
                        $largeur = 200;$hauteur = 200;
                        if ($dimension[1] > $hauteur OR $dimension[0] > $largeur) { 
                        // X plus grand que Y 
                            if ($dimension[1] < $dimension[0]) { 
                                 $width = $hauteur; 
                                 $y = floor($width * ($dimension[1]/$dimension[0])); 
                            } 
                            // Y plus grand que X 
                            else{ 
                                 $height = $largeur; 
                                 $width = floor($height * ($dimension[0]/$dimension[1])); 
                            } 
                        } 
                        else { 
                             $width = $dimension[0]; 
                             $height = $dimension[1]; 
                        }
                    echo $this->Html->image($product['Product']['url_min'],array('width'=>$width,'height'=>$height)) ?>
                </p>
            <?php endif ?>
            <?php echo $this->Form->input('Product_url',array('label'=>false,'type'=>'file')); ?>
        </div>
    </div>
    <div class="add_meta bloc" id="bloc_prix"><!-- Publier -->
        <h3 class="bloc_titre">Prix</h3>
        <div class="inside bloc_contenu">
            <p>
                <?php echo $this->Form->input('Product.price',array('label'=>"Prix de Vente ",'type'=>'text','after'=>' €')); ?>
                <?php echo $this->Form->input('Product.product_buy_price',array('label'=>"Valeur d'Achat ",'type'=>'text','after'=>' €')); ?>
            <p>
        </div>
    </div>
    <?php if ($type == 'accessoire'): ?>
        <div class="add_meta bloc" id="bloc_categorie">
            <h3 class="bloc_titre">Catégorie</h3>
            <div class="inside bloc_contenu">
                <p>
                    <?php echo $this->Form->input('terms_product_category',array('label'=>false,'type'=>'select','options'=>$terms_product_category)); ?>
                <p>
            </div>
        </div>
    <?php endif ?>
    <?php if ($type == 'robe-de-mariee'): ?>
       <div class="add_meta bloc" id="bloc_taille">
            <h3 class="bloc_titre">Taille</h3>
            <div class="inside bloc_contenu">
                <p>
                    <?php echo $this->Form->input('terms_product_taille',array('label'=>false,'type'=>'select','multiple'=>'checkbox','options'=>$terms_product_taille)); ?>
                <p>
            </div>
        </div>
        <div class="add_meta bloc" id="bloc_createur">
            <h3 class="bloc_titre">Créateur</h3>
            <div class="inside bloc_contenu">
                <p>
                    <?php echo $this->Form->input('terms_product_creator',array('label'=>false,'type'=>'select','options'=>$terms_product_creator)); ?>
                <p>
            </div>
        </div>   
    <?php endif ?>
</div>
<?php echo $this->Form->end() ?>

<div id="form_upload">
    <?php echo $this->Form->create('Product',array('action'=>'addattachment','type'=>'file')) ?>   
        <?php echo $this->Form->input('attachment_name',array('label'=>"Nom du fichier",'div'=>array('class'=>'placeholder'))); ?>
        <?php echo $this->Form->input('attachment_file',array('label'=>false,'type'=>'file')); ?>
        <?php echo $this->Form->input('attachment_product_id',array('label'=>false,'type'=>'hidden','value'=>$product['Product']['id'])); ?>
        <?php echo $this->Form->input('attachment_product_slug',array('label'=>false,'type'=>'hidden','value'=>$product['Product']['slug'])); ?>
    <?php echo $this->Form->end('Envoyer') ?>        
</div>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
$('#show_form_attachment').click(function(){
    $('#form_upload').dialog({
        modal: true,
        resizable: false,
        width: 400,
        position: "center",
        title : "Ajouter une image"
    });
    return false; 
});
<?php echo $this->Html->scriptend() ?>
<?php echo $this->Html->script('tiny_mce/tiny_mce.js',array('inline'=>false)); ?>
<?php $this->Html->scriptStart(array('inline'=>false)); ?>
    tinyMCE.init({
        mode                    :   'textareas',
        language : "fr",
        theme                   :   'advanced',
        plugins                 :   'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,inlinepopups,paste,image,lien',
        theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_statusbar_location : 'bottom',
        theme_advanced_resizing: false,
        paste_remove_styles: true,
        paste_remove_spans: true,
        paste_strip_class_attributes: 'all',
        image_explorer: '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'tinymce')); ?>',
        image_edit: '<?php echo $this->Html->url(array('controller'=>'medias','action'=>'tinymce','url')); ?>',
        lien_explorer: '<?php echo $this->Html->url(array('controller'=>'posts','action'=>'tinymce')) ?>',
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