<?php
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled
 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 $this->Html->addCrumb(__('Collections'), '/admin/collections/listing'); 
 echo $this->Html->getCrumbs(' > ');

 echo $this->Form->create('Collection', array('action' => 'edit'));  
 if ( isset($this->request->data['Collection']['id']) ): 
     echo $this->Form->hidden('Collection.id');
     $legend = __('Edit source');
 else:
     $legend = __('New source');
 endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<?php 
echo $this->Form->input('Collection.type_id', array('type'=>'select', 'label'=> __('Type'), 'options'=> $types)); 
echo $this->Form->input('Collection.clasification_id',array('type'=>'select','label'=> __('Clasification'),'options'=>$clasifications));
echo $this->Form->input('Collection.copies',  array('type'=>'select', 'label'=> __('Copies'), 'selected'=>'1', 'options'=> range(0, 20))); 
echo $this->Form->input('Collection.title', array('size' => 60, 'maxlength' => 150, 'label'=>__('Title'), 'class'=>'required')); 
echo $this->Form->input('Collection.author', array('size' => 60, 'maxlength' => 150, 'label'=>__('Author')));
echo $this->Form->input('Collection.edition', array('size' => 3, 'maxlength' => 3, 'value'=>1, 'label'=>__('Edition'))); 

echo $this->Gags->helps('Write here categories you think can help to cathegorize this item as:art, math, history, etc', $helps);
echo $this->Form->input('Collection.tags', array('size' => 40, 'maxlength' => 60, 'label'=>__('Tags'))); 

echo $this->Gags->helps('Dewey or similar taxonomy to find in shell', $helps);
echo $this->Form->input('Collection.taxonomy', array('size' => 40, 'maxlength' => 60, 'label'=>__('Taxonomy'))); 

echo $this->Form->input('Collection.editor', array('size' => 40, 'maxlength' => 50, 'label'=>__('Edithor')));
echo $this->Form->input('Collection.isonumber', array('size' => 40, 'maxlength' => 50, 'label'=>__('ISONUM')));
echo $this->Form->input('Collection.cost', array('type'=>'text','size' => 6, 'value'=>'0.0', 'maxlength' => 6, 'label'=>__('Price')));
echo $this->Form->input('Collection.status', array('type'=>'checkbox', 'label'=> __('Mark as available'))); 
echo $this->Form->input('Collection.end', array('type'=>'checkbox', 'label'=> __('Finish edition'), 'value'=>'1'));
echo $this->Form->end(__('Save'));

echo '</fieldset>';

# ? > EOF

