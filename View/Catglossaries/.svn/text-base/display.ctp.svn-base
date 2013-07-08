<?php
$this->set('title_for_layout', __('Glossaries'));

echo $this->Html->div('title_section', $this->Html->image('Glossary.png', array('title'=>__('Glossaries'), 'alt'=>__('Glossaries'))).' '.__('Glossaries'));

foreach ($data as $val):
   echo '<div style="padding:8px;margin:8px;text-align:justify;">';                                                                                         
   echo $this->Html->link(h($val['Catglossary']['title']), '/catglossaries/view/'.$blogger['User']['username'].'/'.$val['Catglossary']['id'],
                       array('style'=>'font-size:14pt;font-weight:bold;')) . '<br />';
   echo h($val['Catglossary']['description']);
   echo '</div>';
endforeach;

# ? > EOF
