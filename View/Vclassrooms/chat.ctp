<?php
#die(debug($data));
$this->set('title_for_layout', __('vClassroom Chat'));
?>
<style type="text/css">
  #chatters{position:absolute;top:25px;left:500px;border:1px dotted gray;width:200px;padding:4px;}
</style>
<?php
#debug($msgs);
if ( $belongs === True ):
     if ( $data['Vclassroom']['videoconference'] == 1 ):
         echo $this->element('videoconference', array('streaming'=> $data['Vclassroom']['streaming']));
     endif;
     echo $this->Gags->ajaxDiv('message').$this->Gags->divEnd('message');
     echo $this->Html->div(null, $this->Html->image('static/chat_logo.jpg', array('alt'=>'Chat Room', 'title'=>'Chat Room')) .
                ' <br />Chat Room '. $data['Vclassroom']['name'], array('style'=>'font-size:12pt;margin:8px;'));
     $user_id = $this->Session->read('Auth.User.id'); # easier to read and faster
     echo $this->Gags->ajaxDiv('updater');
     echo $this->element('chat_messages', array('msgs'=>$msgs));
     echo $this->Gags->divEnd('updater');
     echo $this->Gags->ajaxDiv('chatters').$this->Gags->divEnd('chatters');
 
     echo $this->Html->div(Null, $this->Session->read('Auth.User.username') .' '. __('writes'));
     echo $this->Gags->imgLoad('loading');
     echo $this->Form->create();
     echo $this->Form->hidden('Chat.vclassroom_id', array('value'=>$data['Vclassroom']['id']));
     echo $this->Form->hidden('Chat.teacher_id', array('value'=>$blogger['User']['id']));
     echo $this->Form->hidden('Chat.student_id', array('value'=>$user_id));
     echo $this->Form->input('Chat.message', array('size'=>60, 'maxlength'=>95, 'title'=>__('Message'), 'between'=>':<br /> ', 'value'=>''));
     echo $this->Js->submit(__('Send'), array('url'         => '/vclassrooms/savemessage/', 
                                                    'update'      => '#updater',
                                                    'evalScripts' => True,
                                                    'before'      =>  $this->Js->get("#loading")->effect('fadeIn',array('buffer'=>False)),
                                                    'complete'    => 'clean();'.$this->Gags->ajaxComplete('updater')));
endif; # belongs
echo $this->Html->scriptStart();
?>
// Load every 5 secs
setTimeout("getChatText(<?php echo $data['Vclassroom']['id']; ?>);",5000);

//$('#loading').show(300);
//$('#updater').hide(0);
//$('#message').hide(0);

// Get student total points 
function getChatText(vclassroom_id) 
{
 $.ajax({
          type : 'POST',
          url :  '/chats/getMessages/',
          data: 
          {
            vclassroom_id : vclassroom_id
          },
          success : function(responseText)
          {
            $('#updater').html(responseText, function() {
                                    $('#updater').fadeIn();
                             });

          }
     });

 setTimeout("getChatText("+vclassroom_id+")",5000);
 setTimeout("sendPing("+vclassroom_id+")",50000);
 //alert('Hi idiot!');
}

function reportError(request)
{
  alert('Sorry. There was an error.');
}

function clean()
{
  var message = document.getElementById('ChatMessage');
  message.value = '';
  return true;
}

// keep the Ping model updated with this user active
function sendPing(vclassroom_id) 
{
 $.ajax({
          type : 'POST',
          url :  '/vclassrooms/ping/',
          data: 
          {
             vclassroom_id : vclassroom_id
          },
          success : function(responseText) 
          {
           $('#chatters').html(responseText, function() {
                                    $('#chatters').fadeIn();
                             });
         }
     });
}
<?php
echo $this->Html->scriptEnd();
echo $this->Js->writeBuffer();
# ? > EOF