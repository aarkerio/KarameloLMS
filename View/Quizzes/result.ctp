<style type="text/css">
 .explanation{
 padding:5px;
 border:1px solid gray;
 margin:5px;
}
</style>
<?php
$this->set('title_for_layout', __('Test Results'));

#die(debug($answers));

if (  $permissions['already'] === True ):
    echo $this->Html->para('message',$this->Session->read('Auth.User.username') .' '. __('You have already answered this test'));
endif;

if ( $open_question ):
    __('You have already answered this test');
endif;
 
if (  $permissions['belongs'] === True and  $permissions['already'] === False):
   echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$vclassroom_id));
   echo '<h2>' .$this->Session->read('Auth.User.username') .'\'s ' . __('results').'</h2>';
   echo $this->Html->div('result', __('Percentage success').': '.$data['percentage'].'%');
   echo $this->Html->para(Null, __('Your result was').' : <b>'.$data['results'].'</b> '.__('from').' '.$data['maxpoints'] .' '.__('possible score. Result has been saved, Thanks').'!');
   foreach($answers as $q):
           echo $this->Html->div('explanation');
           echo $this->Html->div(Null,  '<b>'.__('Question')    .':</b>  '. $q['Question']['question']);
           if ( strlen($q['Question']['hint']) > 2 ):
               echo $this->Html->para(Null, '<b>'.__('Hint')    .':</b>  '. $q['Question']['hint']);
           else:
               echo $this->Html->para(Null, '<b>No '.__('Hint') .'</b>   ');
           endif;
           echo $this->Html->div(Null,  '<b>'.__('Explanation') . ':</b> '. $q['Question']['explanation']);
           if ( $q['Question']['type'] == 2 ): # open question
               echo $this->Html->para('title_section', __('Open question: waiting evaluation'));
           endif;  
           echo '</div>';
   endforeach;
   
   if ( $open_question ):
       echo $this->Html->para('message', __('Note that this quizz test have open question with pending evaluation'));
   endif;
else:
    echo $this->Html->para(Null, __('You must be logged in and belongs to this class to see this section'));
endif;

# ? > EOF
