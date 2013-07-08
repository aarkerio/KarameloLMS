<?php
#debug($msgs);
$username =  $this->Session->read('Shout.username'); # easier to read and faster
$msgs = array_reverse($msgs); # invert order
foreach ($msgs as $m):
    $msg   =  clickable($m['Shout']['message']);
    $color = $m['Shout']['username'] == $username ? 'green' : 'orange';
    echo $this->Html->div(Null, 
               '<span style="color:'.$color.';font-size:7pt;">'.$this->Time->timeAgoInWords($m['Shout']['created']). ' '.$username.'</span>: '.
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
