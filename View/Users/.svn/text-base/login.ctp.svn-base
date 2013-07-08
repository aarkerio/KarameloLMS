<?php
$this->set('title_for_layout', 'Login');
echo '<div style="margin:10px;">';
echo '<h1>Login</h1>';
if ($this->Session->check('Message.auth')):
    echo $this->Session->flash('auth');
endif;

echo $this->Form->create('User', array('action' => 'login'));
echo $this->Form->input('User.email', array('size' => 40, 'maxlength'=> 50));
echo $this->Form->input('User.pwd',   array('type' => 'password', 'label'=>'Password:', 'size' => 9, 'maxlength'=> 9));
echo $this->Form->input('User.remember_me', array('type'=>'checkbox', 'label' =>__('Remember me')));
echo $this->Form->end('Login');

echo $this->Html->para(Null, $this->Html->link(__('Join us!'), '/users/register')); 
echo $this->Html->para(Null, $this->Html->link(__('Forgot your password?'), '/recovers/recover')); 

echo '</div>';

# ? > EOF

