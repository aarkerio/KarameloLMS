<?php 
$this->set('title_for_layout', $data['User']['name']);
echo $this->Html->div('titentry',  __('About me'));
?>
<div style="margin:5px;border:1px dotted gray;padding:13px;">
<?php
  switch($data['User']['group_id'])
  {
  case 1:
        $group = __('Admins');
        break;
  case 2:
        $group = __('Teachers');
        break;  
  case 3:
        $group = __('Students');
        break;  
  case 4:
        $group = __('Parents');
        break;
  }

 echo $this->Html->div(null,$this->Html->image('avatars/'.$data['User']['avatar'], array('alt' => $data['User']['name'], 'title' =>$data['User']['name'])));
 echo  '<b>'.$data['User']['name']    . '</b><br />';
 if ( $group == 'Teachers' || $group == 'Admins' ):
     echo $this->Html->link($data['Profile']['quote'], '/blog/'. $data['User']['username'])  . '<br />';
 else:
     echo '<i>'.$data['Profile']['quote'] .'</i><br />';
 endif;
 echo  __('Group').': '. $group . '<br />';
 echo  $this->Html->para(Null, h(nl2br($data['Profile']['cv'])));  

echo '</div>';

# ? > EOF
