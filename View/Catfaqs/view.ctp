<?php
#die(debug($data));
$this->set('title_for_layout', __('FAQs'));
echo $this->Html->div('title_section', $data['Catfaq']['title'] .' FAQ', array('id'=>'main'));

foreach ($data['Faq'] as $v):
    echo $this->Html->link($this->Html->image('static/bullet_icon.png', array('alt'=>'Question')).' '.$v['question'], '#qa'.$v['id'], 
                           array('escape'=>False)) . '<br />';
endforeach;

foreach ($data['Faq'] as $v):
    echo '<div style="border:1px dotted gray;padding:4px;margin:15px 5px 3px 3px;color:#000" id="qa'.$v['id'].'">';
    echo $this->Html->div(null, $v['question'], array('style'=>'font-weight:bold;'));
    echo $this->Html->div(null, $v['answer']);
    echo $this->Html->para(null,$this->Html->link($this->Html->image('static/arrow_top.gif', 
                           array('alt'=>'Go top', 'title'=>'Go top')), '#main', array('escape'=>False)));
    echo '</div>';
endforeach;

# ? > EOF

