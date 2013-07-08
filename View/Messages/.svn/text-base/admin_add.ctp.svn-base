<?php 
echo $this->Html->script(array('jquery-plugins/simpleAutoComplete')); 
echo $this->Html->css('autocomplete'); 

$helps = $this->Session->read('Auth.User.helps'); # helps enabled
$this->Html->addCrumb('Control Panel', '/admin/entries/start');  
$this->Html->addCrumb(__('Messages'), '/admin/messages/listing');   
echo $this->Html->getCrumbs(' > '); 
 
echo $this->Gags->imgLoad('charging');

echo $this->Form->create(); 
echo $this->Form->hidden('Message.ajax', array('value'=>1));
echo $this->Form->hidden('Message.sender_id',  array('value'=>$this->Session->read('Auth.User.id')));
echo $this->Form->hidden('Message.username',   array('value'=>$this->Session->read('Auth.User.username')));
?>
<fieldset>
<legend><?php __('Compose message'); ?></legend>
<?php
  echo $this->Gags->ajaxDiv('updater') ;
  
  echo $this->Session->read('Auth.User.username') . '  '.__('write').': <br />';
  echo $this->Form->input('Message.title', array('size' => 35, 'maxlength' => 50, 'label'=>'Asunto')) . '<br />';
  if ( isset($data) ):
      echo $this->Form->label('Message.user_id', __('Send message to').' '. $data['User']['username'].':' ) . '<br />';
      echo $this->Form->input('Message.user_id',   array('type'=>'hidden','value '=>$data['User']['id']));
  else:
      echo $this->Gags->helps('Type three first username characters to display list', $helps); 
      echo $this->Form->input('Message.sendername', array('label'=>__('Send message to').': '));
  endif; 
  echo $this->Form->input('Message.body', array('type'=>'textarea', 'cols'=>50, 'rows'=>8, 'label'=>__('Message'))); 
  echo '</fieldset>';
  echo $this->Js->submit(__('Send message'), array(
                                         'url'         => '/messages/deliver/', 
                                         'update'      => '#updater',
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('updater', 'charging'),
                                         'complete'    => $this->Gags->ajaxComplete('updater', 'charging')));
echo '</form>';

echo $this->Gags->divEnd('updater');

echo $this->Html->scriptStart(); 
?>
$(document).ready(function() {
        $("#MessageSendername").simpleAutoComplete('/messages/autocomplete/');
    });
<?php 
echo $this->Html->scriptEnd();
# ? >