<h1><?php __('Reporting bugs'); ?></h1>
<?php 
  echo $this->Html->para(null, 
__('You can help the Karamelo development team by reporting bugs and making suggestions to improve this application'));
  echo $this->Form->create('Help', array('action'=>'newticket'));
  echo $this->Form->input('Help.report', array('rows'=>8, 'cols'=>60,'label' => __('Description')));
  echo $this->Form->input('Help.kind', array( 'label'=>__('Kind'), 'options'=>array('Enhancement'=>__('Enhancement'), 'Bug'=>'Bug', 'Suggestion'=>__('Suggestion')))); 
 echo $this->Form->end(__('Send')) .'<br /><br />';
  
 echo $this->Html->link(__('Submit new ticket'), 'http://trac.chipotle-software.com/karamelo/newticket'); 

# ? > EOF
