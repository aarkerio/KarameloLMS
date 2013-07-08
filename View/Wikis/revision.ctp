<?php
#debug($data);
$this->set('title_section', 'WikiPage Revision');

echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$data['Wiki']['vclassroom_id']));
echo $this->Html->div('title_section', 'WikiPage Revision');
echo $this->Html->div(Null, $data['Wiki']['title']);
echo $this->Html->div(Null, $data['Revision'][0]['content']);
# ? > EOF
