<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="fr"><![endif]-->
<!--[if lte IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if gt IE 9]><!--><html lang="fr"><!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->css('login.css') ?>
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body>
<!--[if lte IE 8]>
  <div class="alert-ie">
    <p>
        <strong>Attention ! </strong> Votre navigateur (Internet Explorer 6, 7 ou 8) présente de sérieuses lacunes en terme de sécurité et de performances, dues à son obsolescence.<br>
        En conséquence, ce site sera consultable mais de manière moins optimale qu'avec un navigateur récent comme (<a href="http://www.microsoft.com/france/windows/internet-explorer/telecharger-ie9.aspx">Internet Explorer 9</a>, <a href="http://www.mozilla-europe.org/fr/">Firefox 4</a>, <a href="http://www.google.com/chrome?hl=fr">Chrome 10+</a>, <a href="http://www.apple.com/fr/safari/download/">Safari 5</a>)
    </p>
  </div>
<![endif]-->

    <div id="wrapper">
        <div id="content">
                <?php echo $content_for_layout;?>
        </div>
    </div>
</body>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <?php echo $this->Html->script('main'); ?>
</html>

