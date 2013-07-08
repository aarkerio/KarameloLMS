<?php 
echo $this->Html->script(array('jquery-plugins/simpleAutoComplete'));
echo $this->Html->css('autocomplete'); 

#die(debug($data));
$helps = $this->Session->read('Auth.User.helps'); # helps enabled
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Collections'), '/admin/collections/listing');
echo $this->Html->getCrumbs(' > '); 

echo $this->Form->create('Collection', array('action' => 'add'));
echo $this->Form->input('Lending.collection_id', array('type'=>'hidden','value'=>$data['Collection']['id']));

if ( isset($this->reques->data['Lending']['id']) ):
    $legend = __('Edit source');
else:
    $legend = __('New lent');
endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<?php 
echo $this->Html->para(Null, '<b>Item</b>: '.$data['Collection']['title']); 
echo $this->Form->input('Message.sendername', array('label'=>__('Type first four character of user').': '));
echo $this->Form->input('Lending.sdate', array('type'=>'date','label'=>__('Start lent')));
echo $this->Form->input('Lending.fdate', array('type'=>'date','label'=>__('Finish lent')));
echo '</fieldset>';
echo $this->Form->end(__('Save'));

echo $this->Html->scriptStart(); 
?>
$(document).ready(function() {
        $("#MessageSendername").simpleAutoComplete('/messages/autocomplete/');
    });
<?php
echo $this->Html->scriptEnd();
# ? > EOF

