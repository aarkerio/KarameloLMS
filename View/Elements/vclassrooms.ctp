<?php
# teacher's classrooms showed in edublog
$data = $this->requestAction('/vclassrooms/display/'.$blogger['User']['id']);
if ( $data ):
   echo $this->Html->div('temas', __('vClassrooms'));
   foreach ($data as $v):
        echo '► '.$this->Html->link($v['Vclassroom']['name'],
                             '/vclassrooms/show/'.$blogger['User']['username'].'/'.$v['Vclassroom']['id'], array('class','petit')).'<br />';
   endforeach;
endif;

# ? >  EOF 

