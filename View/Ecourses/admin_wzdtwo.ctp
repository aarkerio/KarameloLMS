<?php echo $this->Form->create('Ecourse', array('url'=>$this->here)); ?>
<fieldset>
 <legend><?php __('Step Two'); ?></legend>
<?php
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
#debug($this->data);
echo $this->Html->div('wizard'); 
echo $this->Html->para(Null, __('ecourse wizard 5'));
echo $this->Html->para(Null, '<i>'.__('Participants will list and describe the 6 levels of knowledge in Bloom taxonomy.').'</i>');
echo $this->Html->para(Null, __('ecourse wizard 6'));
echo $this->Html->para(Null, __('ecourse wizard 7'));
echo '</div>';

echo $this->Gags->helps('Describe aqui los objetivos del curso', $helps);
echo $this->Form->input('Ecourse.outcomes', array('type'=>'textarea', 'cols'=>80, 'rows'=>5, 'label' => __('Learning Outcomes')));

echo $this->Gags->helps('Especifica la audiencia a la que el curso está dirigido', $helps);
echo $this->Form->input('Ecourse.audience', array('type'=>'textarea', 'cols'=>80, 'rows'=>5, 'label' => __('Prospective Audience'))); 

echo $this->Gags->helps('Este código es un identificador del curso y creado por ti, es decir el profesor y es opcional', $helps);
echo $this->Form->input('Ecourse.code', array('size'=>12, 'maxlenght'=>12, 'value'=>'NEWCOURSE-12', 'title'=>'max. 12 characters. Example: ROM2121', 'label'=>__('Code')));

echo $this->Form->end(__('Next') .'>>');
echo '</fieldset>';
