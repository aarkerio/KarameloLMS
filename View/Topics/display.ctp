<?php
#debug($blogger);
$this->set('title_for_layout', $data['Forum']['title']);

echo $this->Html->div('titentry', $this->Html->image('static/forums.png', array('alt'=>__('Forums'), 'title'=>__('Forums'), 'width'=>'22')) .' '.$data['Forum']['title']);
echo $this->Html->para(Null, $data['User']['username'] .' '. __('suggested topic').':<b> '.$data['Topic']['subject'] .'</b>  at <span class="dates">'.$data['Topic']['created'].'</span>');

echo $this->Html->para(null, $this->Html->link($this->Html->image('static/return.jpg', array('alt'=>__('Return to').' '. $data['Forum']['title'], 'title'=>__('Return to').' '. $data['Forum']['title'])), '/forums/display/'. $blogger['User']['username'].'/'.$data['Topic']['forum_id'].'/'.$data['Topic']['vclassroom_id'], array('escape'=>False)));

echo $this->Html->div('titentry', __('Discussion on') .' '.$data['Topic']['subject']);
echo $this->Html->para(Null, '<b>'.__('Discussion topic').':</b> '.$data['Topic']['message']);
 
echo '<div style="padding:2px;margin:10px 5px 10px 5px">';
 
if ( count($data['Reply']) < 1 ):
    echo $this->Html->para(Null, __('No replies yet'), array('style'=>'font-size:16pt;font-weight:bold'));
endif;
 
$int = (int) 1;

foreach ($data['Reply'] as $val):
    if ($val['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
    else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
    endif;
	$i = $int++;
    echo $this->Html->div('reply');
    echo $this->Html->div('replytxt', nl2br(h($val['reply'])));
    if ( $blogger['User']['id'] == $this->Session->read('Auth.User.id')): # you are teacher so delete button
         $msg   = __('Are you sure to want to delete this?'); 
         echo $this->Html->link($this->Html->image('static/delete_icon.png',array('width'=>'16px','alt'=>__('Delete'),'title'=>__('Delete'))),
                                '/admin/replies/delete/'.$val['id'].'/'.$val['topic_id'].'/'.$blogger['User']['username'].'/'.$data['Topic']['forum_id'], 
                                array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)) .'   &nbsp; &nbsp;&nbsp;';
         echo $this->Html->link($this->Html->image($img, array('width'=>'16px', 'alt'=>$st, 'title'=>$st)), 
                          '/admin/replies/change/'.$val['id'].'/'.$val['status'].'/'.$val['topic_id'].'/'.$blogger['User']['username'].'/'.$data['Topic']['forum_id'], array('escape'=>False));
         # buttons upmode downmod for teacher
         if ( $blogger['User']['username'] != $val['User']['username']):
              echo $this->Html->div('points');
              $div_id = 'reply'.$val['id'];
              $img_id = 'img_'.$i;
              echo $this->Gags->imgLoad( $img_id); 
              echo $this->Gags->ajaxDiv($div_id).$val['points'].' '.__('points').'&nbsp;'.$this->Gags->divEnd($div_id);
              echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))),
                           '/admin/replies/record/'.$val['id'].'/down/',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, $img_id),
                              'complete'    => $this->Gags->ajaxComplete($div_id,  $img_id), 
                              'escape'      => False ));

              echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/replies/record/'.$val['id'].'/up/',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, $img_id),
                              'complete'    => $this->Gags->ajaxComplete($div_id,  $img_id), 
                              'escape'      => False ));
		      echo '</div>';
          endif;
      endif;
      echo $this->Html->div('replyuser');
      echo $this->Html->link($val['User']['username'], '/users/about/'.  $val['User']['username']) . ' <b>'.  $i . '.-</b> ';
	  echo $this->Html->link($this->Html->image('avatars/'.$val['User']['avatar'], array('alt'=>$val['User']['username'], 'title'=>$val['User']['username'], 'style'=>'border:1px solid black;width:30px;')), 
                     '/users/about/'.  $val['User']['username'], array('escape'=>False)) .'<br />';
      echo $this->Html->image('static/time.png') .'  '. $this->Time->timeAgoInWords($val['created']);
      echo '</div>';
    echo '</div>';
  endforeach;
echo '</div>';

if ( $belongs === True ):
    echo $this->Html->div('espaciado');
    echo $this->Html->div(null, __('Tema').': '.__('Discussion on') .' '.$data['Topic']['subject']);
    echo $this->Js->link($this->Html->image('static/reply.gif', array('alt'=>__('Reply'), 'title'=>__('Reply'))), 
      '/topics/reply/'.$data['Topic']['vclassroom_id'].'/'.$data['Forum']['id'].'/'.$data['Topic']['id'].'/'.$data['Forum']['user_id'],
                        array('update'      => '#qn',
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore('qn', 'loading3'),
                              'complete'    => $this->Gags->ajaxComplete('qn', 'loading3'), 
                              'escape'      => False ));
    echo $this->Gags->imgLoad('loading3');
    echo $this->Gags->ajaxDiv('qn', array('style'=>'padding:3px')) . $this->Gags->divEnd('qn'); 	              
echo '</div>';
endif;
?>
<style type="text/css">
    .points {margin-right:200px;padding:2px;border:1px dotted gray;width:220px;}
</style>

<?php
echo $this->Html->scriptStart();
?>

function chkReply()
{ 
 var mess = document.getElementById('ReplyReply');

 if (mess.value.length < 5)
 {
      alert('<?php __('Minimum 5 characters long');?>');
      mess.focus();
      return false;
 }
 return true;
}
<?php
echo $this->Html->scriptEnd();
# ? > EOF 
