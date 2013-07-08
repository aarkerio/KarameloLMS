<?php  
  $helps = $this->Session->read('Auth.User.helps'); # helps enabled
  $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
  $this->Html->addCrumb(__('Gap filling').'s', '/admin/gaps/listing'); 
  echo $this->Html->getCrumbs(' > ');

  echo $this->Form->create('Gap', array('action' => 'edit'));

  if (isset($this->request->data['Gap']['id'])):
      echo $this->Form->hidden('Gap.id');
      $legend = __('Edit').' '. __('Gap filling');
  else:
      $legend = __('New').' '. __('Gap filling');
  endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<?php
   echo $this->Form->input('Gap.title',  array('size' => 40, 'maxlength' => 50, 'label'=>__('Title'))) . '<br />'; 
   echo $this->Form->input('Gap.points', array('type'=>'select', 'label'=>__('Points'), 'options'=>range(0,20))); 
   
   echo $this->Gags->helps('Save and return to list screen', $helps);
   echo $this->Form->input('Gap.instructions',   array('cols'=>50, 'rows'=>3, 'type'=>'textarea', 'label'=>__('Instructions')));

   echo $this->Gags->helps('Save and return to list screen', $helps);
   echo $this->Form->input('Gap.gaps',   array('cols'=>120, 'rows'=>16, 'type'=>'textarea', 'label'=>__('Sentences')));
   echo $this->Form->input('Gap.status', array('type'=>'checkbox', 'label'=>__('Published')));

   echo $this->Gags->helps('Save and return to list screen', $helps);
   echo $this->Form->input('Gap.knet', array('type'=>'checkbox', 'label'=>__('Share in Knet')));

   echo $this->Gags->helps('Save and return to list screen', $helps);
   echo $this->Form->input('Gap.end',    array('type'=>'checkbox', 'label' => __('Finish edition'))); 
   echo '</fieldset>';
   echo $this->Form->end(__('Save')); 

# ? > EOF
