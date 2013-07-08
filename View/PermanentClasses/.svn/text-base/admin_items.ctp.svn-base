<?php
# this file is called from URL /admin/permanent_classes/record/3 
echo $this->Html->script(array('jquery-plugins/simpleAutoComplete'));
echo $this->Html->css('autocomplete'); 

$helps = $this->Session->read('Auth.User.helps'); # helps enabled ? boolean

echo $this->Form->create('PermanentClass', array('action'=>'items'));
echo $this->Form->hidden('PcStudent.pc_id', array('value'=>$pc_id));
?>
<fieldset>
<legend><?php echo __('Enroll student to this classroom');?>:</legend>
<?php 
 echo $this->Form->input('PcStudent.username', array('label'=> __('Type first letters to find student').': '));
 echo '</fieldset>';
 echo $this->Form->end(__('Send')); 

echo $this->Html->scriptStart(); 
?>
$(document).ready(function() {
        $("#PcStudentUsername").simpleAutoComplete('/messages/autocomplete/');
    });
<?php
echo $this->Html->scriptEnd();
# ? > EOF
