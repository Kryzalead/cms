<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="fr"><![endif]-->
<!--[if lte IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if gt IE 9]><!--><html lang="fr"><!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css('graf.css'); ?>
        <?php echo $this->Html->css('admin.css') ?>
        <?php echo $this->Html->css('start/jquery-ui.css') ?>
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 

    </head>
    <body>

    <!-- config button -->
    <div class="settings" id="settings">
        <div class="wrapper">
            <div class="grid3">
                <div class="titre">Fonds</div>
                    <a href="url(<?php echo Router::url('/css/images/setting_button/bg/eau.jpg') ?>)" class="backgroundChanger active" title="Eau"></a>
                    <a href="url(<?php echo Router::url('/css/images/setting_button/bg/taches_peinture.jpg') ?>)" class="backgroundChanger dark" title="Taches peinture"></a>
                    <a href="url(<?php echo Router::url('/css/images/setting_button/bg/gouttelettes.jpg') ?>)" class="backgroundChanger dark" title="Gouttelettes"></a>
                    <a href="url(<?php echo Router::url('/css/images/setting_button/bg/dark-bg.png') ?>)" class="backgroundChanger dark" title="Noir"></a>
                    <a href="url(<?php echo Router::url('/css/images/setting_button/bg/bg.png') ?>)" class="backgroundChanger dark" title="Cadrillage"></a>
                    <a href="url(<?php echo Router::url('/css/images/setting_button/bg/carbon.gif') ?>)" class="backgroundChanger dark" title="Carbon"></a>
                <div class="clear"></div>
            </div>
            <div class="grid3">
                <div class="titre">Style des blocs</div>
                    <a href="black" class="blocChanger active" title="Noir" style="background:url(<?php echo Router::url('/css/images/setting_button/blocs_titles/bloctitle.png') ?>)"></a>
                    <a href="white" class="blocChanger" title="Blanc" style="background:url(<?php echo Router::url('/css/images/setting_button/blocs_titles/white-title.png') ?>)"></a>
                <div class="clear"></div>
            </div>
            <div class="grid3">
                <div class="titre">Style du menu</div>
                <a href="grey" class="sidebarChanger active" title="Gris" style="background:#494949"></a>
                <a href="black" class="sidebarChanger" title="Noir" style="background:#262626"></a>
                <a href="white" class="sidebarChanger" title="Blanc" style="background:#EEE"></a>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
            <a class="settingbutton" href="#"></a>
    </div>

        <div id="head">
            <div class="left">
                <?php
                    $gravatar = md5( strtolower( trim($this->Session->read('Auth.User.email'))));
                    echo $this->Html->image('http://www.gravatar.com/avatar/'.$gravatar.'?s=20', array('class'=>"gravatar")); ?>
                <span>Bonjour,</span>
                <?php echo $this->Html->link($this->Session->read('Auth.User.username'),array('action'=>'edit','controller'=>'users',$this->Session->read('Auth.User.id'))); ?>
                <span>|</span>
                <?php echo $this->Html->link('Voir mon site','/',array('target'=>'_blank')) ?>
                <span>|</span>
                <?php echo $this->Html->link('Se déconnecter',array('controller'=>'users','action'=>'logout','admin'=>false))?>
            </div>
            <div class="right">
                <form action="#" id="search" class="search placeholder">
                    <label>Vous recherchez un truc ?</label>
                    <input type="text" value="" name="q" class="text">
                    <input type="submit" value="rechercher" class="submit">
                </form>
            </div>
        </div>
        <div id="sidebar" class="white">
            <ul>
                <li class="nosubmenu <?php echo ($currentController == 'dashboard')  ? 'current' : '' ?>">
                    <?php echo $this->Html->link($this->Html->image('icone-home.png',array('height'=>25,'width'=>25)) . 'Tableau de bord',array('action'=>'index','controller'=>'dashboard'),array('escape'=>false)); ?>
                </li>
                <li <?php echo ($currentController == 'pages')  ? 'class="current"' : '' ?>>
                    <?php echo $this->Html->link($this->Html->image('icone-pages.png',array('height'=>25,'width'=>25)) . 'Pages',array('action'=>'index','controller'=>'pages'),array('escape'=>false)); ?>
                    <ul>
                        <li><?php echo $this->Html->link("Toutes les pages",array('action'=>'index','controller'=>'pages')); ?></li>
                        <li><?php echo $this->Html->link("Ajouter",array('action'=>'edit','controller'=>'pages')); ?></li>
                    </ul>
                </li>
                <li <?php echo ($currentController == 'posts')  ? 'class="current"' : '' ?>>
                    <?php echo $this->Html->link($this->Html->image('icone-posts.png',array('height'=>25,'width'=>25)) . 'Articles',array('action'=>'index','controller'=>'posts'),array('escape'=>false)); ?>
                    <ul>
                        <li><?php echo $this->Html->link("Tous les articles",array('action'=>'index','controller'=>'posts')); ?></li>
                        <li><?php echo $this->Html->link("Ajouter",array('action'=>'edit','controller'=>'posts')); ?></li>
                        <li><?php echo $this->Html->link("Catégories",array('plugin'=>'Taxonomy','controller'=>'terms','action'=>'edit','admin'=>true)); ?></li>
                    </ul>
                </li>
                <li <?php echo ($currentController == 'medias')  ? 'class="current"' : '' ?>>
                    <?php echo $this->Html->link($this->Html->image('icone-medias.png',array('height'=>25,'width'=>25)) . 'Medias',array('action'=>'index','controller'=>'medias'),array('escape'=>false)); ?>
                    <ul>
                        <li><?php echo $this->Html->link("Bibliothèque",array('action'=>'index','controller'=>'medias')); ?></li>
                        <li><?php echo $this->Html->link("Ajouter",array('action'=>'edit','controller'=>'medias')); ?></li>
                    </ul>
                </li>
                <li class="nosubmenu <?php echo ($currentController == 'comments')  ? 'current' : '' ?>">
                    <?php echo $this->Html->link($this->Html->image('icone-comments.png',array('height'=>25,'width'=>25)) . 'Commentaires',array('action'=>'index','controller'=>'comments'),array('escape'=>false)); ?>
                </li>
            </ul>
            <ul>
                <li class="nosubmenu <?php echo ($currentController == 'menus')  ? 'current' : '' ?>">
                    <?php echo $this->Html->link($this->Html->image('icone-menus.png',array('height'=>25,'width'=>25)) . 'Menus',array('action'=>'index','controller'=>'menus'),array('escape'=>false)); ?>
                </li>
                <li <?php echo ($currentController == 'users')  ? 'class="current"' : '' ?>>
                    <?php echo $this->Html->link($this->Html->image('icone-users.png',array('height'=>25,'width'=>25)) . 'Utilisateurs',array('action'=>'index','controller'=>'users'),array('escape'=>false)); ?>
                    <ul>
                        <li><?php echo $this->Html->link("Tous les utilisateurs",array('action'=>'index','controller'=>'users')); ?></li>
                        <li><?php echo $this->Html->link("Ajouter",array('action'=>'edit','controller'=>'users')); ?></li>
                        <li><?php echo $this->Html->link("Votre profil",array('action'=>'edit','controller'=>'users',$this->Session->read('Auth.User.id'))); ?></li>
                    </ul>
                </li>
                <li class="nosubmenu <?php echo ($currentController == 'options')  ? 'current' : '' ?>">
                    <?php echo $this->Html->link($this->Html->image('icone-config.png',array('height'=>25,'width'=>25)) . 'Réglage',array('action'=>'index','controller'=>'options'),array('escape'=>false)); ?>
                </li>
            </ul>
            <a href="#collapse" id="menucollapse">◀ Réduire le menu</a>
        </div>
        <div id="content">
            <?php echo $this->Session->flash() ?>
            <?php echo $content_for_layout ?>
        </div>
    </body>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
    <?php echo $this->Html->script('main'); ?>
    <?php echo $this->Html->script('cookie/jquery.cookie') ?>
    <?php echo $scripts_for_layout; ?>
</html>
<?php echo $this->element('sql_dump'); ?>
