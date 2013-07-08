<?php
//die(debug($test));

$test_assigned = array();

foreach ( $test as $v)
{
    $test_assigned[$v['Test']['id']] = $v['Test']['id']; // tests already linked with this classroom
}

echo $this->Html->div('title_section', $data['Vclassroom']['name']); 


if ( count($data) < 1)
{
  echo "You don't have any test defined yet";
}
else
{
   foreach ($test as $val)
   {
     if ( !in_array($val['Test']['id'], $test_assigned) )
     {
       echo $this->Html->div(null, 
                       'The exam <b>'.$val['Test']['title'].'</b> is already assigned to class <i>'.$data['Vclassroom']['name'].'</i>');
     }
     else
     {
       $tmp  =  'Test:' . $val['Test']['title'];
       $tmp .=  $this->Form->create('Vclassroom', array('action'=>'linktest'));
       $tmp .=  $this->Form->hidden('TestVclassroom.test_id', array('value'=>$val['Test']['id'])); 
       $tmp .=  $this->Form->hidden('TestVclassroom.vclassroom_id', array('value'=>$data['Vclassroom']['id']));
       $tmp .=  $this->Form->end('Assign this test to this class');
                      
       echo $this->Html->div('divblock', $tmp);
     }
   }
}
?>