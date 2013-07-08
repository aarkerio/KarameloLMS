<?php
#var_dump($correct);
if ( $correct == 1 ):
    $ct = __('Yes');
    $correct   = (string) 'img_correct.gif';
    $incorrect = (string) 'img_incorrect_gray.gif';
else:
    $correct   = (string) 'img_correct_gray.gif';
    $incorrect = (string) 'img_incorrect.gif';
    $ct = 'No';
endif;

echo $this->Html->div(Null, '<b>'.__('Correct'). '</b>: ' .$ct);
echo $this->Html->image('static/'.$correct, array('alt'=> __('Correct'), 'title'=> __('Correct')));
echo $this->Html->image('static/'.$incorrect, array('alt'=> __('Incorrect'), 'title'=> __('Incorrect')));

# ? > EOF