<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="fr"><![endif]-->
<!--[if lte IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if gt IE 9]><!--><html lang="fr"><!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Coder In" />
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css('ok.css') ?>
        <?php echo $this->Html->css('start/jquery-ui.css') ?>
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    </head>
    <body>
        <!-- config button -->
        <div class="settings" id="settings">
            <div class="wrapper">
                <div class="grid3">
                    <div class="titre">Fonds</div>
                        <a href="url(<?php echo Router::url('/css/images/setting_button/bg/blanc.gif') ?>)" class="backgroundChanger active" title="Blanc"></a>
                        <a href="url(<?php echo Router::url('/css/images/setting_button/bg/bleu.gif') ?>)" class="backgroundChanger" title="Bleu"></a>
                        <a href="url(<?php echo Router::url('/css/images/setting_button/bg/rose.gif') ?>)" class="backgroundChanger dark" title="Rose"></a>
                        <a href="url(<?php echo Router::url('/css/images/setting_button/bg/vert.gif') ?>)" class="backgroundChanger dark" title="Vert"></a>
                        <a href="url(<?php echo Router::url('/css/images/setting_button/bg/carbon.gif') ?>)" class="backgroundChanger dark" title="Carbon"></a>
                        <a href="url(<?php echo Router::url('/css/images/setting_button/bg/dark-bg.png') ?>)" class="backgroundChanger dark" title="Noir"></a>
                    <div class="clear"></div>
                </div>
                <div class="grid3">
                    <div class="titre">Style des blocs</div>
                        <a href="white" class="blocChanger active" title="Blanc" style="background:url(<?php echo Router::url('/css/images/setting_button/blocs_titles/white-title.png') ?>)"></a>
                        <a href="black" class="blocChanger" title="Noir" style="background:url(<?php echo Router::url('/css/images/setting_button/blocs_titles/bloctitle.png') ?>)"></a>
                    <div class="clear"></div>
                </div>
                <div class="grid3">
                    <div class="titre">Style du menu</div>
                    <a href="grey" class="sidebarChanger" title="Gris" style="background:#494949"></a>
                    <a href="black" class="sidebarChanger" title="Noir" style="background:#262626"></a>
                    <a href="white" class="sidebarChanger active" title="Blanc" style="background:#EEE"></a>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
                <a class="settingbutton" href="#"></a>
        </div>
        <div id="head">
            <?php echo $this->element('admin-top-barre') ?>
        </div>
        <?php echo $this->element('admin-menu'); ?>
        <div id="content" class="white">
            <?php echo $this->Session->flash() ?>
            <?php echo $content_for_layout ?>
        </div>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
			<?php echo $this->Html->script('main'); ?>
			<?php echo $this->Html->script('cookie/jquery.cookie') ?>
			<?php echo $scripts_for_layout; ?>
    </body>
</html>