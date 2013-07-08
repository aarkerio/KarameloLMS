<?php 
$helps = $this->Session->read('Auth.User.helps'); # helps enabled
echo $this->Html->script('ckeditor/ckeditor'); 

$this->Html->addCrumb('Control Panel', '/admin/entries/start');  
$this->Html->addCrumb(__('Scavengers Hunts'), '/admin/treasures/listing'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Form->create('Treasure',array('action'=>'edit', 'onsubmit'=>'return chkForm()')); 

if (isset($this->request->data['Treasure']['id'])): 
   echo $this->Form->hidden('Treasure.id');
   $legend = __('Edit') .' '.__('Scavenger Hunt');
else:
   $legend = __('New') .' '.__('Scavenger Hunt');
endif;
?>
<fieldset><legend><?php echo $legend; ?></legend>
<table style="margin-top:30px;">
<tr><td>
  <?php echo $this->Form->input('Treasure.title', array('size' => 40, 'maxlength' => 120, 'label'=>__('Title'))); ?>
</td><td>
<?php echo $this->Form->input('Treasure.points', array('input'=>'select', 'label'=> __('Points'), 'options'=> range(0, 20)));  ?>
 </td>
<td>
 <?php echo $this->Gags->setImages(); ?>
</td></tr>
<tr><td colspan="3">
  <?php 
   echo $this->Form->input('Treasure.instructions', array('type'=>'textarea', 'cols'=>80, 'rows'=>25, 'label'=> __('Instructions')));
   echo $this->Ck->load('TreasureInstructions', 'Karamelo', $this->Session->read('Auth.User.lang'), 800, 600); 
  ?> 
</td></tr>
<tr><td colspan="3">
  <?php 
    echo $this->Gags->helps('Secret code in treasury box', $helps);
    echo $this->Form->input('Treasure.secret', array('size'=>15, 'maxlength'=>15, 'label'=>__('Code')));
  ?>
  </td>
</tr>
<tr><td colspan="2">
<?php
 echo $this->Gags->helps('Published or draft', $helps); 
 echo $this->Form->input('Treasure.status', array('type'=>'checkbox', 'label'=> __('Published')));  
 echo $this->Gags->helps('Share in Knet network', $helps);
 echo $this->Form->input('Treasure.knet', array('type'=>'checkbox', 'label'=> __('Share in Knet')));
?>
<td>
<td>
<?php
 echo $this->Gags->helps('Save and return to list', $helps);
 echo $this->Form->input('Treasure.end', array('type'=>'checkbox', 'label'=> __('Finish edition')));
?>
</td>
</tr>  
<tr><td colspan="3"><?php echo $this->Form->end(__('Save')); ?> </td></tr>
</table>

<?php echo $this->Html->scriptStart(); ?>
function chkFormNu()
{ 
  var title  = document.getElementById("TreasureTitle");
  
  if (title.value.length < 3)
  {
    alert('The name must have three characters at least');
    title.focus();
    return false;
  }
  return true;
}
<?php 
echo $this->Html->scriptEnd(); 
# ? > EOF
 