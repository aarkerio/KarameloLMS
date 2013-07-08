<?php
$data = $this->requestAction('catfaqs/blogElement/'.$blogger['User']['id']);
if ( $data ):
   echo $this->Html->div('temas', 'FAQs');
   foreach ($data as $val):
       echo '► '.$this->Html->link($val['Catfaq']['title'], 
                         '/catfaqs/view/'.$blogger['User']['username'].'/'. $val['Catfaq']['id'], array('class'=>'petit')) . '<br />';
   endforeach;
   echo $this->Html->para(Null, $this->Html->link(__('View all FAQs'), '/catfaqs/display/'.$blogger['User']['username'], array('class'=>'petit')));
endif;
# ? > EOF
