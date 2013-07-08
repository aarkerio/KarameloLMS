<?php
#die(debug($data));
$this->set('title_for_layout', __('Subject'));

echo $this->Html->div('title_portal', $data['S']['Subject']['title']. ' '. $data['S']['Subject']['code']);

if ( count($data['Lesson']) < 1 ):
    echo $this->Html->para(null, __('There still are not any lesson for this subject'), array('style'=>'font-weight:bold;font-size:11pt;'));
else:
    echo $this->Html->div('title_portal', __('Lessons'));
endif;

foreach($data['Lesson'] as $l):
    echo $this->Html->link('► '.$l['Lesson']['title'], '/lessons/view/'.$l['User']['username'].'/'.$l['Lesson']['id']). '<br />';
endforeach;

echo '<br /><br />';

if ( count($data['Entry']) < 1 ):
    echo $this->Html->para(null, __('There still are not any entry for this subject'), array('style'=>'font-weight:bold;font-size:11pt;'));
else:
    echo $this->Html->div('title_portal', __('Entries'));
endif;

foreach($data['Entry'] as $e):
    echo $this->Html->link('► '.$e['Entry']['title'], '/entries/view/'.$e['User']['username'].'/'.$e['Entry']['id']). '<br />';
endforeach;

echo '<br /><br />';

if ( count($data['Share']) < 1 ):
    echo $this->Html->para(null, __('There still are not any share for this subject'), array('style'=>'font-weight:bold;font-size:11pt;'));
else:
    echo $this->Html->div('title_portal', __('Shares'));
endif;

foreach($data['Share'] as $s):
    echo $this->Html->link('► '.$s['Share']['description'], '/shares/download/'.$s['Share']['secret']). '<br />';
endforeach;
# ? > EOF