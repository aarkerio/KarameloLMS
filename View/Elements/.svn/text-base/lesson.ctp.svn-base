<?php
$data = $this->requestAction('lessons/blogElement/'.$blogger['User']['id']);
if ( $data ):
    echo $this->Html->div('temas', __('Lessons'));
    foreach ($data as $v):
        echo '► '.$this->Html->link($v['Lesson']['title'],
                            '/lessons/view/'.$blogger['User']['username'].'/'.$v['Lesson']['id'], array('class'=>'petit')) . '<br />';
    endforeach;
    echo $this->Html->para(Null, $this->Html->link(__('View all Lessons'), '/lessons/display/'.$blogger['User']['username'],array('class'=>'petit')));
endif;
# ? > EOF