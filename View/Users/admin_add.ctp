<?php
#die(debug($this->data));
$this->request->data['User']['pwd'] = ''; # Just verify
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Users'), '/admin/users/listing'); 
echo $this->Html->getCrumbs(' > ');

echo $this->Form->create('User', array('action'=>'add', 'onsubmit'=>'return validate()'));
if (!empty($this->request->data) && isset($this->request->data['User']['id'])): 
     echo $this->Form->hidden('User.id');
     echo $this->Form->hidden('Profile.id');
     $legend = __('Edit user');
else:
     $legend = __('New user');
endif;
?>
<fieldset><legend><?php echo $legend ; ?></legend>
<?php
  $langs = array('en'=>'English', 'es'=>'Spanish');
  echo $this->Form->input('User.username', array('size' => 9, 'maxlength' => 9, 'onBlur'=>'this.value=this.value.toLowerCase()', 'label'=>__('Username'), 'class'=>'required'));
  echo '<span style="font-size:7pt;">'.__('At least 5 characters, only lowercase. No spaces.').'</span>';
  echo $this->Form->input('User.email', array('size' => 40, 'maxlength' => 40, 'label'=>__('Email'), 'class'=>'required'));
  echo $this->Form->input('User.group_id', array('label'=> __('Group'), 'options' =>$groups));
  echo $this->Form->input('User.name', array('size' => 40, 'maxlength' => 60, 'label'=>__('Name'), 'class'=>'required'));
  echo $this->Form->input('User.lastname', array('size' => 40, 'maxlength' => 60, 'label'=>__('Lastname'), 'class'=>'required'));
  echo $this->Form->input('User.pwd', array('type'=>'password', 'size'=>10, 'maxlength'=>10, 'value'=>'', 'label'=>__('Password')));
  echo $this->Form->input('Profile.matricula', array('size'=>20,'maxlength'=>20));
  echo $this->Form->input('User.lang', array('label' => __('Language'), 'options' => $langs));
  echo $this->Form->input('User.active', array('type'=>'checkbox', 'label'=> __('Enable user'), 'value'=>'1')); 
  echo $this->Form->end(__('Save')); 
 
  echo '</fieldset>';
?>
<script type="text/javascript">
function validate()
{ 
 var username  = document.getElementById("UserUsername");
 var name      = document.getElementById("UserName");
 var email     = document.getElementById("UserEmail");

 if (username.value.length < 5)
 {
      alert('<?php echo __('Username must have five characters at least');?>');
      username.focus();
      return false;
 }
 if (name.value.length < 4)
 {
      alert('<?php echo __('Name must have eight characters at least');?>');
      name.focus();
      return false;
 }
<?php if (empty($this->data) && !isset($this->data['User']['id'])): ?>
 var pwd       = document.getElementById("UserPwd");
 if (pwd.value.length < 6)
 {
      alert('<?php echo __('Password must have six characters at least');?>');
      pwd.focus();
      return false;
 }
 <?php endif; ?>
 //check email
 var atpos  = email.value.indexOf("@");    //indexOf find something in your JavaScript string
 var dotpos = email.value.indexOf(".");
 //alert('at: ' + atpos);
  
 if ( atpos < 1 || dotpos < 1 || email.value.length < 5) 
 {
      alert('Mmmm, this email ' + email.value + ' does not look as a valid email');
      email.focus();
      return false;
 }
 return true;
}
</script>
