<?php 
 #die(debug($this->data)); 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?

 if ( !isset($add) ): # load only if not is an ajax call
     $this->Html->addCrumb('Control Panel', '/admin/entries/start');  
     $this->Html->addCrumb('FAQs', '/admin/catfaqs/listing'); 
     echo $this->Html->getCrumbs(' > '); 
 endif;

 echo $this->Form->create('Catfaq', array('action'=>'admin_edit'));
 if ( isset($this->data['Catfaq']['id']) ):
     echo $this->Form->hidden('Catfaq.id');
     $legend = __('Edit Category');
  else:
     $legend = __('New Category');
 endif;
?>
<fieldset>
 <legend><?php echo $legend ?> </legend>
 <?php 
 echo $this->Form->input('Catfaq.title', array('size'=>30,'maxlength'=> 90, 'class'=>'required', 'label'=>__('Title')));
 echo $this->Form->input('Catfaq.description', array('cols' => 40, 'row' => 20, 'label'=> __('Description')));

 echo $this->Gags->helps('If active, only logged users can see this resource', $helps);
 echo $this->Form->input('Catfaq.public', array('type'=>'checkbox', 'label' => __('FAQ is public')));

 echo $this->Gags->helps('Select if FAQ is ready to be published in your edublog', $helps);
 echo $this->Form->input('Catfaq.status', array('type'=>'checkbox', 'label' => __('Published')));

 echo $this->Gags->helps('Save and return to list screen', $helps);
 echo $this->Form->input('Catfaq.end', array('label'=>__('Finish edition'), 'type'=>'checkbox')); 
?>
  <div style="clear:both"></div>
  <br />
  <?php echo $this->Form->end(__('Save')); ?>
</fieldset>
