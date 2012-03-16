<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="fr"><![endif]-->
<!--[if lte IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if gt IE 9]><!--><html lang="fr"><!--<![endif]-->

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <title><?php echo $title_for_layout; ?></title>
        <?php //echo $this->Html->css('style.css'); ?>
        <?php echo $this->Html->css('test_style.css') ?>
        <style type="text/css">
#content .notif{
  position: relative;
  padding: 15px 15px;
  margin-bottom: 18px;
  color: #404040;
  background-color: #eedc94;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#fceec1), to(#eedc94));
  background-image: -moz-linear-gradient(top, #fceec1, #eedc94);
  background-image: -ms-linear-gradient(top, #fceec1, #eedc94);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fceec1), color-stop(100%, #eedc94));
  background-image: -webkit-linear-gradient(top, #fceec1, #eedc94);
  background-image: -o-linear-gradient(top, #fceec1, #eedc94);
  background-image: linear-gradient(top, #fceec1, #eedc94);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fceec1', endColorstr='#eedc94', GradientType=0);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #eedc94 #eedc94 #e4c652;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
  border-width: 1px;
  border-style: solid;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25);
}
#content .content .notif{
    margin-bottom: 10px;
}
#content .notif .close{
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    float: right;
    color: #000000;
    font-size: 20px;
    font-weight: bold;
    line-height: 13.5px;
    text-shadow: 0 1px 0 #ffffff;
    filter: alpha(opacity=20);
    -khtml-opacity: 0.2;
    -moz-opacity: 0.2;
    opacity: 0.2;
    text-decoration: none;
}
#content .notif .close:hover {
  color: #000000;
  text-decoration: none;
  filter: alpha(opacity=40);
  -khtml-opacity: 0.4;
  -moz-opacity: 0.4;
  opacity: 0.4;
}
#content .notif strong{
    font-weight: bold;
    color:inherit;
}
#content .notif.success{
  background-color: #57a957;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#62c462), to(#57a957));
  background-image: -moz-linear-gradient(top, #62c462, #57a957);
  background-image: -ms-linear-gradient(top, #62c462, #57a957);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #62c462), color-stop(100%, #57a957));
  background-image: -webkit-linear-gradient(top, #62c462, #57a957);
  background-image: -o-linear-gradient(top, #62c462, #57a957);
  background-image: linear-gradient(top, #62c462, #57a957);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#62c462', endColorstr='#57a957', GradientType=0);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #57a957 #57a957 #3d773d;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  color:#FFF;
}
#content .notif.error,#content .bloc .notif.error{
  background-color: #c43c35;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#ee5f5b), to(#c43c35));
  background-image: -moz-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -ms-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ee5f5b), color-stop(100%, #c43c35));
  background-image: -webkit-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: -o-linear-gradient(top, #ee5f5b, #c43c35);
  background-image: linear-gradient(top, #ee5f5b, #c43c35);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ee5f5b', endColorstr='#c43c35', GradientType=0);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #c43c35 #c43c35 #882a25;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  color: #FFF!important;
}
#content .notif.info{
  background-color: #339bb9;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#5bc0de), to(#339bb9));
  background-image: -moz-linear-gradient(top, #5bc0de, #339bb9);
  background-image: -ms-linear-gradient(top, #5bc0de, #339bb9);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5bc0de), color-stop(100%, #339bb9));
  background-image: -webkit-linear-gradient(top, #5bc0de, #339bb9);
  background-image: -o-linear-gradient(top, #5bc0de, #339bb9);
  background-image: linear-gradient(top, #5bc0de, #339bb9);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5bc0de', endColorstr='#339bb9', GradientType=0);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #339bb9 #339bb9 #22697d;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  color:#FFF;
}
#content .bloc .error, #content .bloc .error label, #content .bloc .error input, #content .error-message, #content .error textarea{
    color: #9D261D !important;
    border-color: #C87872 !important;
}
        </style>
               <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]--> 
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
                <div id="header-site">
                    <h1 id="site-title">
                    <span>
                        <?php echo $this->Html->link(Configure::read('site_name'),'/',array('title'=>Configure::read('site_name'))) ?>
                    </span>
                    </h1>
                    <div id="site-description">Un super site fait avec un Super CMS</div>
                    <?php echo $this->Html->image('http://demo.wordpress-fr.net/wp-content/themes/twentyeleven/images/headers/willow.jpg',array('height'=>198,'width'=>940)) ?>
                </div>
                <div id="header-navigation" role="navigation">
                    <?php echo $this->element('menu',array(),array('plugin'=>null)); ?>   
                </div>
            </div>
            <div id="main">
                <div id="container">
                    <div id="content" role="main">
                        <?php echo $this->Session->flash() ?>
                        <?php echo $content_for_layout;?>
                    </div>
                </div>
            </div>
            <div id="footer" role="contentinfo">
                <div id="colophon">
                    <div id="site-info">
                        <?php echo $this->Html->link(Configure::read('site_name'),'/',array('title'=>Configure::read('site_name'))) ?>
                    </div>
                    <div id="site-generator">
                        <?php echo $this->Html->link("Générer par un cms qui déchire",array('action'=>'','controller'=>'')); ?>
                    </div><!-- #site-generator -->
                </div><!-- #colophon -->
            </div>
        </div>
    </body>
    <?php echo $this->element('sql_dump'); ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php echo $scripts_for_layout; ?>
</html>

