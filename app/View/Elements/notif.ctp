<div class="notif bloc <?php echo isset($typeMessage) ? $typeMessage : 'success' ?>">
	<?php
	if(!empty($typeMessage)){
		if($typeMessage == 'error')
			$texte = 'Erreur';
	}
	 ?>
	<p><strong><?php echo  isset($typeMessage) ? ucfirst($texte) : 'Succès' ?> : </strong><?php echo $message ?></p>
</div>