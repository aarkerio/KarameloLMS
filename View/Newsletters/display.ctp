<?php

echo $this->Html->div('title_portal', __('Newsletters'));

if ( count($data) === 0):
    echo $this->Html->para('notice', __('No published newsletters yet'));
endif;

foreach ($data as $val):
    $tmp  = $this->Html->link($this->Html->image('static/nl_icon.jpeg', array('alt'=>__('Newsletter'), 'title'=>__('Newsletter'))), 
                          '/newsletters/view/'.$val['Newsletter']['id'], array('escape'=>False)) .'<br />';
    $tmp .= $this->Html->link($val['Newsletter']['title'], '/newsletters/view/'.$val['Newsletter']['id']) . '<br />';
    $tmp .= '<span style="font-size:8pt">'. $val['Newsletter']['created'].'</span>';
    echo $this->Html->div(Null, $tmp, array('style'=>'margin-top:35px;'));
endforeach;

 if ( $this->Session->check('Auth.User') ): 
     echo $this->Html->para(Null, __('Tip: you can suscribe/usubscribe to newsletter editing your profile.'), 
          array('style'=>'font-weight:bold;padding:7px;border:1px dotted orange'));
 endif; 

# ? > EOF
