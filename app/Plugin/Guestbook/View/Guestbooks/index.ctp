<h1>Laisser nous un petit message</h1>
<?php if (!empty($guestbooks)): ?>
<div id="guestbook">
	<?php $terminaison = $totalComments > 1 ? 's' : '' ?>
		<p><?php echo $totalComments ?> Commentaire<?php echo $terminaison ?></p>
	<?php $i = 0 ?>
	<?php foreach ($guestbooks as $k => $v): ?>
		<?php $class = ($i%2 == 0) ? 'paire' : 'nopaire' ?>
		<?php $i++; ?>
		<div class="comment <?php echo $class ?>" id="comment-<?php echo $v['Guestbook']['id'];?>">
			<div class="comment-title">
					<?php 
						$date = $this->date->format($v['Guestbook']['created'],'special_jd',true); 
						$num_jour = $date['num_jour'];$mois = $date['mois'];$annee = $date['annee'];$heure = $date['heure'];$minute = $date['min'];
					?>
					<div class="date">
						<span class="jour"><?php echo $num_jour ?></span>
						<span class="mois"><?php echo $mois ?></span>
						<span class="annee"><?php echo $annee ?></span>
						<span class="heure"><?php echo $heure ?>:<?php echo $minute ?></span>
					</div>
				<div class="comment_content">
					<?php if ($this->Session->read('Auth.User.role') == 'admin' || $this->Session->read('Auth.User.role') == 'superadmin'): ?>
						<div class="action">
							<?php if ($v['Guestbook']['approved'] == 0): ?>
								<?php echo $this->Html->link($this->Html->image('test-pass-icon.png'),array('admin'=>true,'plugin'=>'guestbook','action'=>'valid','controller'=>'guestbooks','?'=>array('id'=>$v['Guestbook']['id'],'token'=>$this->Session->read('Security.token'))),array('escape'=>false,'title'=>'Valider le commentaire')); ?>
							<?php endif ?>
							<?php echo $this->Html->link($this->Html->image('test-error-icon.png'),array('admin'=>true,'plugin'=>'guestbook','action'=>'delete','controller'=>'guestbooks','?'=>array('id'=>$v['Guestbook']['id'],'token'=>$this->Session->read('Security.token'))),array('escape'=>false,'title'=>'Supprimer le commentaire')); ?>
						</div>
					<?php endif ?>
					<span class="comment-content"><?php echo nl2br($v['Guestbook']['content']); ?></span>
					<span class="comment-author">
						<cite>
							<?php if (!empty($v['Guestbook']['author_url'])): ?>
								<?php echo $this->Html->link($v['Guestbook']['author'],'http://'.$v['Guestbook']['author_url'],array('target'=>'blank')); ?>
							<?php else: ?>
								<?php echo $v['Guestbook']['author'] ?>
							<?php endif ?>
						</cite>
					</span>
				</div>
			</div>
		</div>
	<?php endforeach ?>
</div>
<?php endif ?>
<div class="cb"></div>

<div id="add_commentaire">
	<?php $class = ($show_form == 'ok') ? 'active' : ''?>
	<h1>
		<img src="img/comment.png" width="142" height="128" alt="bulles_commentaires"/>
		<?php echo $this->Html->link("Ajouter un commentaire",'#',array('id'=>'show_form_comment','class'=>$class)); ?>
	</h1>
	
	<div id="guestbook_add" <?php echo $class ?>>
		<div id="guestbook_form">
			<?php echo $this->Form->create('Guestbook') ?>
			<?php echo $this->Form->input('Guestbook.author',array('label'=>"Votre nom", 'div'=>array('class'=>'placeholder'))); ?>
			<?php echo $this->Form->input('Guestbook.author_email',array('label'=>"Votre email", 'div'=>array('class'=>'placeholder'))); ?>
			<?php echo $this->Form->input('Guestbook.author_url',array('label'=>"Site web", 'div'=>array('class'=>'placeholder'))); ?>
			<?php echo $this->Form->input('Guestbook.content',array('label'=>"Votre message", 'div'=>array('class'=>'placeholder'))); ?>
			<?php echo $this->Form->input('Guestbook.site',array('div'=>false,'label'=>false,'class'=>'mariee')); ?>
			<?php echo $this->Form->end(array('label'=>'','div'=>array('class'=>'add_comment'))) ?>
		</div>
		<div id="guestbook_image">
			<?php echo $this->Html->image('livre-dor.jpg', array('width'=>'480', 'height'=>'229')) ?>
		</div>
	</div>
</div>