<div class="temas">Courses</div>
<?php
foreach ($blog['Ecourse'] as $val) :
  echo $this->Html->link($val['name'], '/ecourses/display/'.$val['user_id'].'/'. $val['id'], array('class'=>'petit')) . '<br />\n';
  endforeach;
?>