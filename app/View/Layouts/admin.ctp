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
        #content .liste_table tr:hover{background-color: #fff}
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

        /* Notification */
        #content .notif{font-size: 20px;text-align: center;position:fixed;top:-21px;left:0;right:0;z-index:10000;padding: 20px 15px;margin-bottom: 18px;color: #404040;background-color: #eedc94;background-repeat: repeat-x;background-image: -khtml-gradient(linear, left top, left bottom, from(#fceec1), to(#eedc94));background-image: -moz-linear-gradient(top, #fceec1, #eedc94);background-image: -ms-linear-gradient(top, #fceec1, #eedc94);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fceec1), color-stop(100%, #eedc94));background-image: -webkit-linear-gradient(top, #fceec1, #eedc94);background-image: -o-linear-gradient(top, #fceec1, #eedc94);background-image: linear-gradient(top, #fceec1, #eedc94);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fceec1', endColorstr='#eedc94', GradientType=0);text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);border-color: #eedc94 #eedc94 #e4c652;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);border-width: 1px;border-style: solid;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);}
        #content .content .notif{margin-bottom: 10px;}
        #content .notif strong{font-weight: bold;color:inherit;}
        #content .notif.success{background-color: #57a957;background-repeat: repeat-x;background-image: -khtml-gradient(linear, left top, left bottom, from(#62c462), to(#57a957));background-image: -moz-linear-gradient(top, #62c462, #57a957);background-image: -ms-linear-gradient(top, #62c462, #57a957);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #62c462), color-stop(100%, #57a957));background-image: -webkit-linear-gradient(top, #62c462, #57a957);background-image: -o-linear-gradient(top, #62c462, #57a957);background-image: linear-gradient(top, #62c462, #57a957);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#62c462', endColorstr='#57a957', GradientType=0);text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);border-color: #57a957 #57a957 #3d773d;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);color:#FFF;}
        #content .notif.error,#content .bloc .notif.error{background-color: #c43c35;background-repeat: repeat-x;background-image: -khtml-gradient(linear, left top, left bottom, from(#ee5f5b), to(#c43c35));background-image: -moz-linear-gradient(top, #ee5f5b, #c43c35);background-image: -ms-linear-gradient(top, #ee5f5b, #c43c35);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ee5f5b), color-stop(100%, #c43c35));background-image: -webkit-linear-gradient(top, #ee5f5b, #c43c35);background-image: -o-linear-gradient(top, #ee5f5b, #c43c35);background-image: linear-gradient(top, #ee5f5b, #c43c35);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ee5f5b', endColorstr='#c43c35', GradientType=0);text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);border-color: #c43c35 #c43c35 #882a25;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);color: #FFF!important;}
        #content .notif.info{background-color: #339bb9;background-repeat: repeat-x;background-image: -khtml-gradient(linear, left top, left bottom, from(#5bc0de), to(#339bb9));background-image: -moz-linear-gradient(top, #5bc0de, #339bb9);background-image: -ms-linear-gradient(top, #5bc0de, #339bb9);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5bc0de), color-stop(100%, #339bb9));background-image: -webkit-linear-gradient(top, #5bc0de, #339bb9);background-image: -o-linear-gradient(top, #5bc0de, #339bb9);background-image: linear-gradient(top, #5bc0de, #339bb9);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5bc0de', endColorstr='#339bb9', GradientType=0);text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);border-color: #339bb9 #339bb9 #22697d;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);color:#FFF;}

            #content .error, #content .error label, #content .error input, #content .error-message, #content .error textarea{
                color: #9D261D !important;
                border-color: #C87872 !important;
            }
            #content .error input, #content .error textarea{
                background-color: #FAE5E3 !important;
            }
            #content .error-message{
                display: block;
            }
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