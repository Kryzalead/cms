<div class="notif bloc <?php echo isset($type) ? $type : 'success' ?>" style="margin-top: 50px;margin-left: 50px">
	<p><strong><?php echo isset($type) ? ucfirst($type) : 'Success' ?> : </strong><?php echo $message ?></p>
	<a href="#" class="close">x</a>
</div>