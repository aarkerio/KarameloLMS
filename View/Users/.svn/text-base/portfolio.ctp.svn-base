<?php
$this->set('title_for_layout', $blogger['User']['username']. '\'s Portfolio');

echo $this->Html->div(null, $this->Html->image('static/eportfolio.jpg', array('alt'=>'ePortfolio')), array('style'=>'margin:19px auto 0 auto;'));
echo $this->Html->div('title_section', $blogger['User']['username'].' '. __('resources')); 
echo $this->Html->div('portfolio',$this->Html->link($this->Html->image('static_pages.png', array('title'=>__('Lessons'), 'alt'=>__('Lessons'))), '/lessons/display/'.$blogger['User']['username'], array('escape'=>False)).' '. __('Lessons'));

echo $this->Html->div('portfolio',$this->Html->link($this->Html->image('ipod.png', array('title'=>'Podcast', 'alt'=>'Podcast')), '/podcasts/display/' . $blogger['User']['username'], array('escape'=>False)) . 'Podcasts'); 

echo $this->Html->div('portfolio',$this->Html->link($this->Html->image('wikis.png', array('title'=>'WikiPages', 'alt'=>'WikiPages')), '/wikis/display/' . $blogger['User']['username'], array('escape'=>False)) . ' WikiPages'); 

echo $this->Html->div('portfolio',$this->Html->link($this->Html->image('faq.png', array('title'=>'FAQs', 'alt'=>'FAQs')), '/catfaqs/display/'.$blogger['User']['username'], array('escape'=>False)) .' '.__('FAQs')); 

echo $this->Html->div('portfolio',$this->Html->link($this->Html->image('Glossary.png', array('title'=>__('Glossaries'), 'alt'=>__('Glossaries'))), '/catglossaries/display/'.$blogger['User']['username'], array('escape'=>False)).' ' .__('Glossaries'));
 
echo $this->Html->div('portfolio', $this->Html->link($this->Html->image('mmultimedia.png', array('title'=>__('Shared'), 'alt'=>__('Shared'))), '/shares/display/'.$blogger['User']['username'], array('escape'=>False)) .' '. __('Shared files'));

echo $this->Html->div('portfolio', $this->Html->link($this->Html->image('ylinks.png', array('title'=>__('Usefull links'), 'alt'=>__('Usefull links'))), '/acquaintances/display/'.$blogger['User']['username'], array('escape'=>False)) . ' '.__('Usefull links')); 

# ? > EOF
