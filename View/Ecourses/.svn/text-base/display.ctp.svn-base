<?php
#die(debug($data)); 
$this->set('title_for_layout',  __('Current eCourses'));

echo $this->Html->div('title_portal', __('eCourses').'. '.__('Our educative proposal'));

if ( !$data):
    echo $this->Html->para(Null, __('No courses yet'));
 else:
     echo $this->Html->div('spaced');
           __('For any information about this courses please');
           echo  '&nbsp;'.$this->Html->link(__('put in contact with us'), '/colleges/contact');
     echo '</div>';  
endif;

foreach ($data as $v):
    $qn   = 'qn'. $v['Ecourse']['id'];
    $load = 'load'. $v['Ecourse']['id'];
    echo '<div style="border:1px dotted gray;padding:4px;margin-bottom:15px">';
    echo $this->Html->div('titnew', $v['Ecourse']['title']);

    echo $this->Html->div(Null, Null);
    echo  __('Course Instructor') . ': <br />';
    echo $this->Html->link($this->Html->image('avatars/'.$v['User']['avatar'],array('alt'=>$v['User']['avatar'],'title'=>$v['User']['avatar'])),
                    '/users/about/'.$v['User']['username'], array('escape'=>False)); 
    echo $this->Html->link($v['User']['username'],'/users/about/'.$v['User']['username'], array('escape'=>False)) .'<br />';
    echo __('Subject'). ': '.$v['Subject']['title'];
    echo '</div>';


    echo  $this->Html->para(null, '<b>'.__('Course description').'</b>'. $this->Js->link($this->Html->image('static/arrow_down.png',
      array('alt'=>__('Course description'), 'title'=>__('Course description'))),
        '/ecourses/description/'.$v['Ecourse']['id'],
        array('update'      => "#$qn",
              'evalScripts' => True,
              'before'      => $this->Gags->ajaxBefore($qn, $load),
              'complete'    => $this->Gags->ajaxComplete($qn, $load),
              'escape'      => False)));
    echo $this->Gags->imgLoad($load);
    echo $this->Gags->ajaxDiv($qn) . $this->Gags->divEnd($qn);
    echo '</div>';
endforeach;

# ? > EOF
