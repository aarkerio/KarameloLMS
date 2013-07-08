<?php
/**
 *  Karamelo e-Learning Platform
 *  GPLv3
 *  @copyright Copyright 2006-2011, Chipotle Software, Inc. (http://www.chipotle-software.com)
 *  @author Manuel Montoya <mmontoya_ARROBA_chipotle-software_PUNTO_com>
 *  @version 0.7
 *  @package webquests
 *  @license http://www.gnu.org/licenses/gpl-3.0.html
 */
#file APP/plugins/ksuite/models/wquest.php

class Wquest extends KsuiteAppModel {

/**
   *  Load behaviours
   *  @access public   
   *  @var array
   */   
 public $actsAs   = array('Containable');

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */     
 public $validate = array(
           'title' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                          ),
           'introduction' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                                  ),
           'tasks' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                           ),
           'process' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                             ),
           'roles' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                           ),
           'evaluation' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                            ),
           'conclusion' => array(
                            'rule'    => array('minLength', 4),
                            'message' => 'Minimum 4 characters long'
                              ),
           'user_id' => array(
                            'rule'       => 'numeric',
                            'allowEmpty' => False,
                            'on'         => 'create',   # but not on update
                            'required'   => True 
                             )       
        );
}

# ? > EOF
