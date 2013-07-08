<?php
 # die(debug($this->data)); 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled

 $this->Html->addCrumb('Control Panel', '/admin/entries/start');
 $this->Html->addCrumb(__('Tests'), '/admin/tests/listing'); 
 echo $this->Html->getCrumbs(' > '); 
 
 echo $this->Form->create('Test', array('url' => array('action' => 'edit')));
 if ( isset($this->request->data['Test']['id']) ):
     echo $this->Form->hidden('Test.id');
     $legend = __('Edit test');
 else:
     $legend = __('New test');
 endif; 
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<?php 
 echo $this->Form->input('Test.title', array('size'=> 40,'maxlength' => 120, 'label'=>__('Title')));
 echo $this->Form->input('Test.description', array('cols' => 55, 'rows' => 9, 'type'=>'textarea', 'label'=>__('Description')));
 echo $this->Form->input('Test.status', array('type'=>'checkbox','value'=>'1', 'label'=>__('Published')));
 echo $this->Gags->helps('Share in Knet', $helps);
 echo $this->Form->input('Test.knet', array('type'=>'checkbox', 'label'=> __('Share in Knet')));
 echo $this->Form->end(__('Save')); 

 echo '</fieldset>';

# ? > EOF
