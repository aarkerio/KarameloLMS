<?php
 #die(debug($this->request->data));
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ? 
 $this->Html->addCrumb('Control Tools', '/admin/entries/start'); 
 $this->Html->addCrumb(__('Glossaries'), '/admin/catglossaries/listing'); 
 echo $this->Html->getCrumbs(' > '); 

 echo $this->Form->create('Catglossary', array('action'=>'edit'));
 if ( isset($this->request->data['Catglossary']['id'])):
     echo $this->Form->input('Catglossary.id', array('type'=>'hidden'));
     $legend = __('Edit Glossary');
 else:
     $legend = __('New Glossary');
 endif;
?>
<fieldset>
  <legend><?php echo $legend ?></legend>
<?php
 echo $this->Form->input('Catglossary.title', array('size' => 30, 'maxlength' => 90, 'label'=>__('Title'), 'class'=>'required'));
 echo $this->Form->input('Catglossary.description', array('type'=>'textarea', 'label'=>__('Description'),'cols'=>40,'row'=>20,'class'=>'required'));
 echo $this->Gags->helps('If active, only logged users can see this lessons', $helps);
 echo $this->Form->input('Catglossary.status', array('type'=>'checkbox', 'label'=> __('Published'), 'value'=>'1'));

 echo $this->Gags->helps('If active, only logged users can see this glossary', $helps);
 echo $this->Form->input('Catglossary.public', array('label'=> __('Glossary is public'), 'value'=>'1' , 'type'=>'checkbox'));

 echo $this->Gags->helps('If active, after save return to Glossaries screen', $helps);
 echo $this->Form->input('Catglossary.end', array('label'=> __('Finish edition'), 'value'=>'1' , 'type'=>'checkbox'));

 echo $this->Form->end(__('Save'));
 echo '</fieldset>';

# ? > EOF