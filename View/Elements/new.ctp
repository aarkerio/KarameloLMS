<?php
/**
 * 2006-2013 (c) Chipotle Software Affero GPLv3
 * View one News element
 */
#die(debug($data));
echo $this->Html->div('news_title', $this->Html->link($data['News']['title'], '/news/view/'. $data['News']['id']));

echo $this->Html->div('redaccion', __('from_dep').'<i> '.$data['Theme']['theme'].'</i>, posted by '.$this->Html->link($data['User']['username'], '/users/about/'.$data['User']['username']).' on '. $data['News']['created']); 

echo $this->Html->div('bodynew');
echo $this->Html->div('img_new', $this->Html->link(
                $this->Html->image('themes/'.$data['Theme']['img'],array('alt'=>$data['Theme']['theme'], 'title'=>$data['Theme']['theme'], 'class'=>'themes')), 
		        '/news/category/' .$data['News']['theme_id'], array('escape'=>False)));
 
if ( $comments ):
   echo $this->Gags->clean($data['News']['body']); 
else:
    $bodyText = preg_replace('=\(.*?\)=is', '', $data['News']['body']);
    $bodyText = $this->Text->truncate($bodyText, 400, array(
                                                            'ending' => '...',
                                                            'exact'  => True,
                                                            'html'   => True,
                                                            ));
    echo $bodyText; 
endif;

    
echo $this->Html->para(Null,'<span style="font-size:7pt;">Permalink:</span><br /> '.$this->Html->link(
			   'http://'.$_SERVER['HTTP_HOST'].'/news/view/'.$data['News']['id'], 
                           'http://'.$_SERVER['HTTP_HOST'].'/news/view/'.$data['News']['id'])); 

if ( strlen($data['News']['reference'])  > 10) :
    echo $this->Html->para(Null, __('Reference') .': '. $this->Html->link($this->Html->image('static/newwindow.gif',
                                     array('alt'=>__('Open new window'), 'title'=>__('Open new window'))),
                           '#',
                           array('escape'=>False, 'onclick'=>"window.open('".$data['News']['reference']."', '_help', 
                           'status,scrollbars,resizable,width=800,height=600,left=10,top=10,menubar,toolbar')")));
endif;
      
echo $this->Html->div('socialnets', $this->News->socialNets($data['News']['id'], $data['News']['title'])); # Social nets buttons

if ( $comments  ): #enabled when calling CakePHP element
    if ( $data['News']['comments'] == 1 ):  # comments in this new are enabled ??
        $i = (int) 1;
        echo '<div id="cnews">';
        foreach($data['Discussion'] as $v):
            #debug($v);
            $bg = ($i%2 == 0) ? '#e2e2e2' : '#fff';
            if ($v['User']['id'] == 2): #comment was wrote for anonymous user id=2
                $user = $this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['User']['username'],'title'=>$v['User']['username'], 'style'=>'width:20px'));
                if (strlen($v['website']) > 7 and (strlen(strstr($v['website'],'http://')) > 0)): # websited typed
                   $user .= ' ' . $this->Html->link($v['name'], h($v['website']));
                else:
                   $user .= ' ' . h($v['name']);
               endif;         
            else:
                $user  = (string) $this->Html->link($v['User']['username'],  '/users/about/'.$v['User']['username']).' ';
                $user .= $this->Html->link($this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['User']['username'],'title'=>$v['User']['username'], 
                                                              'style'=>'width:20px')), '/users/about/'.$v['User']['username'], array('escape'=>False));
           endif;   

           $tmp  = $user . '<br />'.$this->Html->div(Null,$this->Html->image('static/time.png', array('alt'=>'Time')).' '.$this->Time->timeAgoInWords($v['created']),
                                         array('style'=>'font-size:8pt;font-family:Georgia;'));
           $tmp .= $this->Html->para(Null, h($v['comment']));

           echo $this->Html->div('divblock', $tmp, array('style'=>'background-color:'.$bg));
           $i++;
        endforeach;
        echo '</div><!-- cnews ends -->';

        # Comment zone beggins
        echo $this->Html->div('divblock');
        echo $this->Form->create('Discussion', array('action'=>'add', 'onsubmit'=>'return chkForm();'));
        echo $this->Form->hidden('Discussion.new_id',  array('value'=>$data['News']['id']));
        ?>
        <fieldset>
        <legend><?php __('Write comment'); ?></legend>
        <?php
        if ( !$this->Session->check('Auth.User') ): # user is not logged in
            echo $this->Html->image('/comments/securimage/', array('id'=>'captcha', 'alt'=>'CAPTCHA Image'));
            echo $this->Form->input('Discussion.captcha', array('size'=>10,'maxlength'=>10, 'label'=>__('Enter characters showing up')));
            echo $this->Form->input('Discussion.name',array('size'=>10,'maxlength'=>15, 'label'=>__('Name')));
            echo $this->Form->input('Discussion.email',   array('size'=>30,'maxlength'=>60, 'label'=>__('Email (is not showed)')));
            echo $this->Form->input('Discussion.website', array('size'=>40,'maxlength'=>120,'value'=>'http://','label'=>__('Website (optional)')));
        endif;
        echo $this->Form->input('Discussion.comment', array('type'=>'textarea','between'=>'<br />','cols'=>60,'rows'=>10,'label'=>__('Comment')));
        echo $this->Form->end(__('Save comment'));
        echo '</div><!-- divblock ends -->';
    endif;
endif; 

echo '</div><!-- bodynew ends -->';

 # JS Starts
 echo $this->Html->scriptStart(); 
 ?>
 function chkForm() { 
  var name     = document.getElementById("DiscussionName");
  var captcha  = document.getElementById("DiscussionCaptcha");
  var comment  = document.getElementById("DiscussionComment");

  // alert('I am here motherfucker!!');

  if (captcha.value.length < 3)
  {
      alert('<?php echo __('You must type captcha'); ?>');
      name.focus();
      return false;
  }
  if (name.value.length < 3)
  {
      alert('<?php echo __('Name must have three letters at least'); ?>');
      name.focus();
      return false;
  }

  if (comment.value.length < 3)
  {
      alert('<?php echo __('Comment must have three letters at least');?>');
      comment.focus();
      return false;
  }
  return true;
}
<?php
  echo $this->Html->scriptEnd();
# ? > EOF
