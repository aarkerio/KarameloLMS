<fieldset>
<legend>New Message</legend>
<?php
echo $this->Form->create('Message', array('action'=>'send2class'));
echo $this->Form->hidden('Message.vclassroom_id', array('value'=>$vclassroom_id));
echo $this->Form->input('Message.title', array('size'=>40, 'maxlength'=>80, 'between'=>': '));
echo $this->Form->textarea('Message.body', array('rows'=>5, 'cols'=>30));
echo $this->Form->end('Send');
?>
</fieldset>