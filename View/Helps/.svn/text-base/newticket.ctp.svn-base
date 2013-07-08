<h1>Reporting bugs</h1>
<?php 
  echo $this->Html->para(Null, __('You can help the Karamelo development team by reporting bugs and sending suggestions to improve this application'));
  echo $this->Form->create('Help', array('action'=>'submit'));

  echo $this->Form->input('Help.report', array('type'=>'textarea', 'label'=>'Description:', 'rows'=>8, 'cols'=>60)) . '<br />';
  
  echo $this->Form->label('Help.kind', 'Kind:') . '<br />';
  echo $this->Form->select('Help.kind', array('Enhancement'=>__('Enhancement'), 'Bug'=>'Bug', 'Suggestion'=>__('Suggestion')), null, array(), False) . '<br />';
  
  echo $this->Form->end('Send');
  
  echo $this->Html->link('Submit new ticket', 'http://trac.mononeurona.org/karamelo/newticket'); 

# ? > EOF
