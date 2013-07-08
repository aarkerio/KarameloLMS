<?php
/**
*  Karamelo e-Learning Platform
*  Chipotle Software TM   2002-2011
*  GPLv3
*  @author Manuel Montoya mmontoya<arroba>chipotle-software<punto>com
*  @version 0.6
*  @package ecourse
*/
if ( $data ):
    $str  =  '<b>'.__('Points') .': '.$data['Activity']['points'] .'</b><br />';
    $str .=  '<b>'.__('Estimated time').': '.$data['Activity']['minutes'].'</b><br />';
    $str .=  $data['Activity']['activity'];
    echo $this->Html->div(Null,$str, array('style'=>'padding:7px;border:1px dotted gray;'));
else:
    echo $this->Html->div(Null, __('No activity'), array('style'=>'padding:7px;border:1px dotted gray;'));
endif;

# ? > EOF