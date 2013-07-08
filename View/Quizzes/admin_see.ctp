<?php
#die(debug($data));
echo $this->Html->div('tit', $data[0]['Test']['title']);
$i = (int) 0;
foreach($data as $v):
   $i++;
   if ( $v['Question']['type'] == 1 ):
       $color = ($v['Answer']['correct'] == 0) ? 'red': 'green';
       $answer = Sanitize::clean($v['Answer']['answer']);
   else:
       $color = ($v['Result']['correct'] == 0) ? 'red': 'green';
       $answer = Sanitize::clean($v['Result']['answer']);
   endif;
   echo $this->Html->div(Null, Null, array('style'=>'padding:5px;margin:6px;border:3px dotted '. $color));
   echo '<b>'. $i . '.- '.__('Question').'</b>: ' . $v['Question']['question'] . '<br />';
   echo '<b>'.__('Points')  .'</b>: ' . $v['Question']['worth'] . '<br />';
   echo  '<b>'.__('Student answer').'</b>: ' . $answer . '<br />';
   if (  $v['Question']['type'] == 1 ):  # multiple or open ?
       $ct = ($v['Answer']['correct'] == 0) ? 'No': __('Yes');
   else:
       $ct = ($v['Result']['correct'] == 0) ? 'No': __('Yes');
   endif;
   if ( $v['Question']['type'] == 2 ): # open question
       echo $this->Gags->ajaxDiv("arrows$i");
       echo $this->Html->div(Null, '<b>'.__('Correct'). '</b>: ' .$ct);
       if ( $v['Result']['correct'] == 1 ):
           $correct   = (string) 'img_correct.gif';
           $incorrect = (string) 'img_incorrect_gray.gif';
           $link_1 = $this->Js->link($this->Html->image('static/'.$incorrect, array('alt'=>__('Incorrect'), 'title'=>__('Incorrect'))),
                           '/admin/tests/points/'.$v['Result']['id'].'/'. $v['Result']['correct'],
                            array('update'      => '#newarrows'.$i,
                                  'evalScripts' => True,
                                  'before'      => $this->Gags->ajaxBefore('arrows'.$i, 'loading'.$i),
                                  'complete'    => $this->Gags->ajaxComplete('newarrows'.$i, 'loading'.$i),
                                  'escape'      => False ));
           $link_2 = $this->Html->image('static/'.$correct, array('alt'=>__('Correct'), 'title'=>__('Correct')));
        else: 
           $correct   = (string) 'img_correct_gray.gif';
           $incorrect = (string) 'img_incorrect.gif';
           $link_1 = $this->Js->link($this->Html->image('static/'.$correct, array('alt'=>__('Correct'), 'title'=>__('Correct'))),
                           '/admin/tests/points/'.$v['Result']['id'].'/'.$v['Result']['correct'],
	                          array('update'      => '#newarrows'.$i,
                                    'evalScripts' => True,
                                    'before'      => $this->Gags->ajaxBefore('arrows'.$i, 'loading'.$i),
                                    'complete'    => $this->Gags->ajaxComplete('newarrows'.$i, 'loading'.$i),
                                    'escape'      => False ));
           $link_2 = $this->Html->image('static/'.$incorrect, array('alt'=>__('Incorrect'), 'title'=>__('Incorrect')));
        endif;
        echo $link_1;
        echo $link_2;
        echo $this->Gags->divEnd("arrows$i");
        echo $this->Gags->ajaxDiv("newarrows$i").$this->Gags->divEnd("newarrows$i");
        echo $this->Gags->imgLoad("loading$i");
    endif; 
    echo '</div>';
endforeach;
# ? > EOF