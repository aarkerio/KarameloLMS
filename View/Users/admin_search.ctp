<?php
$msg =  !isset($words) ? __('Search for users') : __('Users founded') ;

echo $this->Html->div('title_section', $msg);

echo $this->Html->div(Null, Null, array('style'=>'width:200px;float:center;'));
  echo '<fieldset>';
  echo '<legend>'.__('Search user').'</legend>';
  echo $this->Form->create('User', array('action'=>'search'));
  echo $this->Form->input('User.words', array('size'=>30, 'maxlength'=>30, 'label'=>__('Name or email or matricula')));
  echo $this->Form->end(__('Search'));
  echo '</fieldset>';
echo '</div>';

if ( isset($words) && !$data ):
    echo $this->Html->para(null, __('Your search'). ' <b>- '.$words.' -</b> '.__('did not match any data'));
endif;

if ( isset($data) ):
   echo '<table class="main_tabula" style="width:100%;font-size:7pt;">';
   $msg   = __('Are you sure to want stealth this account?');
   $th = array(__('Edit'), 'Username', 'Matricula', __('Name'), __('Created'),  __('Stealth account'),
  'Email', __('Status'), __('Compose'), __('Group'), __('Delete'));

   echo $this->Html->tableHeaders($th, array('style'=>'text-align:center')); 
 
   foreach ($data as $val):
      $del    = ($this->Session->read('Auth.User.group_id')  == 1) ? $this->Gags->confirmDel($val['User']['id'], 'users')   : ''; # only admins can delete
      $edit   = ($this->Session->read('Auth.User.group_id')  == 1) ? $this->Gags->sendEdit($val['User']['id'], 'users', 'add')   : '';
      if ($val['User']['active'] == 1):
          $alt = __('Actived');
          $img   = 'static/status_1_icon.png';
      else:
          $img   = 'static/status_0_icon.png';
          $alt = __('Desactived');
      endif;
      if ( $this->Session->read('Auth.User.id') !=  $val['User']['id'] ):
          $stealth = $this->Html->link($this->Html->image('static/icon_key.gif', array('title'=>__('Stealth account'),'alt'=>__('Stealth account'))),
                                       '/admin/users/activities/'.$val['User']['id'], array('onclick'=>"return confirm('".$msg."')", 'escape'=>False));
      else:
          $stealth = '';
      endif;
      $tr = array (
		  $edit,
		  $val['User']['username'],
          $val['Profile']['matricula'],
          $val['User']['name'],
          $val['Profile']['created'],
          $stealth,
          $this->Html->link($val['User']['email'],  'mailto:'.$val['User']['email']),
          $this->Html->link($this->Html->image($img, array('alt'=>$alt, 'title'=>$alt)), '/admin/users/change/'.$val['User']['id'].'/'.$val['User']['active'], array('escape'=>False)),
          $this->Html->link($this->Html->image('admin/compose_on.gif', array('alt'=>__('Compose'), 'title'=>__('Compose'))), 
                        '/admin/messages/add/'. $val['User']['username'], array('escape'=>False)),
          $val['Group']['name'],
		  $del
		 );
      echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
 
echo '</table>';
endif;
?>

