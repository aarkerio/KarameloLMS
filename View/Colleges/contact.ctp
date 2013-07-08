<?php 
echo $this->set('title_for_layout', __('Contact'));
echo $this->Html->div('title_portal', __('Contact'));
echo $this->Html->script(array('ckeditor/ckeditor','jquery.form', 'jquery.CKEditor', 'ckeditor/adapters/jquery'));
echo $this->Gags->imgLoad('charging');
echo $this->Gags->ajaxDiv('updater', array('style'=>'margin:6px;padding:7px;'));

echo $this->Form->create(); 
?>
<fieldset>
  <legend><?php __('Request Info'); ?></legend>
  <?php 
  $salute = array('Mr.' => 'Mr.', 'Mrs.'=>'Mrs.', 'Miss' => 'Miss', 'Dr.'=>'Dr.', 'Fellow'=>'Fellow');
  echo $this->Form->input('College.title', array('type'=>'select','label' => __('Title'),'options'=> $salute)); 
  echo $this->Form->input('College.name',  array('size' => 30, 'maxlength' => 40, 'class'=>'required'));
  echo $this->Form->input('College.email', array('size' => 20, 'maxlength' => 45));
  echo $this->Form->input('College.body',  array('type'=>'textarea', 'cols'=>15, 'rows'=>5, 'label'=>False));
  echo $this->Html->scriptBlock("$('textarea#CollegeBody').ckeditor({ toolbar:'Basic', width:400, height:200 });");
  echo $this->Js->submit(__('Send'), array(
                                          'url'         => '/colleges/fromoutside/', 
                                          'update'      => '#updater',
                                          'evalScripts' => True,
                                          'before'      => 'return chkForm();'.$this->Gags->ajaxBefore('updater', 'charging'),
                                          'complete'    => $this->Gags->ajaxComplete('updater', 'charging') )); 

?>
</fieldset>
</form>
<?php 
 echo $this->Gags->divEnd('updater');
?>
<script type="text/javascript">
function chkForm()
{ 
  var name  = document.getElementById('CollegeName');
  var email = document.getElementById('CollegeEmail');
  if (name.value.length < 3)
  {
    alert('The name must have five characters at least');
    name.focus();
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
  return true;
}
</script>