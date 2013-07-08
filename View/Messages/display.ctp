<?php
#die(debug($data));
if ($this->action == 'display'): # student view
    echo $this->Html->para(null, $this->Html->link(
                     $this->Html->image('admin/compose_on.gif', array('alt'=>__('New message'),'title'=>__('New message'))),  '/messages/compose', 
                                       array('escape'=>False)));
else:
    $this->Html->addCrumb('Control Panel', '/admin/entries/start');
    $this->Html->addCrumb(__('Messages'), '/admin/messages/listing');
    echo $this->Html->getCrumbs(' > ');
endif;

echo $this->Gags->imgLoad('charging');

echo $this->Html->para(Null, '<b>'.__('From').'</b>:'     . $data['User']['username']);
echo '<b>Subject</b>: ' . $data['Message']['title']  . '<br />';
echo $this->Html->div(null, nl2br(Sanitize::html($data['Message']['body'])), array('style'=>'padding:8px;background-color:#e7e6e6;margin:5px;'));

echo '<div style="width: 500px;float: left;margin:auto;">';
echo '<input type="button" value="'.__('Reply').'" onclick="hU()" />';

echo $this->Gags->ajaxDiv('delbutton', array('style'=>'text-align:right;float:right;'));
echo $this->Form->create('Message', array('onsubmit'=>'return confirm(\''.__('Are you sure to want to delete this?').'\')','action'=>'delete'));
echo $this->Form->hidden('Message.id', array('value'=>$data['Message']['id']));
echo $this->Form->end(__('Delete'));
echo $this->Gags->divEnd('delbutton');
?>
</div>
<!-- ** HIDDEN REPLY FORM*** -->
<div id="formhidden" style="visibility:hidden">
<?php
  echo $this->Form->create(); 
  echo $this->Form->hidden('Message.username',   array('value'=> $this->Session->read('Auth.User.username')));
  echo $this->Form->hidden('Message.message_id', array('value'=> $data['Message']['id']));
  echo $this->Form->hidden('Message.user_id',    array('value'=> $data['Message']['sender_id'])); 
?>
<fieldset>
<legend><?php __('Reply'); ?></legend>
  <?php 
  echo $this->Session->read('Auth.User.username') .' '. __('writes').': <br />';
 
  echo $this->Form->input('Message.title', array('size'=>35,'maxlength'=>50,'value'=> 'Re: ' . $data['Message']['title'])) . '<br />';
  echo $this->Form->input('Message.body', array('cols'=>50,'rows'=>10, 'label'=>False,'value'=>"\n\n".'>> '.$data['User']['username'] .' '.__('wrote').': ' . $data['Message']['body']));
  echo '</fieldset>';
  echo $this->Js->submit(__('Reply'), array(
                                         'url'         => '/messages/deliver',
                                         'update'      =>'#formhidden',
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('formhidden','charging'),
                                         'complete'    => $this->Gags->ajaxComplete('formhidden','charging')));
 ?>
</div>
<!-- ** //HIDDEN REPLY FORM*** -->
<?php echo $this->Html->scriptStart(); ?>
function hU() {

 var tr = document.getElementById('formhidden');
 var ta = document.getElementById('MessageBody');

 if (tr.style.visibility == 'hidden')
 {
     tr.style.visibility = 'visible';
     ta.focus();
 } 
 else 
 {
     tr.style.visibility = 'hidden';
 }
}
<?php echo $this->Html->scriptEnd(); ?>