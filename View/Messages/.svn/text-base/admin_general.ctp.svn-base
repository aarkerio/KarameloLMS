<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Messages'), '/admin/messages/listing');
echo $this->Html->getCrumbs(' > ');
echo $this->Html->para(null, __('On this screen you can send a messages to all portal members to inform about general events').'.');
?>
<fieldset>
<legend><? __('New General Message'); ?></legend>
<?php
echo $this->Form->create('Message', array('action'=>'general'));
echo $this->Form->input('Message.title', array('size'=>40, 'maxlength'=>80, 'label'=>__('Title')));
echo $this->Form->textarea('Message.body', array('rows'=>17, 'cols'=>70));
echo $this->Form->end(__('Send'));
?>
</fieldset>