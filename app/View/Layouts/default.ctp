<!DOCTYPE html> 
<html lang="fr"> 
 
<head>
  <meta charset="UTF-8">
  <title><?php echo $title_for_layout ?></title>
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
  <style type="text/css">.alignLeft{float: left}</style>
</head>
  
<body>

<!-- mettre alert IE -->

  <div class="wrap"><!-- Début wrap -->
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
      <?php $bg = (empty($this->request->params['plugin']) && $this->request->params['action'] == 'home') ? 'bg' : 'bgBlanc' ?>
      <div id="<?php echo $bg ?>">
        <?php if (empty($this->request->params['plugin']) && $this->request->params['controller'] == 'posts'): ?>
          <section class="bloc">
            <?php echo $content_for_layout ?>
          </section>
        <?php else: ?>
          <?php echo $content_for_layout ?>  
        <?php endif ?>
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
      </div>

    </div> <!-- Fin contenu -->
  </div> <!-- Fin wrap -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <?php echo $this->Html->scriptStart() ?>
    
    $('.placeholder').each(function(){
       var label = $(this).find('label:first');
       
       var input = $(this).find('input:first,textarea:first'); 
       
       if(input.val() != ''){
           label.stop().hide(); 
       }
       input.focus(function(){
           if($(this).val() == ''){
                label.stop().fadeTo(500,0.5);  
           }
           $(this).parent().removeClass('error').find('.error-message').fadeOut(); 
       });
       input.blur(function(){
           if($(this).val() == ''){
                label.stop().fadeTo(500,1);  
           }
       });
       input.keypress(function(){
          label.stop().hide(); 
       });
       input.keyup(function(){
           if($(this).val() == ''){
                label.stop().fadeTo(500,0.5); 
           }
       });
       input.bind('cut copy paste', function(e) {
            label.stop().hide(); 
       });
    }); 
    
    $('.close').click(function(){$(this).parent().fadeTo(500,0).slideUp();});
    <?php echo $this->Html->scriptEnd(); ?>
    <?php echo $scripts_for_layout; ?>
</body>
    <?php echo $this->element('sql_dump'); ?>
</html>
