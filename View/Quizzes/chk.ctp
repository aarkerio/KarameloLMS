<div style="font-size:18pt;padding:5px;boder:1px solid #c0c0c0"> <?php echo $blog["User"]["username"]; ?>'s Exam</div>

<?php
//die(print_r($data));
if ( $this->Session->check('Auth.User') )
{
 echo '<h1>'. $data['Test']['title'] . '</h1>';
 echo $this->Html->para(null, $data['Test']['description']);

 echo $this->Form->create('Test', array('action'=>'chk', 'onsubmit'=>'return validateNew()')); 
 echo $this->Form->hidden('Test.id', array("value"=>$data['Test']['id']));

 foreach ($data['Question'] as $val):
    //exit(var_dump($val));
    echo '<div>';
    echo '<div style="font-size:14pt;margin:5px 0 6px 0">' . $val['question'] .' '. $val['worth']  .'</div>'; 
    
    $options = array();

    foreach ($val["Answer"] as $v):
         $options[$v['id']] = $v['answer'];
    endforeach;

    echo $this->Html->radio('Question/answer'.$val['id'], $options, '<br />');

    echo '<br /><b>Hint</b>: <i>' .  $val['hint']  . '</i><br /><br />';
    echo '</div>';
 endforeach;

 echo $this->Form->end('Send');

 echo '<br />';

 echo $this->Html->formTag('/tests/view/'.$data['Test']['id'].'/'.$data['Test']['user_id'],'post'); 
 echo $this->Html->hidden('Test/id', array("value"=>$data['Test']['id']));
 echo $this->Html->submit('<< return');
 echo '</form>';
}
else
{
  echo '<p>You must be logged to see this exam</p>';
}



