<?php 
# Debugger::dump($this->data);

echo $this->Form->create(Null, array('default'=>False));

if ( isset($this->data['Acquaintance']['id'])):
   echo $this->Form->hidden('Acquaintance.id');
   $legend = __('Edit link');
else:
    $legend = __('New link');
endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<?php 
 echo $this->Form->input('Acquaintance.name', array('size'=>40,'maxlength'=>50, 'label'=>__('Name'), 'class'=>'required'));
 echo $this->Form->input('Acquaintance.description', array('type'=>'textarea', 'cols'=>30, 'rows' =>4, 'label'=>__('Description')));
 echo $this->Form->input('Acquaintance.url', array('size' => 65, 'maxlength'=>220, 'class'=>'required')); 
 echo '</fieldset>';  
 echo $this->Js->submit(__('Save'), array(
                                               'url'         => '/admin/acquaintances/edit',
                                               'update'      => '#list',
                                               'evalScripts' => True,
                                               'before'      => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => False)),
                                               'complete'    => $this->Js->get('#edit')->effect('slideUp',array('buffer'=>False)).$this->Js->get('#loading')->effect('slideUp', array('buffer'=>False)).$this->Js->get('#list')->effect('fadeIn', array('buffer'=>False))
                         ));
echo '</form>';

echo $this->Js->writeBuffer();

# ? > EOF