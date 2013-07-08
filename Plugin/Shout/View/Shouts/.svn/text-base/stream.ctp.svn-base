<?php

$this->set('title_for_layout', 'Sesiones Médicos');

echo $this->Html->script(array('jwplayer'));
echo $this->Html->image('imgusers/mmontoya_272.jpg', array('alt'=>'INCANtv', 'title'=>'INCANtv'));
?>

<style type="text/css">
     #updater{border:1px dotted gray;width:400px;padding:6px;}
     #chatters{position:absolute;top:25px;left:500px;border:1px dotted gray;width:200px;padding:4px;}
 </style>
<div style="width:1200px;float:left;">
<div style="width:600px;float:left;">
<div id='mediaspace'>This text will be replaced</div>
 
<div style="margin:20px;">
<script type='text/javascript'>
     jwplayer('mediaspace').setup({
             'flashplayer': '/files/flash/player.swf',
                 'file': '<?php echo $session_id; ?>.flv',
                 'streamer': 'rtmp://132.248.116.4/oflaDemo/',
                 'controlbar': 'bottom',
                 'width': '570',
                 'height': '390'
                 });
</script>
</div>
</div>
<div style="width:600px;float:left;">
<?php
$username = $this->Session->read('Shout.username');
echo $this->Gags->ajaxDiv('message').$this->Gags->divEnd('message');
echo $this->Html->div(Null, $this->Html->image('static/chat_logo.jpg', array('alt'=>'Shout Room', 'title'=>'Shout Room')) .
                                       ' <br />Chat Sesiones', array('style'=>'font-size:12pt;margin:8px;'));
$user_id = $this->Session->read('Auth.User.id'); # easier to read and faster
echo $this->Gags->ajaxDiv('updater');
echo $this->element('Shout.shout_messages', array('msgs'=>$msgs));
echo $this->Gags->divEnd('updater');
echo $this->Gags->ajaxDiv('chatters').$this->Gags->divEnd('chatters');
 
echo $this->Html->div(Null, $this->Session->read('Auth.User.username') .' '. __('writes'));
echo $this->Gags->imgLoad('loading');
echo $this->Form->create();
echo $this->Form->hidden('Shout.session_id', array('value'=>$session_id));
echo $this->Form->hidden('Shout.username',   array('value'=>$username));
echo $this->Form->input('Shout.message', array('size'=>60, 'maxlength'=>95, 'title'=>__('Message'), 'between'=>':<br /> ', 'value'=>''));
echo $this->Js->submit(__('Send'), array('url'         => '/shout/shouts/savemessage/', 
                                         'update'      => '#updater',
                                         'evalScripts' => True,
                                         'before'      =>  $this->Js->get("#loading")->effect('fadeIn',array('buffer'=>False)),
                                         'complete'    => 'clean();'.$this->Gags->ajaxComplete('updater')));

echo '</div></div>';
echo $this->Html->scriptStart();

?>

// Load every 5 secs
setTimeout("getShoutText('<?php echo $session_id; ?>');",5000);

//$('#loading').show(300);
//$('#updater').hide(0);
//$('#message').hide(0);

// Get student total points
function getShoutText(session_id)
{
 $.ajax({
         type : 'POST',
        url :  '/shout/shouts/getMessages/',
         data:
        {
            session_id : session_id
         },
         success : function(responseText)
         {
           $('#updater').html(responseText, function() {
                                  $('#updater').fadeIn();
                           });
         }
    });

 setTimeout("getShoutText('"+session_id+"')",5000);
 //setTimeout("sendPing("+session_id+")",50000);
 //alert('Hi idiot!');
}

 function reportError(request)
 {
   alert('Sorry. There was an error.');
 }

 function clean()
 {
    var message = document.getElementById('ShoutMessage');
    message.value = '';
    return true;
  }

// keep the Ping model updated with this user active
 function sendPing(session_id)
 {
    $.ajax({
            type : 'POST',
             url :  '/shout/shouts/pings/',
             data:
            {
             session_id : session_id
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

