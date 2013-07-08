<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/listing');  
$this->Html->addCrumb(__('Users'), '/admin/users/listing');  
echo $this->Html->getCrumbs(' > '); 
  
echo $this->Html->div('title_section', $this->Html->image('karamelo_users.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Users'), 'title'=>__('Users'))).' '.__('Multi register'));

if (isset($inserted)):
    echo $this->Html->div('message', $inserted . ' '.__('new users have been registered'). 'in '.$counter .' lines');
endif;

echo $this->Html->para(null, __('In this screen you can upload a comma separated values (CSV) file to register multiple users in on simple step. Each line in the file should have the next seven fields format:'));

echo $this->Html->para(null, "<i>username, email, group_id, Name and lastname, password, language, actived</i>");
echo $this->Html->para(null, "Where group_id is 2 for teachers and 3 for students. Actived column define if user is enabled and if so he/she can login inmediatly");
echo $this->Html->para(null, "each line in the file should look like this examples:");
echo $this->Html->para(null, "<i>jmeyer, jamey@gmail.com, 3, Jean Francis Meyer, kal1forn1arulEz, en, 1<br />
chlicuil, jay@chipotle-software.com, 2, Carlo Mendoza, alalsdfds67ulEz, es, 0</i>");

echo $this->Html->para(null, __('Before try to insert new users select') .' <i> '. __('Do not insert users just test file') .' </i> '.__('option to be sure the file have the correct format and there is not duplicated username or email.'));

echo $this->Form->create('User', array('enctype'=>'multipart/form-data', 'action'=>'record'));
?>
<fieldset>
    <legend><?php __('Upload File'); ?></legend>
<?php 
 echo $this->Form->input('User.file', array('type'=>'file', 'label'=>__('File'))); 
 echo $this->Form->input('User.test', array('type'=>'checkbox', 'label'=>__('Do not insert users just test file'), 'value'=>'1'));
 echo '</fieldset>';
 echo $this->Form->end(__('Upload')); 
?>
 
