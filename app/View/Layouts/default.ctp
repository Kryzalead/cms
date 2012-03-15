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

