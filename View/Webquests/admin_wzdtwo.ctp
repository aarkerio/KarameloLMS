<?php echo $this->Form->create('Ecourse', array('url'=>$this->here)); ?>
<fieldset>
 <legend><?php __('Step Two'); ?></legend>
<?php
#debug($this->data);
echo $this->Html->div('wizard'); 
echo $this->Html->para(Null, __('Es tiempo de darle objetivos al eCourse, es decir que es lo que se espera que el alumno sea capaz de realizar al finalizar el curso. Los objetivos deberan ser concretos y medibles como:'));
echo $this->Html->para(Null, '<i>'.__('Participants will list and describe the 6 levels of knowledge in Bloom\'s taxonomy.').'</i>');
echo $this->Html->para(Null, __('Junto a los objetivos se debe mencionar la audiencia a la que el curso va dirigido, es decir el perfil y conocimientos previos que se esperan del estudiante para tomar el curso.'));
echo $this->Html->para(Null, __('Por útimo el campo Código es un campo opcional para asignarle una nombre corto al curso'));
echo '</div>';

echo $this->Form->input('Ecourse.outcomes', array('type'=>'textarea', 'cols'=>80, 'rows'=>5, 'label' => __('Learning Outcomes')));  
echo $this->Form->input('Ecourse.audience', array('type'=>'textarea', 'cols'=>80, 'rows'=>5, 'label' => __('Prospective Audience'))); 
echo $this->Form->input('Ecourse.code',     array('size'=>12, 'maxlenght'=>12, 'title'=>'max. 12 characters. Example: ROM2121', 'label'=>__('Code')));
echo $this->Html->div('limpia', '<br /><br />');
echo $this->Form->end(__('Next') .'>>');

echo '</fieldset>';

# ? >  EOF

