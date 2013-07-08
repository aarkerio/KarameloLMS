<?php
$entries = $this->requestAction('entries/lastEntries');

echo $this->Html->div('sideelement');
if ( count($entries) > 0):
    echo $this->Html->div('sidemenu', 'Edublogs');
endif;

foreach ($entries as $val):
    echo $this->Html->div(null, $this->Html->link($val['Entry']['title'], 
                          '/entries/view/'.$val['User']['username'].'/'.$val['Entry']['id']) . 
                           ' <span style="font-size:6pt">'.$val['User']['username'].'</span>', 
                           array('style'=>'margin-top:4px;padding-left:2px')
                    );
endforeach;

echo '</div>';

# ? > EOF