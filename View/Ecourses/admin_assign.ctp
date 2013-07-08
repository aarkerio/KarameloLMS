<?php
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?

 $this->Html->addCrumb('Control Panel', '/admin/entries/start');
 $this->Html->addCrumb(__('eCourses'), '/admin/ecourses/listing');
 echo $this->Html->getCrumbs(' > ');
 $legend = __('Import eCourse');
 
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<?php 
#die(debug($users));
if ( count($ecourses) > 0):
    foreach($ecourses as $e):
        echo $this->Form->create('Ecourse', array('action' => 'assign'));
        echo $this->Form->hidden('Ecourse.id', array('value'=>$e['id'])); 
        echo $this->Form->end(__('Import')); 
    endforeach;
else:
    echo $this->Html->div('title_section', __('There is no eCourse to assign, you must create and share one'));
endif;
# ? > EOF
