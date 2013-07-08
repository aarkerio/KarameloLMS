<?php
#die(debug($data)); 
$this->set('title_for_layout', __('FAQs'));

echo $this->Html->div('title_section', $this->Html->image('faq.png', array('title'=>'FAQs', 'alt'=>'FAQs')).' '.$blogger['User']['username'].'\'s FAQs');

foreach ($data as $val):
   echo '<div style="border:1px dotted gray;padding:4px;margin-bottom:15px">';
       echo $this->Html->link($val['Catfaq']['title'], '/catfaqs/view/'.$blogger['User']['username'].'/'.$val['Catfaq']['id'], 
          array('style'=>'font-size:14pt;font-weight:bold;')) . '<br />';
       echo '<b>'.__('Description').'</b>: <i>' .  $val['Catfaq']['description']  . '</i><br />';
    echo '</div>';
endforeach;

# ? > EOF

