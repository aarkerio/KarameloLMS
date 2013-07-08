<?php
#die(debug($data));
#debug(Debugger::trace());
$this->set('title_for_layout', $data['Lesson']['title']);
echo '<h1>'  .$data['Lesson']['title']   . '</h1>';
echo $this->Html->div(Null,__('This lesson has been seen').' '.$data['Lesson']['visits'].' '. __('times'), array('style'=>'text-align:right;margin:10px 0;font-size:7pt;'));

echo $this->Html->div('printbutton', 
      $this->Html->link($this->Html->image('static/icon_print.png', array('alt'=>__('Print this page'),'title'=>__('Print this page'))),'#', 
     array('onclick'=>"window.open('/lessons/selfprint/".$data['Lesson']['id']."', '_blank','toolbar=no, scrollbars=yes,width=800,height=800'); return false;",
           'escape'=>False)));

echo $this->Html->div(Null, $data['Lesson']['body']);
echo $this->Html->div(Null, __('Last edition'). ': '.$data['Lesson']['created']);
 
if (  $data['Lesson']['disc'] == 1 ):   # is the comments in this lesson actived by blogger?
   if ( $this->Session->check('Auth.User') ):  # if user logged, anchor to textarea
       echo  $this->Html->div(Null, $this->Html->image('static/comment.gif', array('alt'=>'Annotations')) . 
                        ' '. __('Comments').':', array('id'=>'comments'));  
   else:
       echo '<div id="comments">'.$this->Html->image('static/comment.gif',array('alt'=>'Annotations')) .' '.__('Annotations');
       echo ' :<a style="font-size:7pt" href="#new_comment">&gt;&gt;</a></div>';
   endif;
        
   $k = 1;
   # lop to show comments     
   foreach ($data['Annotation'] as $v): 
     $bg = ($k%2==0) ? '#e2e2e2' : '#fff';
     if ($v['user_id'] == 2): #comment was typed for not logged user
         $user = $this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['username'],'title'=>$v['username'], 'style'=>'width:20px'));
         if ( strlen($v['website']) > 11):
             $user .= ' ' . $this->Html->link($v['username'], h($v['website']));
         else:
             $user .= ' ' . h($v['username']);
         endif;         
     else:
         $user = $this->Html->link(
                      $v['User']['username'], 
                      '/users/about/'.$v['User']['username']).' '. 
            $this->Html->link($this->Html->image('avatars/'.$v['User']['avatar'], 
                       array('alt'=>$v['User']['username'],'title'=>$v['User']['username'], 'style'=>'width:20px')), 
                        '/users/about/'.$v['User']['username'], array('escape'=>False));
     endif;    
     echo '<div style="border:2px dotted #e2e2e2;margin:15px 0 15px 0;padding:8px;background-color:'.$bg.'">';
     echo $k++ . '.- <b>' . $user  . '</b> '.__('wrote').': <br />';
     echo $this->Html->para(Null, nl2br(h($v['comment'])));          
     echo '<span class="small" style="font-size:7pt;font-weight:bold;">' . $v['created'] . '</span>';

     # Teacher buttons
     if ( $this->Session->read('Auth.User.id') && $blogger['User']['id'] == $this->Session->read('Auth.User.id')): # you are teacher so delete button
          echo $this->Html->div(Null);
          $msg   = __('Are you sure to want to delete this?'); 
          if ($v['status'] == 1):
             $img   = 'static/status_1_icon.png';
	         $st    = __('Published');
	      else:
             $img   = 'static/status_0_icon.png';
	         $st    = __('Draft');
          endif;
          $msg   = __('Are you sure to want to delete this?'); 
          echo $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 'title'=>__('Delete'))), 
                           '/admin/annotations/delete/'.$v['id'],
                                 array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)) .'   &nbsp; &nbsp;&nbsp;';	
          echo $this->Html->link($this->Html->image($img, array('width'=>'16px', 'alt'=>$st, 'title'=>$st)), 
                           '/annotations/change/'.$v['id'].'/'.$v['status'].'/'.$blogger['User']['username'].'/'.$data['Lesson']['id'], array('escape'=>False));
          echo '</div>';
     endif;
     echo '</div>';
   endforeach;
   echo '<div>';
   echo $this->Gags->ajaxDiv('aform');
   echo $this->Form->create(Null, array('onsubmit'=> 'return chkData();'));
   echo $this->Form->input('Annotation.lesson_id',  array('type'=>'hidden','value'=> $data['Lesson']['id']));
   echo $this->Form->input('Annotation.blogger_id', array('type'=>'hidden','value'=> $data['Lesson']['user_id']));
   if ( $this->Session->check('Auth.User') ):
?>     <fieldset>
       <legend id="new_comment"><?php __('New Comment');?></legend>
       <?php
       echo $this->Form->hidden('Annotation.user_id',  array('value' => $this->Session->read('Auth.User.id')));
       echo $this->Form->hidden('Annotation.username', array('value' => $this->Session->read('Auth.User.username')));
       echo $this->Session->read('Auth.User.username') . ' '.  __('writes') .' ';     
   else:
       # Show captcha if anonymous user and discussion is enabled
       # debug($this->Session->read());
       echo $this->Html->image($this->webroot.'annotations/captcha/', array('id'=>'captcha', 'alt'=>'CAPTCHA Image'));
       $lbl = (string) __('All letters are vowels');
       echo $this->Form->input('Annotation.captcha',  array('size'=>10, 'maxlength'=>10, 'between'=>':<br />', 'label'=>$lbl));
       echo $this->Form->input('Annotation.username', array('size'=>10, 'maxlength'=>15, 'between'=>':<br />'));
       echo $this->Form->input('Annotation.email',    array('size'=>30, 'maxlength'=>60, 'between'=>':<br />', 'label'=>__('Email (is not showed)')));
       echo $this->Form->input('Annotation.website',  array('size'=>40, 'maxlength'=>120,'between'=>':<br />', 'value'=>'http://'));
   endif;
  
   echo $this->Form->input('Annotation.comment', array('rows'=>10,'cols' => 50, 'label'=> False)); 

   echo $this->Js->submit(__('Publish'), array(
                               'url'         => '/annotations/add/', 
                               'update'      => '#updater',
                               'evalScripts' => True,
                               'before'      => $this->Gags->ajaxBefore('updater'),
                               'complete'    => $this->Gags->ajaxComplete('updater'). $this->Js->get('#aform')->effect('fadeOut', array('buffer' => False))
));

   echo '</fieldset>'; 
   echo $this->Gags->divEnd('aform');
 echo '</div>';
 echo $this->Gags->imgLoad();
 echo $this->Gags->ajaxDiv('updater').$this->Gags->divEnd('updater');
 endif;
 
 echo '<div id="toTop">^ Back to Top</div>'; 
 # JS Starts
 echo $this->Html->scriptStart(); 
 ?>
 $(function() 
 {
    $(window).scroll(function() 
    {
        if ($(this).scrollTop() != 0)
        {
           $('#toTop').fadeIn();
        } else {
          $('#toTop').fadeOut();
        }
   });

   $('#toTop').click(function()
   {
      $('body,html').animate({scrollTop:0},800);
   });
  });

function chkData()
{ 
  var name     = document.getElementById("AnnotationUsername");
  var comment  = document.getElementById("AnnotationComment");
  var captcha  = document.getElementById("AnnotationCaptcha")
  // alert('I am here');
 
  if (captcha.value.length < 3)
  {
      alert('<?php echo __('You must type CAPTCHA'); ?>');
      name.focus();
      return false;
  }

  if (name.value.length < 3)
  {
      alert('<?php echo __('The name must have at least three letters'); ?>');
      name.focus();
      return false;
  }

  if (comment.value.length < 3)
  {
      alert('<?php  echo __('The comment must have at least three letters');?>');
      comment.focus();
      return false;
  }
   return true;
}
<?php
echo $this->Html->scriptEnd();
# ? > EOF
