<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css('test_style.css') ?>
    </head>
    <body class="login">
        <div id="login">
            <?php echo $this->Session->flash() ?>
            <?php echo $content_for_layout;?>
        </div>      
    </body>
</html>

