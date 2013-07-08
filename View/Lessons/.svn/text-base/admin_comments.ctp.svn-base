<?php
#die(debug($data));
$this->Html->addCrumb('Control Panel', '/admin/lessons/start'); 
$this->Html->addCrumb(__('Lessons'), '/admin/lessons/listing'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', __('Comments in your lessons'));

if ( count($data) < 1 ):
    echo '<h1>'.__('No comments yet') .'</h1>';
else:
    echo $this->Html->div('divbuttons');
    echo $this->Html->link(__('Order by created'), '/admin/lessons/comments/1', array('class'=>'linkbutton'));
    echo $this->Html->link(__('Order by lesson'), '/admin/lessons/comments/2',  array('class'=>'linkbutton'));
    echo '</div>';
endif;

$msg   = __('Are you sure to want to delete this?');

foreach($data as $v):
        echo $this->Html->div('adminblock');
        if ( $v['Annotation']['status'] == 1 ):
            $st = __('Published');
            $img   = 'static/status_1_icon.png';
        else:
            $st = __('Hidden');
            $img   = 'static/status_0_icon.png';
        endif;
        echo __('On') . ' '.$this->Html->link($v['Lesson']['title'],'/lessons/view/'.$this->Session->read('Auth.User.username').'/'.$v['Lesson']['id'], 
             array('target'=>'_blank')) . '<br /><br />';
        if ( $v['User']['id'] == 2): #comment wrote by a not logged user
            echo $this->Html->link($this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['Annotation']['username'], 'title'=>$v['Annotation']['username'])), 
                  '/users/about/'.$c['User']['username'],array('target'=>'_blank', 'escape'=>False)) . '<br />';
            echo $c['username'].' '. __('wrote') . ':<br />';
            echo $this->Html->para(null, h(nl2br($c['comment'])));
            echo $this->Html->div(null, $c['created'], array('style'=>'font-size:7pt;margin:4px'));
            echo $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), '/admin/annotations/change/'.$v['Annotation']['id'].'/'.$v['Annotation']['status'],
                       array('escape'=>False)) . ' &nbsp;&nbsp;&nbsp;';
            echo $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 
                                          'title'=>__('Delete'))), '/admin/annotations/delete/'.$v['Annotation']['id'], 
                                            array('onclick'=>"return confirm('".$msg."')",'escape'=>False)) .'<br /> ';         
        else:
            echo $this->Html->link(
                  $this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['User']['username'], 'title'=>$v['User']['username'])), 
                  '/users/about/'.$v['User']['username'],
                  array('target'=>'_blank', 'escape'=>False)) . '<br />';
            echo $this->Html->link($v['User']['username'], '/users/about/'.$v['User']['username']) . ' ' . __('wrote') . ':<br />';
            echo $this->Html->para(null, h(nl2br($v['Annotation']['comment'])));
            echo $this->Html->div(null, $v['Annotation']['created'], array('style'=>'font-size:7pt;margin:4px'));
            echo $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), '/admin/annotations/change/'.$v['Annotation']['id'].'/'.$v['Annotation']['status'], 
                       array('escape'=>False)) . ' &nbsp;&nbsp;&nbsp;';
            echo $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 
                                          'title'=>__('Delete'))), '/admin/annotations/delete/'.$v['Annotation']['id'], 
                                  array('onclick'=>"return confirm('".$msg."')", 'escape'=>False))   . '<br /> '; 
        endif;
        echo '</div>';
endforeach;

# ? > EOF
