<?php
echo $this->Html->div('sideelement');
echo $this->Html->div('sidemenu', 'Quickvote');
echo $this->Gags->imgLoad('loading');
echo $this->Gags->ajaxDiv('add_pollrow');
$poll = $this->requestAction('polls/poll');
$poll_id = $this->Session->read('poll_id');
#die(debug($poll));
$question =  $this->Html->para('negrita', $poll['Poll']['question'], array('style'=>'text-align:left;'));
if ( $poll_id != Null &&  $poll['Poll']['id'] == $poll_id): # the user has already voted, so show poll results
    $total_votes = (int) 0;
    # build array      
    foreach ($poll['Pollrow'] as $val):
         $total_votes += $val['vote'];  # the total votes
    endforeach;
    echo $question;
    
    foreach ($poll['Pollrow'] as $val):        
          if ( $val['vote'] > 0 ):
              $percent = ($val['vote'] * 100) / $total_votes;  # % = votes * 100 / total
          else:
              $percent = 0;
	      endif;
          $width   = number_format($percent, 0);
          echo $this->Html->div(null, '<b>'.$val['answer'].'</b> '.number_format($percent, 2).'% <br />'. 
                          $this->Html->image('static/poll/'.$val['color'].'.png',array('height'=>10,'width'=>$width,'alt'=>$val['answer'])).'  '.$val['vote'],
                          array('style'=>'text-align:left;'));
     endforeach;
     echo $this->Html->para('negrita', __('Total votes').':' . $total_votes); 
 else: # the user has no voted, print the form
     echo $this->Form->create(Null, array('default' => False));
     $options   = array();
     echo $question;
     echo $this->Form->input('Pollrow.poll_id', array('type'=>'hidden', 'value'=>$poll['Poll']['id']));  # Poll_id
     foreach ($poll['Pollrow'] as $val):
         $options[$val['id']] = $val['answer'];  # construct id->value 
     endforeach;
     #debug($options);
     echo '<span style="font-size:7pt;margin:0;padding:0;">';
     # print the answers
     echo $this->Form->input('Pollrow.id', array('options'=> $options, 'type'=>'radio', 'separator'=>'<br />', 'legend'=>False));
     echo '</span>';
    
     echo $this->Js->submit(__('Vote'), array('url'         => '/pollrows/vote',
                                                    'update'      => '#add_pollrow',
                                                    'evalScripts' => True,
                                                    'before'      => $this->Gags->ajaxBefore('add_pollrow'),
                                                    'complete'    => $this->Gags->ajaxComplete('add_pollrow') ));
     echo '</form>';
  endif;
echo $this->Gags->divEnd('add_pollrow');

echo '</div>';
