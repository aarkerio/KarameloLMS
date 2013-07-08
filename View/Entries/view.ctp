<?php
#exit(debug($data));
$this->set('title_for_layout', $blogger['User']['username']. '\'s Edublog');
echo $this->element('one_entry', array('cache' => False, 'val'=>$data, 'comments'=>True));

# ? > EOF
