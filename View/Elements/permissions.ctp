<?php

 if ( !$permissions['belongs']):
      echo $this->Html->para(null, __('You must be logged in and belongs to this class to see this kandie'));
 endif;

 if ( !$permissions['chkdate']  ): #out of date
     $d = __('Starting date').': <b>'.$dates['sdate'].'</b> <br />'.__('Finish date').': <b>'.$dates['fdate'].'</b><br/> '.
          __('Current time').':  <b>'.date("F d, Y H:i:s", time()).'</b>';
    echo $this->Html->para(null, '<h1>'.__('Out of date').'</h1> '.$d);
    if ( $kandie_user_id == $this->Session->read('Auth.User.id')):
        $img = $this->Html->image('admin/icon_jigsaw.png', array('alt'=>__('Kandies Manager'), 'title'=>__('Kandies Manager'), 'style'=>'margin:0'));
        echo $this->Html->para(Null, 
                              '<b>Tip:</b> '.__('As teacher you can change dates in Kandies Manager') .'. '.__('Click over') .' '.
                               $img .' '.__('in vClassroom screen').'.');
    endif;
 endif;

 if ( $permissions['already']  ): # answered
      echo $this->Html->div('title_section', __('You already eat this Kandie!'));
      echo $this->Html->div(null, $this->Html->image('static/candy-wrappers.jpg', array('alt'=>'Eat!', 'title'=>'Eat!')), array('style'=>'margin:auto;text-align:center'));
 endif;
# ? > EOF