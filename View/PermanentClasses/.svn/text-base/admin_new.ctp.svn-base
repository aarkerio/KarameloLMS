<?php 
 echo $this->Html->para(Null, __('You are creating a new list using this current student list'));
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
 echo $this->Form->create('PermanentClass', array('action'=>'new'));
 echo $this->Form->input('PermanentClass.vclassroom_id', array('type'=>'hidden', 'value'=>$vclassroom_id));
?>
<fieldset>
<legend><?php echo  __('New Student list') ; ?></legend>
<?php 
  echo $this->Form->input('PermanentClass.title', array('size' => 50, 'maxlength' => 50, 'class'=>'required'));
  echo $this->Form->input('PermanentClass.body', array('type'=>'textarea', 'cols'=>40, 'rows'=>5, 'label'=>__('Description')));
  echo '</fieldset>';

  echo $this->Form->end(__('Save')); 

  $img = $this->Html->div(null, $this->Html->link($this->Html->image('static/icon_hide.gif', array('alt'=>__('Hide'), 'title'=>__('Hide'))), 
         '#head', array('onclick'=>'hideDiv()', 'escape'=>False)));

  echo $this->Html->div(null, $img, array('style'=>'margin-top:15px;padding:4px;'));

# ? > EOF
