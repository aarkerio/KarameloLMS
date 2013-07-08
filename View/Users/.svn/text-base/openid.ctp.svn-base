<?php
echo $this->Html->div(null, $this->Html->image('static/google-openid-logo.png', array('alt'=>'OpenID', 'title'=>'OpenID')));

echo $this->Html->div(null, __('In order to join Karamelo community you need type your Google Account. If you do not have one get it here'));

if (isset($message)):
    echo '<p class="error">'.$message.'</p>';
endif;
echo $this->Form->create('User', array('action' => 'openid'));
echo $this->Form->input('OpenidUrl.openid', array('label' => false));
echo $this->Form->end('Login');
?>