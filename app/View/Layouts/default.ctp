<!DOCTYPE html> 
<html lang="fr"> 
 
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
</head>
<body>
<!--[if lte IE 7]>
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
              <?php echo $this->Html->link("Nous connaitre",'#'); ?>
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
