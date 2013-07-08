<?php 
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
echo $this->Form->create('Ecourse', array('url'=>$this->here)); 
?>
<fieldset>
 <legend><?php __('New eCourse'); ?></legend>
<?php
echo $this->Html->div('wizard'); 
echo $this->Html->para(null, '<b>'.__('Step One').'</b>'); 

echo $this->Html->para(null, 
          __('ecourse wizard 1').' '.$this->Html->link(__('the manuals'), 'http://www.chipotle-software.com//blog/view/manuals/', array('target'=>'_blank')).'.');

echo $this->Html->para(Null, __('ecourse wizard 2')); 

echo $this->Html->para(Null, __('ecourse wizard 3'));
  
echo $this->Html->para(Null, __('ecourse wizard 4'));
echo '</div>';
    
echo $this->Form->input('Ecourse.title', array('size'=>70,'maxlength'=>90,'title'=>' e.g. History of Literature', 'div'=>False));
echo $this->Form->input('Ecourse.subject_id', array('type'=>'select', 'label'=>__('Subject'), 'options'=>$subjects));

echo $this->Form->input('Ecourse.lang_id', array('type'=>'select',  'label'=>__('Language'), 'options'=>$langs)); 
echo $this->Gags->helps('Tipo de curso: con clases presenciales (mixto) o completamente en línea', $helps);

$kinds = array(0=>__('Mixed'), 1=>__('On line'));
echo $this->Form->input('Ecourse.kind', array('type'=>'select', 'options'=>$kinds, 'label'=>__('Type')));

echo $this->Gags->helps('Describa el curso, los temas que se abordarán', $helps);
echo $this->Form->input('Ecourse.description', array('type'=>'textarea','cols'=>80, 'rows'=>7, 'label'=>__('Description')));

$percentages = array(60=>60, 70=>70, 75=>75, 80=>80, 85=>85, 90=>90, 95=>95, 100=>100);
echo $this->Gags->helps('Minimum points percentage required to aprobe course', $helps);
echo $this->Form->input('Ecourse.percentage', array('label'=>__('Percentage') .' %', 'options'=>$percentages));

echo $this->Form->end(__('Next') .'>>');


echo '</fieldset>';

# ? > EOF 