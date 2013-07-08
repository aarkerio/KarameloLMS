<?php 
echo $this->Html->div('title_section', $this->Html->image('articles.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Themes'), 'title'=>__('Themes'))).' '.__('Themes'));

echo $this->Html->para(null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add theme'))), '#', array('onclick'=>'showHide()', 'escape'=>False))); 
?>

<div id="add" style="display:none">
<?php echo $this->Form->create('Themes', array('action'=>'add', 'enctype'=>'multipart/form-data', 'onsubmit'=>'return chkData()')); ?>
<fieldset>
<legend><?php __('New Theme'); ?></legend>
 <?php
  echo $this->Form->label('Theme.file', 'Image (90x90 pixels):');
  echo $this->Form->file('Theme.file');
  echo $this->Form->input('Theme.theme', array('size'=>30, 'maxlength'=>40));
  echo $this->Form->input('Theme.description', array('size' => 40, 'maxlength' => 150));
  echo $this->Form->end(__('Save')); 
?>
</fieldset>
</div>
<table style="width:100%;border-collapse: collapse;paddin:4px">
<?php
$th = array(__('Edit'), __('Name'), __('Description'), __('Image'), __('Delete'));
echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));
foreach ($data as $val):
    $tr = array (
        $this->Gags->sendEdit($val['Theme']['id'], 'themes'),
        $val['Theme']['theme'],
        $val['Theme']['description'],
        $this->Html->link($this->Html->image('themes/'.$val['Theme']['img'], array('alt'=>$val['Theme']['theme'], 'title'=>$val['Theme']['theme'], 'width'=>40)), '/img/themes/'.$val['Theme']['img'], array('escape'=>False)),
        $this->Gags->confirmDel($val['Theme']['id'], 'themes')
        );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?>
</table>

<script lenguage="javascript">
<!--
function chkData()
{
 var file  =  document.getElementById('ThemeFile');
 var theme =  document.getElementById('ThemeTheme');
 var desc  =  document.getElementById('ThemeDescription');

 if (desc.value.length < 3)
 {
  alert('<?php __('Description must have three letters at least');?>');
  desc.focus();
  return false;
 }

 if (theme.value.length < 3)
 {
  alert('<?php __('Theme must have three letters at least'); ?>');
  theme.focus();
  return false;
 }

 if (file.value.length < 3)
 {
  alert('<?php __('File must have three letters at least');?>');
  file.focus();
  return false;
 }

 return true;
}

function showHide() 
{
    var target1 =  document.getElementById('add');
    
    if (target1.style.display=="none") 
    {
        target1.style.display ="block";
    } else {
        target1.style.display ="none";
    }
}
-->
</script>
