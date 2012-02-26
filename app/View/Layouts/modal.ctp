<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css('style.css'); ?>
        <?php echo $this->Html->css('ui-lightness/jquery-ui.css') ?>
    </head>
    <body>
        <div class="container"  style="margin-top: 50px">
            <?php echo $this->Session->flash() ?>
            <?php echo $content_for_layout;?>
        </div>
    </body>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
    <?php echo $scripts_for_layout; ?>
</html>

