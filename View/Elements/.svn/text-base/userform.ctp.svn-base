<?php
/**
 * This form is used for edit all users (c) 2006-2012
 */
#debug( $this->request->data );
if ($this->request->data['User']['id'] != $this->Session->read('Auth.User.id')):   # Security check
    echo $this->__getSupport();
endif;

echo $this->Html->para(Null, $this->Html->image('avatars/'.$this->request->data['User']['avatar'], array('alt'=>$this->request->data['User']['username'], 'title'=>$this->request->data['User']['username']))); 

echo $this->Form->create('User', array('onsubmit'=>'return chkForm()'));
echo $this->Form->hidden('User.id');
echo $this->Form->hidden('Profile.id');
echo $this->Form->hidden('User.email');
echo $this->Form->input('Profile.modified', array('type'=>'hidden', 'value'=>'now()'));
echo $this->Form->input('Profile.userform', array('type'=>'hidden', 'value'=>'1'));
echo '<fieldset>';
echo '<legend>'.$this->Session->read('Auth.User.username') .'\'s '.__('profile').'</legend>';
echo $this->Html->div(Null, '<b>'.$this->request->data['User']['email'].'</b>');
echo $this->Form->input('User.name', array('size' => 35, 'maxlength'=>50)); 
    
$langs = array('en'=>'English', 'es'=>'Español');
echo $this->Form->input('User.lang', array('type'=>'select', 'options'=>$langs, 'label'=> __('Language')));

echo $this->Form->input('Profile.cv', array('type'=>'textarea','cols' => 70, 'rows' => 7, 'label'=> __('profile')));
echo $this->Form->input('Profile.phone', array('size' => 35, 'maxlength'=>50, 'label'=>__('Phone')));
echo $this->Form->input('Profile.cellphone', array('size' => 35, 'maxlength'=>50, 'label'=>__('Cell Phone')));
echo $this->Form->input('Profile.matricula', array('size'=>20,'maxlength'=>20,'title'=>__('If you are student, write your matricula number')));

if ( $this->Session->read('Auth.User.group_id') < 3):  # admin and teachers
    echo $this->Form->input('Profile.quote', array('size' => 70, 'maxlength' => 150, 'label'=>__('Quote')));
    echo $this->Form->input('Profile.name_blog', array('size' => 45, 'maxlength' => 150, 'label'=>__('eduBlog name')));
    echo $this->Form->input('Profile.tags', array('size' => 45, 'maxlength' => 150, 'label'=>'Tags'));
    $styles = array('mexico'=>'México', 'basic'=>'Basic');
    echo $this->Form->input('Profile.layout', array('type'=>'select', 'options'=>$styles, 'label'=>__('Layout')));
endif;

echo $this->Form->input('Profile.newsletter', array('type'=>'checkbox', 'label'=> __('Subscribe to newsletter')));
echo $this->Form->input('User.helps', array('type'=>'checkbox', 'label'=> __('Enable help messages'))); 
echo $this->Form->input('User.editor', array('type'=>'checkbox', 'label'=> __('Enable HTMl editor')));

echo $this->Html->div(Null, $this->Form->input('User.pwd', array('size'=>9, 'maxlength'=>9, 'value'=>'', 
      'label'=>__('Password'))) . '  '.__('Left empty if you do not want to change'), array('style'=>'clear:both;margin:25px 0 16px 0;'));
echo '</fieldset>';
echo $this->Form->end(__('Save'));

echo $this->Html->div('spaced');
echo $this->Form->create('User', array('enctype'=>'multipart/form-data', 'action'=>'avatar'));
echo $this->Form->hidden('User.id'); 
?>
<fieldset>
<legend><?php __('Upload new avatar'); ?></legend>
<?php
 echo $this->Html->div(Null, __('An image 50 x 50 pixels'));
 echo $this->Form->input('User.file', array('type'=>'file')); 
 echo '</fieldset>';
 echo $this->Form->end(__('Upload'));
 echo '</div>';
 
 # JS
 echo $this->Html->scriptStart(); 
?>
function chkForm()
{ 
  var name      = document.getElementById("UserName");
  var passwd    = document.getElementById("UserPwd");
  
  if (name.value.length < 6)
  {
    alert('<?php __('The name must be at least six characters');?>');
    name.focus();
    return false;
  }
  
  if (passwd.value.length > 0  && passwd.value.length < 6)
  {
    alert('<?php __('The password must be at least five characters');?>');
    passwd.focus();
    return false;
  }
 
return true;
}
<?php 
  echo $this->Html->scriptEnd(); 
# ? > EOF
