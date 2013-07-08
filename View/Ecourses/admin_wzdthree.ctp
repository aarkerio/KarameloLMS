<?php 
  $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
  echo $this->Form->create('Ecourse', array('url'=>$this->here)); 
?>
<fieldset>
 <legend><?php __('Step Three'); ?></legend>
<?php
  echo $this->Html->div('wizard');
     echo $this->Html->para(Null, __('This is the last step in order to create a new eCourse')); 
     echo $this->Html->para(Null, __('ecourse wizard 8'));
     echo $this->Html->para(Null, __('ecourse wizard 9'));
     echo $this->Html->para(Null, __('ecourse wizard 10'));
  echo '</div>';

  echo $this->Form->input('Ecourse.syllabus', array('type'=>'textarea', 'cols'=>80, 'rows'=>17, 'label' => __('Syllabus')));    

  echo $this->Gags->helps('Describe aqui los objetivos del curso', $helps);
  echo $this->Form->input('Ecourse.references', array('type'=>'textarea', 'cols'=>80, 'rows'=>7, 'label' => __('References')));
  echo $this->Form->input('Ecourse.share', array('type'=>'checkbox', 'label'=> __('Shared'), 'value'=>'1', 'title'=>__('Shared'))); 
  echo $this->Form->input('Ecourse.status', array('type'=>'checkbox', 'value'=>'1', 'label' => __('Published'), 'title'=>__('Enabled'))); 

  echo $this->Form->end(__('Next') .'>>');
  echo '</fieldset>';

# ? > EOF
