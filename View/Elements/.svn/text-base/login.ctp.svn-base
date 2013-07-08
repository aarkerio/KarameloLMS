<div id="login">
<?php echo  $this->Form->create('User', array('action'=>'login')); ?>
<fieldset>
<legend><?php __('Login'); ?></legend>
<?php
 echo $this->Form->input('User.email', array('size' => 13, 'maxlength'=> 45));
 echo $this->Form->input('User.pwd', array('type'=>'password','id'=>'user_pwd','size' => 9,'maxlength' => 9,'label'=> 'Password'));
 echo $this->Form->input('User.remember_me',array('type'=>'checkbox', 'label' => __('Remember me')));
 echo $this->Form->end('Login'); 
?>
</fieldset>
<?php 
   echo $this->Html->div(Null, $this->Html->link(__('Join us!'), '/users/register', array('style'=>'font-size:7pt;'))); 
   echo $this->Html->div(Null, $this->Html->link(__('Forgot your password?'), '/recovers/recover', array('style'=>'font-size:7pt;'))) ; 
?>
</div>
