<h2>Vous avez aimé notre site et vous souhaitez nous laisser un petit message</h2>

<?php echo $this->Form->create('Guestbook') ?>
<?php echo $this->Form->input('Guestbook.author',array('label'=>"Votre nom", 'div'=>array('class'=>'placeholder'))); ?>
<?php echo $this->Form->input('Guestbook.author_email',array('label'=>"Votre email", 'div'=>array('class'=>'placeholder'))); ?>
<?php echo $this->Form->input('Guestbook.author_url',array('label'=>"Site Web", 'div'=>array('class'=>'placeholder'))); ?>
<?php echo $this->Form->input('Guestbook.content',array('label'=>"Votre message", 'div'=>array('class'=>'placeholder'))); ?>
<?php echo $this->Form->input('Guestbook.site',array('div'=>false,'label'=>false,'class'=>'mariee')); ?>
<?php echo $this->Form->end('Ajouter un message') ?>
<?php if (!empty($guestbooks)): ?>
<div class="cb"></div>

<div id="guestbook">
	<?php $terminaison = $totalComments > 1 ? 's' : '' ?>
	<p><?php echo $totalComments ?> Commentaire<?php echo $terminaison ?></p>
	<?php foreach ($guestbooks as $k => $v): ?>
		<div class="comment">
			<div class="comment-title">
				<span class="comment-date">Le <?php echo $this->date->format($v['Guestbook']['created'],'FRS',true)?></span>
				<span class="comment-author"> par
					<?php if (!empty($v['Guestbook']['author_url'])): ?>
						<?php echo $this->Html->link($v['Guestbook']['author'],'http://'.$v['Guestbook']['author_url'],array('target'=>'blank')); ?>  	
					<?php else: ?>
						<?php echo $v['Guestbook']['author'] ?>
					<?php endif ?>  
				</span>
				<?php if ($this->Session->read('Auth.User.role') == 'admin' || $this->Session->read('Auth.User.role') == 'superadmin'): ?>
					<div class="action">
						<?php if ($v['Guestbook']['approved'] == 0): ?>
							<?php echo $this->Html->link($this->Html->image('test-pass-icon.png'),array('admin'=>true,'plugin'=>'guestbook','action'=>'valid','controller'=>'guestbooks','?'=>array('id'=>$v['Guestbook']['id'],'token'=>$this->Session->read('Security.token'))),array('escape'=>false,'title'=>'Valider le commentaire')); ?>
						<?php endif ?>
						<?php echo $this->Html->link($this->Html->image('test-error-icon.png'),array('admin'=>true,'plugin'=>'guestbook','action'=>'delete','controller'=>'guestbooks','?'=>array('id'=>$v['Guestbook']['id'],'token'=>$this->Session->read('Security.token'))),array('escape'=>false,'title'=>'Supprimer le commentaire')); ?>
					</div>
				<?php endif ?>	
			</div>
			<div class="comment-content">
				<?php echo nl2br($v['Guestbook']['content']); ?>
			</div>
		</div>
	<?php endforeach ?>
</div>
<?php endif ?>

<section id="bandeau"> <!-- Début bandeau (bas du content) -->
	<ul>
		<li class="titre">Aux Mariées de Christèle</li>
		<li>15a, rte de Faillant</li>
		<li>17380 Les Nouillers</li>
		<li>Tél. 06 20 98 53 87</li>
	</ul>
	<?php echo $this->Html->image('etiquette.png',array('width'=>197,'height'=>86,'alt'=>"Étiquette fabrication 100% française")) ?>
	<ul class="horaires">
		<li class="titre">Horaires</li>
		<li>Mardi au vendredi: 14h à19h</li>
		<li>Samedi et lundi: sur rendez-vous</li>
		<li>Dimanche fermé</li>
	</ul>
</section> <!-- Fin bandeau -->