<?php
$this->set('title_for_layout', __('Glossaries'));
echo $this->Html->div('title_section',  $data['Catglossary']['title']);
#exit(debug($data));
if ( count($data['Glossary']) < 1):
    echo $this->Html->para(Null, '<b>'.__('No items yet').'</b>');
endif;
$i = (int) 1;
foreach ($data['Glossary'] as $v):
    echo $this->Html->div(Null, '<b>'.$i++ .'.- '. $v['item'].'</b><br /><br />'. nl2br($v['definition']), 
                          array('style'=>'border:1px dotted gray;padding:8px;margin:8px;'));
endforeach;
# ? > EOF
