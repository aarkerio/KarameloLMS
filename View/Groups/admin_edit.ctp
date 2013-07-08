<?php 
 # die( debug( $this->data ) ); 
 if ( $this->Session->read('Auth.User.group_id') != 1 ):
      $this->flash('Error, you are not allowed to be here');
 endif;

 echo $this->Form->create('Group',array('onsubmit'=>'return validateData()')); 
 echo $this->Form->hidden('Group.id'); 
?>
<fieldset>
  <legend><?php echo $this->data['Group']['name'] . ' ' .__('group'); ?></legend>   
  <?php 
    echo $this->Form->input('Group.code', array('size'=>7, 'maxlength'=>7)); 
    echo $this->Form->error('Group.code', 'Code is required.'); 
    
    if ( $this->data['Group']['id'] == 4):
        echo $this->Form->label('Group.active', 'Enabled: '); 
        echo $this->Form->checkbox('Group.active', array('value'=>'2')); 
    endif;
    echo $this->Form->end(__('Save')); 
?>
</fieldset>
<script type="text/javascript">
function validateData()
{ 
  var code  = document.getElementById("GroupCode");
  
  if (code.value.length < 6)
  {
    alert('The code must have at least six characters');
    code.focus();
    return false;
  }
  return true;
}
</script>