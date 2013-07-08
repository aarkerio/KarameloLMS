<?php 
#die(debug($this->data));

$AnswerDiv    = 'answers'.$this->data['Question']['id'];

echo $this->Form->create();
echo $this->Form->input('Answer.id', array('type'=>'hidden'));
echo $this->Form->input('Answer.question_id', array('type'=>'hidden','value'=>$this->data['Question']['id']));
echo '<fieldset><legend>'. __('Edit answer') .'</legend>';
echo $this->Form->input('Answer.answer', array('size'=>50, 'maxlength'=>120, 'class'=>'required', 'label'=>__('Answer')));
echo $this->Form->input('Answer.correct', array('type'=>'checkbox', 'label'=>__('Answer is correct'))); 

 echo $this->Js->submit(__('Save'), array(
                'url'      => '/admin/answers/edit/',
 	            'update'   => "#$AnswerDiv",
	            'before'   => $this->Gags->ajaxBefore($AnswerDiv),
 	            'complete' => $this->Gags->ajaxComplete($AnswerDiv)
 	        ));
 echo '</form></fieldset>';
 echo $this->Js->writeBuffer();
 
# ? > EOF
