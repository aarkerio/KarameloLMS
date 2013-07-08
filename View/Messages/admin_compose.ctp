<?php
  echo $this->Form->create(); 
  echo $this->Form->hidden('Message.user_id', array('value'=>$user_id));
?>
<fieldset>
<legend><?php __('Compose message'); ?></legend>
<?php 
  echo $this->Session->read('Auth.User.username'). '  '. __('write').':';
  echo $this->Form->input('Message.title', array('size' => 27, 'maxlength' => 50, 'label'=>__('Title')));
  echo $this->Form->input('Message.body', array('cols'=>30, 'rows'=>10, 'type'=>'textarea', 'label'=>False)); 
  echo '</fieldset>';
  echo $this->Js->submit(__('Send'), array(
                                         'url'         => '/messages/deliver', 
                                         'update'      => '#compose',
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('adminEdit'),
                                         'complete'    => $this->Gags->ajaxComplete('adminEdit'))); 

echo '</form>';

echo $this->Js->writeBuffer();

# ? > EOF
