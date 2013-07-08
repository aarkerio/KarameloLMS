<?php 
/**
 * Nav menu in edublog
 * 2009-2011 GPLv3 (c) Chipotle-Software
 */
$buttons=array($this->Html->link(__('eduBlog'),   '/blog/'.$blogger['User']['username']),
               $this->Html->link(__('ePortfolio'), '/users/portfolio/'.$blogger['User']['username']),
               $this->Html->link(__('About me'),  '/vclassrooms/aboutme/'.$blogger['User']['username']),
               $this->Html->link(__('Contact'),   '/messages/message/'.$blogger['User']['username'])
              );
if ( $this->Session->check('Auth.User') and ( $this->Session->read('Auth.User.group_id') < 3 ) ):
    array_push($buttons,  $this->Html->link(__('Admin Panel'),  '/admin/entries/start'));
endif;

if ( $this->Session->check('Auth.User') ):
    array_push($buttons,  $this->Html->link(__('Logout'),  '/users/logout'));
endif;

echo $this->Html->div('navmenu', $this->Html->nestedList($buttons));

# ? > EOF