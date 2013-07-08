<!-- hide elment by default: APP/view/elements/login_hide.ctp -->
<div id="cover" style="display:none;" onclick="ocultar()">
  
</div>
<div id="loginpopup" style="display:none">
<div style="border:3px solid orange; vertical-align: top; padding:3px 10px 4px 4px">
<?php 
echo $this->Html->div(Null,$this->Html->link($this->Html->image('close.gif', array('alt'=>'Close window', 'title'=>'Close window')),
                                             '#', array('onclick'=>'ocultar()', 'escape'=>False)), array('style'=>'width:150px;float:right;'));
echo  $this->Html->div(Null, '', array('style'=>'clear:both;'));
echo  $this->Form->create('User', array('action'=>'login')); 
?>
<fieldset>
<legend><?php __('Login');?> </legend>
<?php
   echo $this->Form->input('User.email', array('size' => 30, 'maxlength'=>50));   
   echo $this->Form->input('User.pwd', array('type' => 'password', 'label'=>'Password', 'size' => 9, 'maxlength'=> 9));
   echo $this->Form->input('User.remember_me', array('type'=>'checkbox', 'label'=> __('Remember me')));
   echo '</fieldset>';
   echo $this->Form->end(__('Login'));

   echo $this->Html->div(Null, $this->Html->link(__('Join us!'), '/users/register', array('style'=>'font-size:7pt')));
   echo $this->Html->div(Null, $this->Html->link(__('Forgot your password?'), '/recovers/recover', array('style'=>'font-size:7pt'))); 
 ?>
</div>
</div>
<!-- End hide_login.ctp element -->
