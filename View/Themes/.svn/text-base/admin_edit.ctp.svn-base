<?php 
 $this->Html->addCrumb('Control Tools', '/admin/entries/start');
 $this->Html->addCrumb('Themes', '/admin/themes/listing');
 echo $this->Html->getCrumbs(' > ');

 echo $this->Html->div('title_section', __('Edit Theme'));

 echo '<div id="add">';
 
 echo $this->Form->create('Themes', array('action'=>'edit','enctype'=>'multipart/form-data', 'onsubmit'=>'return chkData()')); 
 echo $this->Form->hidden('Theme.id');
?>  
<fieldset>
<legend><? __('Edit Theme'); ?></legend>
  <?php 
  echo $this->Form->input('Theme.theme', array('size' => 30, 'maxlength' => 40, 'class'=>'required'));
  echo $this->Form->input('Theme.description', array('size' => 40, 'maxlength' => 150, 'class'=>'required')); 
  echo '</fieldset>';
  echo $this->Form->end(__('Save')); 

  echo $this->Html->scriptStart();
?>
function chkData()
{
 var file  =  document.getElementById('ThemeFile');
 var theme =  document.getElementById('ThemeTheme');
 var desc  =  document.getElementById('ThemeDescription');

 if (desc.value.length < 3)
 {
  alert('Description must have three letters at least');
  desc.focus();
  return false;
 }

 if (theme.value.length < 3)
 {
  alert('Theme must have three letters at least');
  theme.focus();
  return false;
 }

 if (file.value.length < 3)
 {
  alert('File must have three letters at least');
  file.focus();
  return false;
 }

 return true;
}

<?php echo $this->Html->scriptEnd(); ?>