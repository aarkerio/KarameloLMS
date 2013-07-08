<?php 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled
 if (isset($this->Js)):
      echo $this->Html->script('jquery-validate/jquery.validate');
 endif;
 $this->Html->addCrumb('Control Panel', '/admin/entries/start');
 $this->Html->addCrumb(__('Polls'), '/admin/polls/listing');
 echo $this->Html->getCrumbs(' > ');

 echo $this->Form->create('Poll'); 
?>
<fieldset>
<legend><?php __('New poll'); ?></legend>
 <?php 
echo $this->Form->input('Poll.question', array('size' => 60, 'maxlength'=>90, 'class'=>'required'));
  ?>
  <div style="margin:15px auto 15px auto;border:1px dotted gray;padding-left:40px;width:80%;">

<?php 
for ($i=1;$i<10;$i++):
    $params =  array('size' => 50, 'maxlenght'=>100, 'label'=> __('Answer') . ' '.$i);
    if ( $i < 3):
        $params['class'] = 'required';
    endif;
    echo $this->Form->input('Pollrow.answer'.$i, $params);
endfor;
?>
</div>

<?php 
echo $this->Form->input('Poll.status',  array('label'=> __('Published'), 'type'=>'checkbox', 'value'=>'1')); 
 echo $this->Html->para(Null,$this->Form->end(__('Save'))); 
?>
</fieldset>
<script language="javascript">
 /* <![CDATA[ */
   $(document).ready(function() {
               $("#PollAddForm").validate();
   });
 /* ]]> */
</script>
