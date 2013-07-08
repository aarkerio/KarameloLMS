<?php
 #debug($data);
 $qdiv    = 'questions'.$question_id; 
 $answers = count($data);
 echo $this->element('answerbutton', array('question_id'=>$question_id, 'qdiv'=>$qdiv, 'answers'=> $answers));
 echo $this->Js->writeBuffer();
# ? > EOF

