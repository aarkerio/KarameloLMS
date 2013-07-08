<?php
#debug($data);
if ($data['Annotation']['user_id'] == 2): #comment was typed for not logged user
    $user = $this->Html->image('avatars/'.$data['User']['avatar'], array('alt'=>$data['Annotation']['username'],'title'=>$data['Annotation']['username'], 'style'=>'width:20px'));
    if ( strlen($data['Annotation']['website']) > 11):
        $user .= ' ' . $this->Html->link($data['Annotation']['username'], h($data['Annotation']['website']));
    else:
        $user .= ' ' . h($data['username']);
    endif;         
else:
    $user = $this->Html->link($data['User']['username'], '/users/about/'.$data['User']['username']).' '. 
            $this->Html->link($this->Html->image('avatars/'.$data['User']['avatar'], 
                       array('alt'=>$data['User']['username'],'title'=>$data['User']['username'], 'style'=>'width:20px')), 
                        '/users/about/'.$data['User']['username'], array('escape'=>False));
endif;    
echo '<div style="border:2px dotted #e2e2e2;margin:15px 0 15px 0;padding:8px;background-color:#fff"><b>'.$user.'</b> '.__('wrote').': <br />';
echo $this->Html->para(Null, nl2br(h($data['Annotation']['comment']))); 
echo '<span class="small" style="font-size:7pt;font-weight:bold;">' . $data['Annotation']['created'] . '</span></div>';
echo '<div>';

# ? > EOF
