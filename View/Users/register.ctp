<?php
$this->set('title_for_layout', __('New user'));

if ( $this->Session->check('Auth.User') ):
    echo $this->Html->para(Null, __('You are already a member'));
else:
    echo $this->Html->div('title_portal', __('Registration form'));
?>
<div class="spaced" id="form_register" style="font-size:8pt;">
    <?php echo $this->Form->create('User', array('action'=>'register', 'onsubmit'=>'return validateData()')); ?>
<fieldset>
  <legend><?php __('New user'); ?></legend>     
  <?php echo $this->Form->input('User.username', array('size' => 10, 'maxlength' => 10, 'class'=>'required', 'onBlur'=>'this.value=this.value.toLowerCase()')); ?>
  <span class="small"><?php __('At least 5 characters, only lowercase. No spaces.');?></span>
     <div><br /></div>
  <?php echo $this->Form->input('User.pwd', array('type'=>'password', 'class'=>'required', 'label'=>__('Password'), 'value'=>'', 'size'=>9,'maxlength'=>9)); ?>
  <span class="small"><?php __('At least 6 characters'); ?></span>
 <?php
   echo $this->Html->div(Null, '<br />');
   echo $this->Form->input('User.name', array('size'=>25,'maxlength'=>50,'class'=>'required', 'label'=>__('Name and last name')));
  
   echo $this->Html->div(Null, '<br />');
   echo $this->Form->input('User.matricula', array('size'=>20,'maxlength'=>20, 'title'=>__('If you are student, write your matricula number')));

   echo $this->Html->div(Null, '<br />');
   echo $this->Form->input('User.email', array('size' => 25, 'maxlength' => 45, 'class'=>'required', 'label'=>__('Email'))); 
    
   echo $this->Html->div(Null, '<br />');
   echo $this->Form->input('User.group_id', array('type'=>'select', 'label'=> __('Group'))); 
    
   echo $this->Html->div(Null, '<br />');
   echo $this->Form->input('User.code', array('size'=>7,'maxlength'=>7, 'class'=>'required','title'=>__('Contact school to get your register code')));
        
    $tmp = $this->Html->link(__('I read and I do agree with terms'),'#header',
	                                array('onclick'=>"javascript:window.open('/colleges/terms', 'blank', 'toolbar=no, scrollbars=yes,width=700,height=400')")) . ' ';
    echo $this->Form->input('User.agree', array('type'=>'checkbox', 'label' =>$tmp));

    echo $this->Html->div(Null, '<br />');
    echo '</fieldset>';
    echo $this->Form->end(array('value'=>__('Send')));
?>
</div>
<?php
echo $this->Html->para(Null,$this->Html->link(__('Please contact webmaster if you have doubts or comments about this registration process'), '/colleges/contact', array('target'=>'_blank')));
?>

<script type="text/javascript">
function validateData()
{ 
 var pwd       = document.getElementById("UserPwd");
 var name      = document.getElementById("UserName");
 var username  = document.getElementById("UserUsername");
 var email     = document.getElementById("UserEmail");
 var agree     = document.getElementById("UserAgree");  

 if (username.value.length < 5)
 {
   alert('Username must have five letters at least');
   username.focus();
   return false;
 }

 var regex = /^[a-zA-Z]+[a-zA-Z0-9\.\_]*[a-zA-Z0-9]+$/;

 if(!regex.test(username.value))
 {
      alert('No special characters in username');
      username.focus();
      return false;
 }

 if (name.value.length < 5)
 {
   alert('Name must have five letters at least');
   name.focus();
   return false;
 }

 var space = username.value.indexOf(" ");
  
 //alert('at: ' + atpos);
  
 if ( space > 0 ) 
 {
   alert('Username can not contain spaces');
   username.focus();
   return false;   
 }  

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

 if (agree.checked == false)
 {
   alert('You must do agree');
   return false;
 }
 
 return true;
}
</script>
<?php
endif;
# ? > EOF
