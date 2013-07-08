<?php
#debug($msgs);
$user_id = $this->Session->read('Auth.User.id'); # easier to read and faster
$msgs = array_reverse($msgs); # invert order
foreach ($msgs as $m):
    $msg   =  clickable($m['Chat']['message']);
    $color = $m['User']['id'] == $user_id ? 'green' : 'orange';
    echo $this->Html->div(Null, 
               '<span style="color:'.$color.';font-size:8pt;">'.$this->Time->timeAgoInWords($m['Chat']['created']). ' '.$m['User']['username'].'</span>: '.
                $msg, 
               array('style'=>'font-size:11pt;'));
endforeach;

function clickable($url)
{
  $url  = Sanitize::html($url);
  $url  =  str_replace("\\r","\r",$url);
  $url  =  str_replace("\\n","\n<BR>",$url);
  $url  =  str_replace("\\n\\r","\n\r",$url);

  $in   = array(
        '`((?:https?|ftp)://\S+[[:alnum:]]/?)`si',
        '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
        );
  $out  = array(
        '<a href="$1"  rel=nofollow>$1</a> ',
        '<a href="http://$1" rel=\'nofollow\'>$1</a>'
        );
  return preg_replace($in,$out,$url);
}

# ? > EOF
