<div class="left">
    <?php
        $gravatar = md5( strtolower( trim($this->Session->read('Auth.User.email'))));
        echo $this->Html->image('http://www.gravatar.com/avatar/'.$gravatar.'?s=20', array('class'=>"gravatar")); ?>
    <span>Bonjour,</span>
    <?php echo $this->Html->link($this->Session->read('Auth.User.username'),array('action'=>'edit','controller'=>'users',$this->Session->read('Auth.User.id'))); ?>
    <span>|</span>
    <?php echo $this->Html->link('Voir mon site','/',array('target'=>'_blank')) ?>
    <span>|</span>
    <?php echo $this->Html->link('Se déconnecter',array('controller'=>'users','action'=>'logout','admin'=>false))?>
</div>
<!--
<div class="right">
    <form action="#" id="search" class="search placeholder">
        <label>Vous recherchez un truc ?</label>
        <input type="text" value="" name="q" class="text">
        <input type="submit" value="rechercher" class="submit">
    </form>
</div>
-->