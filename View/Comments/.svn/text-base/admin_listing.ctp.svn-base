<?php
#die(debug($data));
echo $this->set('title_for_layout', __('Comments'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb(__('Entries'), '/admin/entries/listing'); 
echo $this->Html->getCrumbs(' > '); 
       
echo $this->Html->div('title_section', __('Comments in your eduBlog'));

echo $this->Gags->imgLoad('loadingComment'); #loading image

echo $this->Gags->ajaxDiv('noComm');
if ( count($data) < 1 ):
  echo '<h1>'.__('No comments yet') .'</h1>';
endif;
echo $this->Gags->divEnd('noComm');

$msg   = __('Are you sure to want to delete this?');

$commId[] = ''; #For print a line when the entry is different from the past entry
$i = 1;
$j = 1;

echo $this->Gags->ajaxDiv('message').$this->Session->flash().$this->Gags->divEnd('message');

echo $this->Gags->ajaxDiv('commentList');
echo $this->Session->flash();

#pagination sort
if ( count($data) > 2):
    echo '<div>';
    echo __('Sort by').': &nbsp;';
    echo  $this->Paginator->sort('Comment.created',__('Created')). '&nbsp; | &nbsp;';
    echo  $this->Paginator->sort('Entry.title',__('Entry')). '&nbsp; | &nbsp;';
    echo  $this->Paginator->sort('Comment.status',__('Status'));
    echo '</div>';
endif;
#end of pagination sort

foreach($data as $v):

      $commId[$i] = $v['Comment']['entry_id'];
     
      if ($commId[$i] != $commId[$i-1]):
        $j++;
        echo "<hr class='showHr' />";
      endif;

     if ($j%2 == 0):
         echo "<div class='showComment1'>";
     else:
         echo "<div class='showComment2'>";
     endif;

      echo $this->Gags->ajaxDiv('adcom'.$v['Comment']['id'].''); #Ajax Div adcom[CommentId]
      echo $this->Html->div('adminblock');
      if ( $v['Comment']['status'] == 1 ):
          $st = __('Published');
          $img   = 'static/status_1_icon.png';
      else:
          $st = __('Hidden');
          $img   = 'static/status_0_icon.png';
      endif;

      if ($v['User']['id'] == 2): # comment was typed for a non registered (anonymous) user
          $email   = h($v['Comment']['email']);
          $website = h($v['Comment']['website']);
          $user  = $this->Html->image('avatars/'.$v['User']['avatar'], 
                                array('alt'=>$v['Comment']['username'],'title'=>$v['Comment']['username'])) . ' ';
          $user  .= '<b>'.$v['Comment']['username'] . '</b><br />';
          if (strlen($email) > 5 and (strlen(strstr($email,'@')) > 0)):
              $user .= '<b>Email</b> '.$this->Html->link($email, $email) .'<br />';  
          endif;
          if (strlen($website) > 7 and (strlen(strstr($website,'http://')) > 0)):
              $user .= '<b>Site:</b> '.$this->Html->link($website, $website) .'<br /><br />';  
          endif;
      else:
            $user = $this->Html->link(
                  $this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['User']['username'], 'title'=>$v['User']['username'])), 
                  '/users/about/'.$v['User']['username'],
                  array('target'=>'_blank', 'escape'=>False));
            $user  .= ' '.$v['Comment']['username'];
      endif;

      #Start the block
      echo __('Entry') . ': '.$this->Html->link($v['Entry']['title'], '/entries/view/'.$this->Session->read('Auth.User.username').'/'.$v['Entry']['id'], array('target'=>'_blank')) . '<br /><br />';
      echo $user . ' ' . __('wrote') . ':<br />';
      echo $this->Html->para(Null, nl2br(h($v['Comment']['comment'])));
      echo $this->Html->div(Null, $v['Comment']['created'], array('style'=>'font-size:7pt;margin:4px'));
      $link_change = '/admin/comments/change/'.$v['Comment']['id'].'/'.$v['Comment']['status'].'/'.$this->Paginator->current().'/'.$this->Paginator->sortKey().'/'.$this->Paginator->sortDir();
      $link_delete = '/admin/comments/delete/'.$v['Comment']['id'];
    
      #Link for change the state
      echo $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)),$link_change, array('escape'=>False));
      echo ' &nbsp;&nbsp;&nbsp;';
      #Link for delete
      echo $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px','alt'=>__('Delete'), 'title'=>__('Delete'))),
                             $link_delete,  array('confirm'=>"$msg", 'escape' => False)) . '<br /> '; 
      #End Link for delete
   
      echo '</div>'; #End of adminblock
      echo $this->Gags->divEnd('adcom'.$v['Comment']['id'].''); #End of adcom[CommentId] 
      echo "</div>"; #End for showCommentX

      $i++; 
endforeach;


if ( count($data) > 0 ):
    echo $this->Html->div('pagination');
    echo $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    echo $this->Html->div(null,$this->Paginator->next(__('Next').' »',Null, Null, array('class'=>'disabled')),array('style'=>'width:100px;float:right'));
     echo $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
endif;
echo $this->Gags->divEnd('commentList'); #End for the listing of comments

echo '</div>';

# ? > EOF