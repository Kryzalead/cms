<style type="text/css">
	div.radio input{opacity: 1;}
	div.radio label{display: block;}
</style>
<h1>
    <?php echo $this->Html->image('icone-comments.png',array('width'=>72,'height'=>72)); ?>
    <?php echo $title_for_layout ?>
</h1>
<?php echo $this->Form->create('Comment',array('action'=>'edit')) ?>
<div class="blocsCentral">
	<?php echo $this->Form->input('Comment.author',array('label'=>'Auteur : ','style'=>'width:100%')) ?>
	<br />
	<?php echo $this->Form->input('Comment.author_email',array('label'=>'E-mail : ','style'=>'width:100%','after'=>$this->Html->link("(Envoyer l'email)",'mailto:'))) ?>
	<br />
	<?php echo $this->Form->input('Comment.author_url',array('label'=>'Site web : ','style'=>'width:100%')) ?>
	<br />
	<?php echo $this->Form->input('Comment.id'); ?>
	<?php echo $this->Form->input('Comment.content',array('label'=>'Contenu : ','style'=>'width:100%','rows'=>Configure::read('default_post_edit_rows'))) ?>
</div>
<div id="blocsAjoutCote">
    <div class="bloc_publier_image"><!-- Publier -->
      	<p>
        	<?php echo $this->Form->input('Comment.approved',array('legend'=>'<h3>Etat</h3>','type'=>'radio','options'=>$list_etat)); ?>
        <p>
    <?php echo $this->Form->end('Mettre à jour') ?>
    </div>     
</div>
