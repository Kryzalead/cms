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
        <style type="text/css">
            #blocsAjoutCote .add_meta .checkbox label {margin-left: 5px;}
            #blocsAjoutCote .add_meta .checkbox {height: 20px;line-height: 20px;}
            #blocsAjoutCote #bloc_createur select{width: 200px;padding: 2px}
            .blocsCentral #produit_images .liste_produits_image li{display: inline-block;position: relative;}
            .blocsCentral #produit_images .liste_produits_image li .del_thumb{color: red;position: absolute;top: 0;right:0;text-decoration: none}

            #form_upload{display: none}
            #form_upload label{position: absolute;margin-top: 10px;height: 20px;line-height: 22px;margin-left: 5px}
            #form_upload input{height: 20px}
            #form_upload input{margin-top: 10px}

            #bloc_image_une .product_thumb{text-align: center}

            #form_term label{display: inline-block;width: 60px}
            #form_term input{margin-top: 10px}
            #form_term p{margin-top: 5px}
            
            #content #dashboard_derniers_commentaires .bloc_contenu{padding: 0px}
            #derniers_commentaires .item_commentaire{padding: 5px}
            #derniers_commentaires .non_approuve{background-color: lightYellow}

            #form_user{margin-top: 10px}
            #form_user label{display: inline-block;width: 150px}
            #form_user input{margin-top: 5px}
            #form_user #pass_strength_result{margin-left: 150px;margin-top: 5px;margin-bottom: 5px}

            .options_form{padding: 5px}
            .options_form label{display: inline-block;width: 150px}
            .options_form .input{margin-top: 5px;}
            .options_form .input input{margin-right: 10px;width: 200px;padding: 2px}
            .options_form input[type="submit"]{margin-top: 10px}

            #content .button-add{
                border: 1px solid #BBB;
                color: #464646;
                text-decoration: none;
                font-size: 12px!important;
                line-height: 13px;
                padding: 5px 10px;
                cursor: pointer;
                border-width: 1px;
                border-style: solid;
                -webkit-border-radius: 11px;
                border-radius: 11px;
                -moz-box-sizing: content-box;
                -webkit-box-sizing: content-box;
                box-sizing: content-box;
                display: block;
                width: 100px;
                text-align: center;
                margin-top: 10px
            }
            #content .button-add:hover{color:#000;border-color:#666;text-decoration: none}
            #content input[type="submit"]:hover{color:#000;border-color:#666;}
            #content .list_top_table {margin-top: 20px}

            .liste_table .colonne_medias .thumb{display: inline-block;margin-right: 5px}
            .liste_table .colonne_medias .thumb_meta{display: inline-block;vertical-align: top}
            .liste_table .colonne_medias .thumb_meta a{display: block}

            #form_media{margin-top: 20px}
            #form_media label{display: inline-block;width: 100px}
            #form_media .input{margin-top: 10px}
            #form_media input[type="file"]{margin-left: 100px}
            #form_media input[type="submit"]{margin-left: 100px;margin-top: 10px}
            #form_media p{margin-top: 10px}
            #form_media input#MediaGuid{width: 350px}
            #media_thumb{display: inline-block}
            #media_data{display: inline-block;vertical-align: top}
        </style>
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
                    <div class="cb"></div>
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