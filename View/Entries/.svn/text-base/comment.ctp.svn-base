<?php
# Display comments Chipotle Software (c) 2006-2011 
#debug($data);
if ( isset($captcha) ):
    echo $this->Html->div(Null, __('Captcha fails, try again'), array('style'=>'color:red;font-weight:bold;'));
else:
   
    if ($data['Comment']['user_id'] == 2): #comment was wrote for anonymous user id=2
        $user = $this->Html->image('avatars/'.$data['User']['avatar'], 
                                   array('alt'=>$data['Comment']['username'],'title'=>$data['Comment']['username'],'style'=>'width:20px'));
        if (strlen($data['Comment']['website']) > 7 and (strlen(strstr($data['Comment']['website'],'http://')) > 0)): # websited typed
            $user .= ' ' . $this->Html->link($data['Comment']['username'], h($data['Comment']['website']));
        else:
            $user .= ' ' . h($data['Comment']['username']);
        endif;         
    else:
         $user  = (string) $this->Html->link($data['User']['username'],  '/users/about/'.$data['User']['username']).' ';
         $user .= $this->Html->link($this->Html->image('avatars/'.$data['User']['avatar'],array('alt'=>$data['User']['username'],'title'=>$data['User']['username'], 
                       'style'=>'width:20px')), '/users/about/'.$data['User']['username'], array('escape'=>False));
    endif;
    echo '<div style="border:2px dotted #e2e2e2;margin:15px 0 15px 0;padding:8px;background-color:#fff"><b>'.$user.'</b> wrote: <br />';
    echo $this->Html->para(null, nl2br(h($data['Comment']['comment']))); #we do not wanna hacks so escape comments
    echo '<span class="small" style="font-size:7pt;font-weight:bold;">' . $data['Comment']['created'] . '</span></div>';
    echo $this->Html->scriptBlock("$('#aform').fadeOut()");
endif;
# ? > EOF