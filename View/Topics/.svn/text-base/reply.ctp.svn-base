<?php 
 if ( $this->Session->check('Auth.User') ):
     echo $this->Form->create('Reply',              array('action'=>'add', 'onsubmit'=>'return chkReply()'));
     echo $this->Form->input('Reply.topic_id',      array('type'=>'hidden', 'value'=>$topic_id));
     echo $this->Form->input('Reply.vclassroom_id', array('type'=>'hidden', 'value'=>$vclassroom_id));
     echo $this->Form->input('Reply.blogger_id',    array('type'=>'hidden', 'value'=>$blogger_id));
     echo '<fieldset><legend>'. __('New reply').'</legend>';
     echo $this->Form->input('Reply.reply', array('type'=>'textarea','between'=>': <br />','label'=>__('Your participation'),'rows'=>10,'cols'=>50));
     #echo $this->Ck->load('ReplyReply', 'Basic', $this->Session->read('Auth.User.lang'), 600, 300);
     echo $this->Form->end(__('Send'));
     echo '</fieldset>'; 
 endif;

# ? > EOF
