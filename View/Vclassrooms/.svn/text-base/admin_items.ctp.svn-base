<?php
# this file is called from APP/ 
echo $this->Html->script(array('jquery-plugins/simpleAutoComplete'));
echo $this->Html->css('autocomplete'); 

$helps = $this->Session->read('Auth.User.helps'); # helps enabled ? boolean

echo $this->Form->create('Vclassroom', array('action'=>'items')); 
echo $this->Form->hidden('UserVclassroom.vclassroom_id', array('value'=>$vclassroom_id));
?>
<fieldset>
<legend><?php echo __('Enroll student to this classroom');?>:</legend>
<?php 
 echo $this->Form->input('UserVclassroom.username', array('label'=> __('Type first letters to find student').': '));
 echo '</fieldset>';
 echo $this->Form->end(__('Send')); 

echo $this->Html->scriptStart(); 
?>
$(document).ready(function() {
        $("#UserVclassroomUsername").simpleAutoComplete('/messages/autocomplete/');
    });
<?php
echo $this->Html->scriptEnd();

$img = $this->Html->div(null, $this->Html->link($this->Html->image('static/icon_hide.gif', array('alt'=>__('Hide'), 'title'=>__('Hide'))), 
         '#head', array('onclick'=>'hideDiv()', 'escape'=>False)));

echo $this->Html->div(Null, $img, array('style'=>'margin-top:15px;padding:4px;'));

# ? > EOF
