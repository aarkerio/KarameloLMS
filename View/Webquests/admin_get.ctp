<?php
$textarea = (bool) True;
# generic form elements
echo $this->Form->create();  
echo $this->Form->hidden('Webquest.id', array('value'=>$id));
echo $this->Form->hidden('Webquest.section', array('value'=>$section));
echo '<fieldset>';
 
#*** SWITCH 
switch ($section):
   case 'introduction':
      echo '<legend>'.__('Introduction').'</legend>';
      echo $this->Form->input('Webquest.introduction', array('cols'=>50, 'rows'=>10, 'value'=>$field, 'type'=>'textare', 'label'=>False));
      $WebTextArea = 'WebquestIntroduction';
      break;
 
   case 'tasks':
      echo '<legend>'. __('Tasks'). '</legend>';
      echo $this->Form->input('Webquest.tasks', array('cols'=>50, 'rows'=>10, 'value'=>$field, 'type'=>'textarea', 'label'=>False));
      $WebTextArea = 'WebquestTasks';
      break;
 
   case 'process':
      echo '<legend>'.__('Process').'</legend>';
      echo $this->Form->input('Webquest.process', array('cols'=>50, 'rows'=>10, 'value'=>$field, 'type'=>'textarea', 'label'=>False));
      $WebTextArea = 'WebquestProcess';
      break;
 
   case 'roles':
      echo '<legend>Roles</legend>';
      echo $this->Form->input('Webquest.roles', array('cols'=>50, 'rows'=>10, 'value'=>$field, 'type'=>'textarea', 'label'=>False));
      $WebTextArea = 'WebquestRoles';
      break;
 
   case 'evaluation':
      echo '<legend>'.__('Evaluation').'</legend>';
      echo $this->Form->input('Webquest.evaluation', array('cols'=>50, 'rows'=>10, 'value'=>$field, 'type'=>'textarea', 'label'=>False));
      $WebTextArea = 'WebquestEvaluation';
      break;
 
   case 'title':
       echo '<legend>'. __('Title, points and Knet'). '</legend>';
       echo $this->Form->input('Webquest.title',  array('size'=>40, 'maxlength'=>80, 'label'=>__('Title'))).'<br />';
       echo $this->Form->input('Webquest.points', array('options'=>range(0,20)));
       echo $this->Form->input('Webquest.knet',   array('type'=>'checkbox', 'label' => __('Share in Knet')));
       $textarea = False;
       break;
 
   case 'conclusion':
       echo '<legend>'. __('Conclusion').'</legend>';
       echo $this->Form->input('Webquest.conclusion', array('type'=>'textarea', 'cols'=>50, 'rows'=>10, 'value'=>$field, 'label'=>False));
       $WebTextArea = 'WebquestConclusion';
endswitch;
 
 echo '<div style="clear:both"></div>';

 $params = array('url'         => '/admin/webquests/get',
                 'update'      => '#setform',
                 'evalScripts' => True,
                 'before'      => $this->Gags->ajaxBefore('setform'),
                 'complete'    => $this->Gags->ajaxComplete('setform'));

 echo $this->Js->submit(__('Save'), $params);
 ?>
 </fieldset>
 </form>
</div>

<?php echo $this->Html->scriptStart(); ?>
 
function validateNew()
{ 
  var title = document.getElementById('WebquestTitle');
  //alert('I am here');
  if (title.value.length < 3)
  {
    alert('The title must have three letters at least');
    title.focus();
    return false;
  }

return true;
}
<?php
 echo $this->Html->scriptEnd(); 

 if ( $textarea ): #??
     echo $this->Html->scriptBlock("checkExistence('$WebTextArea')");
 endif;
 
 echo $this->Js->writeBuffer();

# ? > EOF
