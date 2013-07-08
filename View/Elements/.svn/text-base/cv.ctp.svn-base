<?php
 $data =   $this->requestAction('/users/about/'.$blogger['User']['username']);

 echo $this->Html->div('temas', $data['User']['username'] . ' profile'); 

 echo $this->Html->para('cv', $data['Profile']['cv']);
 echo $this->Html->para(null,$this->Html->image('avatars/'.$data['User']['avatar'], array('alt'=>$data['User']['username'], 'title'=>$data['User']['username'])), array('style'=>'text-align:center'));

# ? > EOF
