<?php 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?

 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 $this->Html->addCrumb(__('Permanent Class'), '/admin/permanent_classes/listing'); 
 echo $this->Html->getCrumbs(' > '); 
 echo $this->Form->create('PermanentClass', array('action'=>'edit'));
 if (!empty($this->data) && isset($this->data['PermanentClass']['id'])): 
     echo $this->Form->hidden('PermanentClass.id');
     $legend = __('Edit permanent student list');
 else:
     $legend = __('New permanent student list');
 endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<table style="margin:0 auto 0 auto;">
 <tr>
     <td><?php echo $this->Form->input('PermanentClass.title', array('size' => 50, 'maxlength' => 50, 'class'=>'required')); ?></td>
 </tr>
 <tr>
     <td><?php echo $this->Form->input('PermanentClass.body', array('type'=>'textarea', 'cols'=>40, 'rows'=>7, 'label'=>__('Description'))); ?></td>
 </tr> 
 <tr><td>
 <?php
    echo $this->Gags->helps('Set permanent class as archived', $helps);
    echo $this->Form->input('PermanentClass.archived', array('type'=>'checkbox', 'label'=> __('Archived')));
  ?>
  </td></tr>
  <tr>
      <td><?php echo $this->Form->input('PermanentClass.end', array('type'=>'checkbox', 'label'=> __('Finish edition'))); ?></td>
  </tr>
  <tr><td>
  </fieldset>
  <?php echo $this->Form->end(__('Save')); ?>
</td></tr>
</table>
