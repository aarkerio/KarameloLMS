<?php
 $new_answer = 'Answer'.$qdiv;
 echo $this->Gags->ajaxDiv($new_answer);           
      
 $lbl = __('View answers').'   ('.$answers.')';
 echo $this->Form->create($new_answer);
 echo $this->Form->input('Question.question_id', array('type'=>'hidden', 'value'=>$question_id));
 echo $this->Js->submit($lbl, array(
                'url'      => '/admin/questions/answers/',
 	            'update'   => "#$new_answer",
	            'before'   => $this->Gags->ajaxBefore($new_answer),
 	            'complete' => $this->Gags->ajaxComplete($new_answer)
 	        ));
 echo '</form>';

 echo $this->Gags->divEnd($new_answer); 
  
# ? > EOF

