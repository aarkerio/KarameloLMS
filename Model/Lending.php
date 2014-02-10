<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package collection
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/models/lending.php

class Lending extends AppModel {

/**
 *  Its always good practice to include this variable.
 *  @access public    
 *  @var string
 */
 public $name        = 'Lending';

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs   = array('Containable');

/**
 *  belongsTo relation
 *  @access public    
 *  @var array
 */ 
 public $belongsTo = array(
                           'User' =>array(
                                          'className'  => 'User',
                                          'conditions' => '',
                                          'order'      => '',
                                          'foreignKey' => 'user_id'
                                          ),
                           'Collection' =>array(
                                          'className'  => 'Collection',
                                          'conditions' => '',
                                          'order'      => '',
                                          'foreignKey' => 'collection_id'
                                         )
                            );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
                          'user_id' => array(
                                   'rule'       => 'numeric',
                                   'allowEmpty' => False,
                                   'on'         => 'create', // but not on update
                                   'required'   => True 
                                   )
                         );
}
# ? > EOF
