<?php
$this->set('title_for_layout',  __('Write New Message'));

$helps = $this->Session->read('Auth.User.helps'); # helps enabled
echo $this->Html->script(array('jquery-plugins/simpleAutoComplete'));
echo $this->Html->css('autocomplete'); 

echo $this->Html->div('barra', __('Compose new message'));
echo $this->Form->create('Message', array('action'=>'deliver','onsubmit'=>'return validateForm()')); 
?>
<fieldset>
<legend><?php __('Write Message');?>:</legend>
<?php 
echo $this->Form->input('Message.sendername', array('label'=>__('Send message to').': '));
echo $this->Form->input('Message.title', array('size'=>25, 'maxlength'=>50));
echo $this->Form->input('Message.body', array('type'=>'textarea', 'cols'=>50, 'rows'=>10, 'between'=>'<br />','label'=>__('Message')));
echo '</fieldset>';
echo $this->Form->end(__('Send'));

echo $this->Html->scriptStart(); 
?>
$(document).ready(function() {
        $("#MessageSendername").simpleAutoComplete('/messages/autocomplete/');
    });

function validateForm()
{ 
  var title     = document.getElementById("MessageTitle");
  var body      = document.getElementById("MessageBody");
  var email     = document.getElementById("MessageEmail");
 
  if (name.value.length < 5)
  {
    alert('Name must have five letters at least');
    name.focus();
    return false;
 
  }

  if (username.value.length < 5)
  {
    alert('Username must have five letters at least');
    username.focus();
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
<?php 
 echo $this->Html->scriptEnd();
# ? > EOF

