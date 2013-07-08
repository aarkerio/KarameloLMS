<?php
$this->set('title_for_layout', $title_for_layout);
echo $this->Html->div('title', 'Welcome to Karamelo!.  Step 1/3');
echo $this->Html->div(Null,'Karamelo is an e-Learning, Web 2.0 platform which provides tools to improve the teaching-learning process.');
echo $this->Html->div(Null,'You must have MySQL 5.1 or PostgreSQL 8.3 installed. Also PHP 5.3 or higher.');
echo $this->Html->div(Null,'Please be sure rewrite Apache module is enabled:<br /><b>$sudo a2enmod rewrite</b>');
echo $this->Html->div(Null,'Also you must <a href="http://httpd.apache.org/docs/2.0/mod/core.html#allowoverride">AllowOverride</a> in your apache directory:<br /><b>AllowOverride All</b>');

echo $this->Form->create('Install', array('id'=>'install_language', 'action'=>'database'));

echo $this->Html->div('input text', Null);

$options = array('en'=>'English', 'es'=>'Spanish');
echo $this->Form->input('Install.lang_inst', array('type'=>'select','label'=>'Choose your language installation:', 'options'=>$options, 'between'=>'<br />'));

echo $this->Form->submit('Next >>');

# ? > EOF
