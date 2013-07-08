<br />
<?php
echo $this->Html->link(__('Home'), '/') . ' | ';
if ( $this->Session->check('Auth.User') ):
    echo '<span style="font-size:7pt;color:#ffe400;padding-right:3px">'.__('logged_in').' <b> ';
    echo $this->Session->read('Auth.User.username') .'</b></span>| '.$this->Html->link(__('Logout'), '/users/logout') . ' | ';

    if ( $this->Session->read('Auth.User.group_id') < 3 ): # the logged user is teacher or admin?
         echo $this->Html->link(__('cPanel'), '/admin/entries/start') . ' | ';
    endif;
    
    if (  $this->Session->read('Auth.User.group_id') == 3 ): # logged user is student
 	     echo $this->Html->link(__('My profile'), '/users/edit'). ' | ';
    endif;
    echo $this->element('chkmsg');
else:
    echo $this->Html->link(__('Login'), '#', array('id'=>'logindiv', 'onclick'=>"javascript:mod('logindiv', 1, '')")) .  ' | ';
endif;
echo $this->Html->link(__('about_college'), '/colleges/')  . ' | ';
echo $this->Html->link(__('Contact'), '/colleges/contact') . ' | &nbsp;';
# ? > EOF