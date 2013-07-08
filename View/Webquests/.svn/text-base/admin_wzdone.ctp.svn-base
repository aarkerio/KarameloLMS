<?php echo $this->Form->create('Ecourse', array('url'=>$this->here)); ?>
<fieldset>
 <legend><?php __('New eCourse'); ?></legend>
<?php
    echo $this->Html->div('wizard'); 
    echo $this->Html->para(Null, '<b>'.__('Step One').'</b>'); 
    echo $this->Html->para(Null, 'Este es el asistente para la creación de cursos en línea (eCourses), si usted aún no lo ha hecho es buen momento para revisar '.$this->Html->link('los manuales', 'http://www.chipotle-software.com//blog/view/manuals/', array('target'=>'_blank')).'.');
echo $this->Html->para(null, 'El primer paso es darle un título el curso, además es necesario seleccionar el idioma y la materia o área a la que pertenece. El tipo de curso Mixto se refiere a si el curso contempla clases presenciales o si todas las horas del curso se imparten en línea en cuyo caso se deberá seleccionar la opción On line.'); 

echo $this->Html->para(null, 'La descripciónn del curso es una mención breve sobre la temática central que se aborda. En la descripción se deben mencionar el porcentaje mínimo de puntos que se deben de cubrir para aprobar el curso (generalmente el 60%). También deberá especificar la duración en horas del curso.');
    echo $this->Html->para(null, __('No se preocupe demasiado al seguir este asistente, toda la información que usted ingrese estará siempre a su disposición para ser editada las veces que usted desee.'));
    echo '</div>';
    
echo $this->Form->input('Ecourse.title', array('size'=>70,'maxlength'=>90,'title'=>' e.g. History of Literature', 'class'=>'required'));
echo $this->Form->input('Ecourse.subject_id', array('type'=>'select', 'options'=>$subjects, 'label' =>__('Subject')));
echo $this->Form->input('Ecourse.lang_id', array('type'=>'select', 'options'=>$langs, 'label'=>__('Lang'));

$kinds = array(0=>__('Mixed'), 1=>__('On line'));
echo $this->Form->input('Ecourse.kind', array('type'=>'select', 'label'=>__('Type'), 'options'=>$kinds));

echo $this->Form->input('Ecourse.description', array('type'=>'textarea','div'=>False,'cols'=>80, 'rows'=>7, 'label'=>__('Description')));
echo $this->Form->end(__('Next') .'>>');

echo '</fieldset>';

# ? > EOF