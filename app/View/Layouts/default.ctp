<!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="fr"><![endif]-->
<!--[if lte IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if IE 9]> <html class="ie9 oldie" lang="fr"><![endif]-->
<!--[if gt IE 9]><!--><html lang="fr"><!--<![endif]-->
 
<head>
  <meta charset="UTF-8">
  <title><?php echo $title_for_layout ?></title>
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <meta name="author" content="Coder In" /> 
  <meta name="description" content="Vente de robes de mariage" />
  <meta name="keywords" content="" />
  <meta name="geo.placename" content="Charente-Maritime, France, 17" />
  <meta name="viewport" content="width=device-width" />
  <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/>
  <?php echo $this->Html->css('styles.css') ?>
  <?php echo $this->Html->css('styles-ie.css') ?>
  <style type="text/css">
    #guestbook_add{display: none}
    #pagination{margin-top: 10px}
    #pagination ul li{display: inline-block;color: blue;margin-left: 10px;border: 1px solid #AA4673;background-color:#D1789F ; width: 20px;height: 20px;text-align: center;line-height: 20px}
    #pagination ul li.current{color: white;text-decoration: underline}

    #contenu .error, #content .error label, #content .error input, #content .error-message, #content .error textarea {color: #9D261D !important;border-color: #C87872 !important;}
    #contenu .error input, #content .error textarea {background-color: #FAE5E3 !important;}
    #contenu .error-message {display: block;}
    /* Notification */

#contenu .notif {
  font-size: 20px;
  text-align: center;
  
  padding: 20px 15px;
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


#contenu .content .notif {
  margin-bottom: 10px;
}


#contenu .notif strong {
  font-weight: bold;
  color: inherit;
}


#contenu .notif.success {
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
  color: #FFF;
}


#contenu .notif.error, #content .bloc .notif.error {
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
/*
  à  tester , je pense que c'est mal, par contre dans le layout ça ne fonctionne pas, à toi de voir da,s la css
*/
aside#image-accessoires{top: 100}
  </style>
</head>
<body>
<!--[if lte IE 8]>
  <link rel="stylesheet" href="css/styles-ie.css" />
    <div class="alert-ie">
      <p>
        <strong>Attention ! </strong> Votre navigateur (Internet Explorer 6 ou 7) présente de sérieuses lacunes en terme de sécurité et de performances, dues à son obsolescence.<br>
        En conséquence, ce site sera consultable mais de manière moins optimale qu'avec un navigateur récent comme (<a href="http://www.microsoft.com/france/windows/internet-explorer/telecharger-ie9.aspx">Internet Explorer 9</a>, <a href="http://www.mozilla-europe.org/fr/">Firefox 4</a>, <a href="http://www.google.com/chrome?hl=fr">Chrome 10+</a>, <a href="http://www.apple.com/fr/safari/download/">Safari 5</a>)
      </p>
    </div>
<![endif]--> 
  <div class="wrap"><!-- Début wrap -->
    <header role="banner"><!--Début header-->
      <h1><?php echo $this->Html->link($this->Html->image('logo-aux-mariees-de-christele.png',array('width'=>412,'height'=>107,'alt'=>'logo Aux Mariées de Christèle')),'/',array('escape'=>false)); ?></h1>
        <nav id="menu" role="navigation"><!-- Début nav -->
          <ul id="nav_menu">
            <li><?php echo $this->Html->link("Accueil",'/'); ?></li>
            <li class="sub">
              <?php echo $this->Html->link("Catalogue",array('plugin'=>'catalog','action'=>'home','controller'=>'products')); ?>
              <ul>
                <li><?php echo $this->Html->link("Robes de mariées",array('plugin'=>'catalog','action'=>'index','controller'=>'products','type'=>'robe-de-mariee')); ?></li>
                <li><?php echo $this->Html->link("Accessoires",array('plugin'=>'catalog','action'=>'index','controller'=>'products','type'=>'accessoire')); ?></li>
              </ul>
            </li>
            <li class="sub">
              <?php echo $this->Html->link("Nous connaître",'#'); ?>
              <ul>
                <li><?php echo $this->Html->link("Contrats",array('plugin'=>null,'action'=>'view','controller'=>'posts','type'=>'page','slug'=>'contrats')); ?></li>
                <li><?php echo $this->Html->link("Partenariats",array('plugin'=>null,'action'=>'view','controller'=>'posts','type'=>'page','slug'=>'partenariats')); ?></li>
              </ul>
            </li>
            <li><?php echo $this->Html->link("Actualités",array('plugin'=>null,'action'=>'index','controller'=>'posts')); ?></li>
            <li><?php echo $this->Html->link("Livre d'or",array('plugin'=>'guestbook','action'=>'index','controller'=>'guestbooks')); ?></li>
            <li><?php echo $this->Html->link("Contact",array('plugin'=>'contact','action'=>'contact','controller'=>'contacts')); ?></li>
          </ul>
        </nav><!-- Fin nav -->
    </header><!-- Fin header -->
    <div id="contenu"> <!-- Début contenu -->
      <?php $bg = (empty($this->request->params['plugin']) && $this->request->params['action'] == 'home') ? 'class="bg bloc"' : 'class="blocs"' ?>
        <section <?php echo $bg ?>>
          <?php echo $this->Session->flash() ?>
          <?php echo $content_for_layout ?>  
        </section>
          <div class="cb"></div>
          <section id="bandeau"> <!-- Début bandeau -->
            <ul>
              <li class="titre">Aux Mariées de Christèle</li>
              <li>15a, rte de Faillant</li>
              <li>17380 Les Nouillers</li>
              <li>Tél. 06 20 98 53 87</li>
            </ul>
            <?php echo $this->Html->image('etiquette.png',array('width'=>197,'height'=>86,'alt'=>"Étiquette fabrication 100% française")) ?>
            <ul class="horaires">
              <li class="titre">Horaires</li>
              <li>Mardi au vendredi: 14h à19h</li>
              <li>Samedi et lundi: sur rendez-vous</li>
              <li>Dimanche fermé</li>
            </ul>
          </section>
          <div class="cb"></div>
    </div> <!-- Fin contenu -->
      <footer>
          <p>&copy; 2012 Coder In &middot; <a href="http://www.coder-in.fr/mentions.html">mentions légales</a> &middot; <a href="#">plan du site</a> &middot; <a href="#logo">haut de page</a></p>
      </footer>
  </div> <!-- Fin wrap -->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php echo $this->Html->script('script.js'); ?>
    <?php echo $scripts_for_layout; ?>
</body>
</html>
