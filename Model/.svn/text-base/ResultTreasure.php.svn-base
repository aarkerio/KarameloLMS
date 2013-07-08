<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package treasure
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/ResultTreasure.php

class ResultTreasure extends AppModel {

/**
 * CakePHP Class Name
 * @access public
 * @var string
 */
  public $name       = 'ResultTreasure';

/**
 *  CakePHP belongsTo
 *  @access public    
 *  @var array
 */      
  public $belongsTo  = array(
             'User' => array(
                             'className'    => 'User',
                             'foreignKey'   => 'user_id',
                             'fields'   =>'id, username'
                               ), 
             'Treasure' => array(
                             'className'    => 'Treasure',
                             'foreignKey'   => 'treasure_id'
                              )
             );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
    'points' => array(
                    'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'required'   => True
                    ),
    'treasure_id' => array(
                    'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'on'         => 'create', # no update
                    'required'   => True
                    ),
    'vclassroom_id' => array(
                    'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'on'         => 'create', # no update
                    'required'   => True
                            ),
    'user_id'      => array(
                    'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'on'         => 'create', # no update
                    'required'   => True
                    )
   );
}

# ? > EOF
