<?php
/**  GPLV3 
  Chipotle Software (c) 2002-2010 
**/
#exit(print_r( $poll ));
$total_votes = (int) 0;
  
foreach ( $poll['Pollrow'] as $val ):
    $total_votes += $val['vote'];  # the total votes
endforeach;
  
echo $this->Html->para('negrita', $poll['Poll']['question'], array('style'=>'text-align:left;'));
  
foreach ($poll['Pollrow'] as $val):          
    if ($val['vote'] > 0 ):
        $percent = ($val['vote'] * 100) / $total_votes;  # % = votes * 100 / total
    else:
        $percent = 0;
    endif;
    $width   = number_format($percent, 0);
    $msg=$this->Html->image('static/poll/'.$val["color"].'.png', array('height'=>10, 'width'=>$width,'alt'=>$val['answer'], 'title'=>$val['answer']));
    echo $this->Html->para(Null,'<b>'.$val['answer'].'</b> '.number_format($percent, 2).'% <br />'.$msg. '  '. $val['vote'],array('style'=>'text-align:left;'));
endforeach;
  
echo $this->Html->para('negrita', 'Total votes:' . $total_votes , array('style'=>'text-align:left;'));
?>