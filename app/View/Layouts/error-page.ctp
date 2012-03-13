<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css('graf.css'); ?>
        <?php echo $this->Html->css('admin.css') ?>
        <style type="text/css">
        body {height: auto;background: white;color: #333;font-family: sans-serif;margin: 2em auto;padding: 1em 2em;-webkit-border-radius: 3px;border-radius: 3px;border: 1px solid #DFDFDF;max-width: 700px;color: #333;}
        #error-page {margin-top: 50px;}
        #error-page p {font-size: 14px;line-height: 1.5;margin: 25px 0 20px;}
        </style>
    </head>
    <body id="error-page">
        <?php echo $this->Session->flash() ?>
        <?php echo $content_for_layout ?>
    </body>
</html>

