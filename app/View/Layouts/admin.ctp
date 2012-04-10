<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="fr"><![endif]-->
<!--[if lte IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if gt IE 9]><!--><html lang="fr"><!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title_for_layout; ?></title>
        <?php // echo $this->Html->css('graf.css'); ?>
        <?php echo $this->Html->css('ok.css') ?>
        <?php echo $this->Html->css('start/jquery-ui.css') ?>
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
        <style type="text/css">
        #content input[type="submit"]{border: 1px solid #BBB;color: #464646;text-decoration: none;font-size: 12px!important;line-height: 13px;padding: 3px 8px;cursor: pointer;border-width: 1px;border-style: solid;-webkit-border-radius: 11px;border-radius: 11px;-moz-box-sizing: content-box;-webkit-box-sizing: content-box;box-sizing: content-box;}

        #content .liste_table {color: #333;margin-top: 5px;border: 1px solid #DFDFDF;background-color: #F9F9F9;}
        #content .liste_table th,#content .liste_table td{border-top:1px solid white;border-bottom: 1px solid #DFDFDF;text-align: left;padding: 4px 7px 2px;vertical-align: top;}
        #content .liste_table th{background-color: #F1F1F1;font-size: 14px;height: 36px;line-height: 36px}
        #content .liste_table th a{color: #21759B;text-decoration: none}
        #content .liste_table th a:hover {color: #464646;}

        #content .liste_table .colonne_check{width: 30px;text-align: center}
        
        #content .liste_table td {font-size: 12px;padding: 4px 7px 2px;vertical-align: top;}
        #content .liste_table td a:hover {color: #D74E21;}
        #content .liste_table .action_admin {text-align: left;visibility: hidden;margin-top: 10px;}
        #content .liste_table .action_admin a {font-size: 0.9em;}
        #content .liste_table .action_admin a.upd {color: #257EA8;}
        #content .liste_table .action_admin a.upd:hover {color: #D74E21;}
        #content .liste_table .action_admin a.del {color: #BC0B0B;}
        #content .liste_table .action_admin a.del:hover {color: #FF0000;}
        #content .liste_table tr:hover .action_admin {visibility: visible;}

        #content .action_groupees{margin-top: 10px}
        #content .action_groupees div{display: inline-block}
        #content .action_groupees select{padding: 2px;height: 2em}
       
        #content .search_box{float: right}
        #content .search_box .submit{display: inline-block}

        #content .list_top_table {margin-top: 5px}
        #content .list_top_table li{display: inline-block;}
        #content .list_top_table li a:hover{color: #ff4b33}
        #content .list_top_table .current{color: #000;font-weight : bold;}

        #content .bloc_total_element{float: right;cursor: default;height: 30px;line-height: 30px;font-size: 12px;font-style: italic;margin-right: 10px;color:#555}

        #content .comment-post span {background-color: #BBB;display: inline-block;text-align: center;border-radius: 5px;color: #fff;font-weight: bold;cursor: pointer}
        #content .comment-post span.comment-waiting{background-color: #21759B}
        #content .comment-post span:hover{background-color: #D74E21}
        #content .comment-post span a{text-decoration: none;color: #fff;display: block;padding: 0 6px;height: 1.4em;line-height:1.4em;}
        #content .comment-post span a:hover{color: #fff}

        #content .liste_table
        #content .liste_table .colonne_medias .thumb{float: left}
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