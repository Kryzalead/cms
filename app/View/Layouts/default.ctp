<!DOCTYPE html> 
<html lang="fr"> 
 
<head>
  <meta charset="UTF-8">
  <title>Aux mariées de Christèle</title>
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <meta name="author" content="Kryzalead" /> 
  <meta name="description" content="Vente de robes de mariage" />
  <meta name="keywords" content="" />
  <meta name="geo.placename" content="Charente-Maritime, France, 17" />
  <meta name="viewport" content="width=device-width" />
  <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/>
  <?php echo $this->Html->css('styles.css') ?>
</head>
  
<body>

<!-- mettre alert IE -->

  <div id="wrap"><!-- Début wrap -->
    <header role="banner"><!--Début header-->
      <h1><?php echo $this->Html->link($this->Html->image('logo-aux-mariees-de-christele.png',array('width'=>412,'height'=>107,'alt'=>'logo Aux Mariées de Christèle')),'/',array('escape'=>false)); ?></h1>
        <nav class="menu" role="navigation"><!-- Début nav -->
          <ul>
            <li><?php echo $this->Html->link("Accueil",'/'); ?></li>
            <li><?php echo $this->Html->link("Catalogue",array('plugin'=>'catalog','action'=>'home','controller'=>'products')); ?>&#124;</li>
            <li><?php echo $this->Html->link("Contrats",array('plugin'=>null,'action'=>'view','controller'=>'posts','type'=>'page','slug'=>'contrats')); ?>&#124;</li>
            <li><?php echo $this->Html->link("Livre d'or",array('plugin'=>'guestbook','action'=>'index','controller'=>'guestbooks')); ?>&#124;</li>
            <li><?php echo $this->Html->link("Actualités",array('plugin'=>null,'action'=>'index','controller'=>'posts')); ?>&#124;</li>
            <li><?php echo $this->Html->link("Partenariats",array('plugin'=>null,'action'=>'view','controller'=>'posts','type'=>'page','slug'=>'partenariats')); ?>&#124;</li>
            <li><?php echo $this->Html->link("Contact",array('plugin'=>'contact','action'=>'contact','controller'=>'contacts')); ?>&#124;</li>
          </ul>
        </nav><!-- Fin nav -->
    </header><!-- Fin header -->
    <div id="contenu"> <!-- Début contenu -->
      <?php echo $content_for_layout ?>
    </div> <!-- Fin contenu -->
  </div> <!-- Fin wrap -->
            
</body>
    <?php echo $this->element('sql_dump'); ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php echo $scripts_for_layout; ?>
</html>

