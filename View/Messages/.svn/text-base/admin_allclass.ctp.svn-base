<fieldset>
<legend><?php __('New message'); ?></legend>
<?php
echo $this->Form->create('Message', array('action'=>'send2class'));
echo $this->Form->hidden('Message.vclassroom_id', array('value'=>$vclassroom_id));
echo $this->Form->input('Message.title', array('size'=>40, 'maxlength'=>80, 'label'=>__('Title')));
echo $this->Form->textarea('Message.body', array('rows'=>5, 'cols'=>80));
echo $this->Form->end(__('Send'));
echo '</fieldset>';

$img = $this->Html->div(null, $this->Html->link($this->Html->image('static/icon_hide.gif', array('alt'=>__('Hide'), 'title'=>__('Hide'))), 
         '#head', array('onclick'=>'hideDiv()', 'escape'=>False)));

echo $this->Html->div(null, $img, array('style'=>'margin-top:15px;padding:4px;'));

# ? > EOF
