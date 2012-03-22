<div id="sidebar" class="white">
    <ul>
        <li class="nosubmenu <?php echo ($currentController == 'dashboard')  ? 'current' : '' ?>">
            <?php echo $this->Html->link($this->Html->image('icone-home.png',array('height'=>25,'width'=>25)) . 'Tableau de bord',array('plugin'=>null,'action'=>'index','controller'=>'dashboard','admin'=>true),array('escape'=>false)); ?>
        </li>
        <li <?php echo ($currentController == 'pages')  ? 'class="current"' : '' ?>>
            <?php echo $this->Html->link($this->Html->image('icone-pages.png',array('height'=>25,'width'=>25)) . 'Pages',array('plugin'=>null,'action'=>'index','controller'=>'pages','admin'=>true),array('escape'=>false)); ?>
            <ul>
                <li><?php echo $this->Html->link("Toutes les pages",array('plugin'=>null,'action'=>'index','controller'=>'posts','?'=>array('type'=>'page'),'admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Ajouter",array('plugin'=>null,'action'=>'edit','controller'=>'posts','?'=>array('type'=>'page'),'admin'=>true)); ?></li>
            </ul>
        </li>
        <li <?php echo ($currentController == 'posts')  ? 'class="current"' : '' ?>>
            <?php echo $this->Html->link($this->Html->image('icone-posts.png',array('height'=>25,'width'=>25)) . 'Articles',array('plugin'=>null,'action'=>'index','controller'=>'posts','admin'=>true),array('escape'=>false)); ?>
            <ul>
                <li><?php echo $this->Html->link("Tous les articles",array('plugin'=>null,'action'=>'index','controller'=>'posts','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Ajouter",array('plugin'=>null,'action'=>'edit','controller'=>'posts','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Catégories",array('plugin'=>'taxonomy','controller'=>'terms','action'=>'edit','?'=>array('type'=>'category'),'admin'=>true)); ?></li>
            </ul>
        </li>
        <li <?php echo ($currentController == 'medias')  ? 'class="current"' : '' ?>>
            <?php echo $this->Html->link($this->Html->image('icone-medias.png',array('height'=>25,'width'=>25)) . 'Medias',array('plugin'=>null,'action'=>'index','controller'=>'medias','admin'=>true),array('escape'=>false)); ?>
            <ul>
                <li><?php echo $this->Html->link("Bibliothèque",array('plugin'=>null,'action'=>'index','controller'=>'medias','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Ajouter",array('plugin'=>null,'action'=>'edit','controller'=>'medias','admin'=>true)); ?></li>
            </ul>
        </li>
        <li class="nosubmenu <?php echo ($currentController == 'comments')  ? 'current' : '' ?>">
            <?php echo $this->Html->link($this->Html->image('icone-comments.png',array('height'=>25,'width'=>25)) . 'Commentaires',array('plugin'=>null,'action'=>'index','controller'=>'comments','admin'=>true),array('escape'=>false)); ?>
        </li>
    </ul>
    <ul>
        <li class="nosubmenu <?php echo ($currentController == 'menus')  ? 'current' : '' ?>">
            <?php echo $this->Html->link($this->Html->image('icone-menus.png',array('height'=>25,'width'=>25)) . 'Menus',array('plugin'=>null,'action'=>'index','controller'=>'menus','admin'=>true),array('escape'=>false)); ?>
        </li>
        <li <?php echo ($currentController == 'users')  ? 'class="current"' : '' ?>>
            <?php echo $this->Html->link($this->Html->image('icone-users.png',array('height'=>25,'width'=>25)) . 'Utilisateurs',array('plugin'=>null,'action'=>'index','controller'=>'users','admin'=>true),array('escape'=>false)); ?>
            <ul>
                <li><?php echo $this->Html->link("Tous les utilisateurs",array('plugin'=>null,'action'=>'index','controller'=>'users','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Ajouter",array('plugin'=>null,'action'=>'edit','controller'=>'users','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Votre profil",array('plugin'=>null,'action'=>'edit','controller'=>'users','?'=>array('id'=>$this->Session->read('Auth.User.id')),'admin'=>true)); ?></li>
            </ul>
        </li>
        <li <?php echo ($currentController == 'options')  ? 'class="current"' : '' ?>>
            <?php echo $this->Html->link($this->Html->image('icone-config.png',array('height'=>25,'width'=>25)) . 'Réglages',array('plugin'=>null,'action'=>'edit','controller'=>'options','admin'=>true),array('escape'=>false)); ?>
            <ul>
                <li><?php echo $this->Html->link("Général",array('plugin'=>null,'action'=>'general','controller'=>'options','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Ecriture",array('plugin'=>null,'action'=>'write','controller'=>'options','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Lecture",array('plugin'=>null,'action'=>'read','controller'=>'options','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Discussion",array('plugin'=>null,'action'=>'discussions','controller'=>'options','admin'=>true)); ?></li>
                <li><?php echo $this->Html->link("Médias",array('plugin'=>null,'action'=>'media','controller'=>'options','admin'=>true)); ?></li>
                <?php if ($this->Session->read('Auth.User.role') == 'superadmin'): ?>
                    <li><?php echo $this->Html->link("Agence",array('plugin'=>null,'action'=>'agence','controller'=>'options','superadmin'=>true)); ?></li>
                <?php endif ?>
            </ul>
        </li>
    </ul>
    <a href="#collapse" id="menucollapse">◀ Réduire le menu</a>
</div>