<?php echo $this->Html->script('tiny_mce/tiny_mce_popup.js') ?>
<script type="text/javascript">
	// on récupère la fenêtre parente
	var win = window.dialogArguments || opener || parent || top;
	win.send_to_editor('<a href="<?php echo $src ?>" title="<?php echo $title ?>"><?php echo $content ?></a>');
	// on ferme la popup
	tinyMCEPopup.close();
</script>

