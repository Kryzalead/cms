<div class="notif bloc <?php echo isset($typeMessage) ? $typeMessage : 'success' ?>" style="margin-top: 50px;margin-left: 50px">
	<p><strong><?php echo isset($typeMessage) ? ucfirst($typeMessage) : 'Success' ?> : </strong><?php echo $message ?></p>
	<a href="#" class="close">x</a>
</div>