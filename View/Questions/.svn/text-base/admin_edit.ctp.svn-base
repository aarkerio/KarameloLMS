<?php 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled
 echo $this->Form->create('Question');
 echo $this->Form->input('Question.id', array('type'=>'hidden'));
 echo $this->Form->input('Question.test_id', array('type'=>'hidden','value'=>$this->request->data['Question']['test_id']));
 echo $this->Form->input('Question.save', array('type'=>'hidden','value'=>'True'));
 echo '<fieldset><legend>'. __('Edit question') .'</legend>';
 echo $this->Gags->helps('Write the question to student', $helps);
 echo $this->Form->input('Question.question', array('size' => 60, 'maxlength' => 120, 'class'=>'required', 'label'=>__('Question'))); 
 
 echo $this->Gags->helps('You can give a hint to student about the question, if do not want left this field empty', $helps);
 echo $this->Form->input('Question.hint', array('size'=> 40,'maxlength' => 120, 'label'=>__('Hint'))); 

 echo $this->Gags->helps('Briefly rite the right answer to the question in order to give feedback to student, student can see this explanation only after hi/she finished the test', $helps);
 echo $this->Form->input('Question.explanation', array('cols' => 50, 'rows' => 5,  'class'=>'required','label'=> __('Explanation'))); 

 echo $this->Gags->helps(__('Assign a value to question'), $helps);
 echo $this->Form->input('Question.worth', array('options'=>range(0,10), 'label' => __('Points'))); 

 echo $this->Gags->helps('Here you can choice between an open answer or multiple choice', $helps);
 echo $this->Form->input('Question.type', array('options'=> array('1'=>__('Multiple choice'), '2'=>__('Open question')), 'label' => __('Question type'))); 

 echo $this->Js->submit(__('Save'), array(
                'url'      => '/admin/questions/edit/',
 	            'update'   => "#questions",
	            'before'   => $this->Gags->ajaxBefore('questions'),
 	            'complete' => $this->Gags->ajaxComplete('questions')
 	        ));
 echo '</form></fieldset>';
 echo $this->Js->writeBuffer();
# ? > EOF
