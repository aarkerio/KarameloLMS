<?php
/**
 *  OneEntry Element, display entries in edublog or single entry with comments
 *  Affero GPLv3 Chipotle Software (c) 2006-2012
 *  package: blog
 */
# Cause I'm a lazy ass!!
$discussion =  (int) $val['Entry']['discussion'];
$entry_id  =  (int) $val['Entry']['id'];
$user_id   =  (int) $val['Entry']['user_id'];
$cmts      =  (string) __('Comments');
$img_icon  =  (string) $this->Html->image('static/comment.gif', array('alt'=>$cmts, 'title'=>$cmts));
#$img_pdf   =  $this->Html->image('static/gnome-pdf.gif', array('alt'=>__('Export as PDF'), 'title'=>__('Export as PDF'))); 
#$pdfURL=  $img_pdf.' '.$this->Html->link(__('Export as PDF'), '/entries/renderpdf/'.$blogger['User']['username'].'/'.$entry_id, array('style'=>'font-size:7pt')); #Create PDF

echo $this->Html->div('titentry',   $this->Html->link($val['Entry']['title'], '/entries/view/'.$blogger['User']['username'].'/'.$entry_id)); 
echo $this->Html->div('redaction', 'From the <b>'.$val['Subject']['title'].'</b> dept. On '. $val['Entry']['created']);
echo $this->Html->div('body_entry', $this->Gags->clean($val['Entry']['body']));

$url = (string) '/entries/view/'.$blogger['User']['username'].'/'.$entry_id;   # URL to current entry
$pl  = (string) 'http://' . $_SERVER['HTTP_HOST'] . $url;              # permalink
# $pdfURL=  $img_pdf.$this->Html->link(__('Export as PDF'), '/entries/renderpdf/'.$blogger['User']['username'].'/'.$entry_id, array('style'=>'font-size:7pt')); #Create PDF render link

echo $this->Html->div('plink', 'Permalink: '. $this->Html->link($pl, $pl));

if ( $comments === False):   # this is not a single entry, is the blog frontend
    if ( $discussion == 1 ):  # comments enabled
         $num_coment = (int) count($val['Comment']);
         if ( $num_coment > 0 ):
             $tmp = $img_icon.'&nbsp;'.$this->Html->link($num_coment.' '.$cmts, $url, array('style'=>'font-size:7pt'));
         else:
             $tmp = $img_icon;
         endif;
         echo $tmp.$this->Html->link(__('Write your comment'),$url,array('style'=>'font-size:7pt;padding-left:5px')).'&nbsp;&nbsp;<br />';
    endif;
else: # this is a single entry, so print comments and set comment form
    if ( $discussion == 1 ):  # is the comments in this entry actived by blogger?
        echo $this->Html->div(null, $img_icon .' '.$cmts, array('id'=>'comments'));

        $k = (int) 1;
        # lop to show comments     
        foreach ($val['Comment'] as $v):  
            $bg = ($k%2==0) ? "#e2e2e2" : "#fff";
            if ($v['user_id'] == 2): #comment was wrote for anonymous user id=2
                $user = $this->Html->image('avatars/'.$v['User']['avatar'], 
                                 array('alt'=>$v['username'],'title'=>$v['username'], 'style'=>'width:20px'));
                if (strlen($v['website']) > 7 and (strlen(strstr($v['website'],'http://')) > 0)): # websited typed
                    $user .= ' ' . $this->Html->link($v['username'], h($v['website']));
                else:
                    $user .= ' ' . h($v['username']);
                endif;         
            else:
                $user  = (string) $this->Html->link($v['User']['username'],  '/users/about/'.$v['User']['username']).' ';
                $user .= $this->Html->link($this->Html->image('avatars/'.$v['User']['avatar'],  
                                  array('alt'=>$v['User']['username'],'title'=>$v['User']['username'], 
                       '          style'=>'width:20px')), '/users/about/'.$v['User']['username'], array('escape'=>False));
            endif;    
            echo '<div style="border:2px dotted #e2e2e2;margin:15px 0 15px 0;padding:8px;background-color:'.$bg.'">'.$k++.'.- <b>'.$user.'</b> wrote: <br />';
            echo $this->Html->para(Null, nl2br(h($v['comment']))); #we do not wanna XSS so escape comments
            echo '<span class="small" style="font-size:7pt;font-weight:bold;">' . $v['created'] . '</span>';
            if ( $this->Session->check('Auth.User') and  $this->Session->check('Auth.User.id') == $blogger['User']['id']):  # teacher see his/her own blog
                $msg   = __('Are you sure to want to delete this?');
                echo $this->Html->div(Null);
                echo $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'),'title'=>__('Delete'))), 
                                 '/admin/comments/delete/'.$v['id'].'/'.$entry_id.'/'. $blogger['User']['username'],
                                       array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)) . '&nbsp;';
                echo $this->Html->link($this->Html->image('static/status_1_icon.png', array('width'=>'16px', 'alt'=>__('Hide'),'title'=>__('Hide'))), 
                                 '/admin/comments/change/'.$v['id'].'/'.$v['status'].'/1/id/up/'.$entry_id.'/'. $blogger['User']['username'],array('escape'=>False));
                echo '</div>';
            endif;
            echo '</div>';
        endforeach;
        # form
        echo $this->Gags->ajaxDiv('aform');
        echo $this->Form->create();
        echo $this->Form->create('Comment', array('action'=>'add'));
        echo $this->Form->hidden('Comment.entry_id', array('value'=>$entry_id));
        echo $this->Form->hidden('Comment.blogger_id', array('value'=> $val['Entry']['user_id']));
        if ( $this->Session->check('Auth.User') ):   # user is logged in ?> 
            <fieldset>
            <legend id="new_comment"><?php echo __('New Comment'); ?></legend>
            <?php
            echo $this->Session->read('Auth.User.username') . ' '.  __('writes') .' ';
        else:
            # show captcha if anonymous user and discussion is enabled
            #debug($this->Session->read());
            # echo $this->Html->image($this->webroot.'comments/captcha/', array('id'=>'captcha', 'alt'=>'CAPTCHA Image'));
            $tmp  = $this->Html->image('/comments/securimage/', array('id'=>'captcha_img', 'alt'=>'CAPTCHA Image')) . '<br />';
            $tmp .= $this->Html->image('static/icon_reload.gif', array('onclick'=>"document.getElementById('captcha_img').src = '/comments/securimage/'; return false", 'id'=>'captcha_reload',  'title'=>'Refresh CAPTCHA', 'alt'=>'Refresh CAPTCHA'));
            $tmp .= $this->Form->input('Comment.captcha', array('id'=>'captcha_text','size'=>10,'maxlenbgth'=>10, 'between'=>':<br />','label'=>__('Enter characters showing up')));
            echo $this->Html->div(Null, $tmp, array('id'=>'captcha_container'));
            
            echo $this->Form->input('Comment.username',array('size'=>10,'maxlenbgth'=>15, 'between'=>':<br />','label'=>__('Name')));
            echo $this->Form->input('Comment.email',   array('size'=>30,'maxlenbgth'=>60, 'between'=>':<br />','label'=>__('Email (is not showed)')));
            echo $this->Form->input('Comment.website', array('size'=>40,'maxlenbgth'=>120,'between'=>':<br />','value'=>'http://', 'label'=>__('Website (optional)')));
        endif;
        echo $this->Form->input('Comment.comment', array('type'=>'textarea', 'rows' => 10,'between'=>':<br />', 'cols' => 50));
        echo '</fieldset>';
        echo $this->Js->submit(__('Send'), array('url'         => '/comments/add/', 
                                                 'update'      => '#updater',
                                                 'evalScripts' => True,
                                                 'before'      => $this->Gags->ajaxBefore(False, 'charging'),
                                                 'complete'    => $this->Gags->ajaxComplete('updater', 'charging')
                                  	        ));
        echo $this->Gags->divEnd('aform');
	echo $this->Gags->ajaxDiv('updater').$this->Gags->divEnd('updater');
    echo $this->Gags->imgLoad('charging');
endif; # comments enabled

echo $this->Html->scriptStart();
?>
function chkForm()
{ 
  var title   = document.getElementById("CommentComment");

  if (title.value.length < 2)
    {
      alert('Comment too short');
      title.focus();
      return false;
    }

  return true;
}
<?php 
  echo $this->Html->scriptEnd(); 
endif; #comments = True
# ? > EOF
