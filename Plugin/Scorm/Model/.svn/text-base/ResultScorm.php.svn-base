<?php
/**
*  Karamelo e-Learning Platform
*  GPLv3
*  @copyright Copyright 2008-2012, Chipotle Software(c)
*  @version 0.7
*  @package scorm
*  @license http://www.gnu.org/licenses/gpl-3.0.html
*/
# file: APP/Plugin/Scorm/Model/ResultScorm.php

class ResultScorm extends ScormAppModel {

/**
 *  Class Name
 *  @access public
 *  @var string
 */
  public $name       = 'ResultScorm';

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs  = array('Containable');

/**
 *  Class Name
 *  @access public
 *  @var string
 */
  public $conditions  = array();

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array 
 */ 
  public $belongsTo  = array(
             'User' => array(
                             'className'    => 'User',
                             'foreignKey'   => 'user_id',
                             'fields'   =>'id, username'
                               ), 
             'Scorm' => array(
                             'className'    => 'Scorm.Scorm',
                             'foreignKey'   => 'scorm_id'
                              )
             );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
   # 'points' => array(
   #                 'rule'       => 'numeric',
   #                 'allowEmpty' => False,
   #                 'required'   => True
   #                 ),
    'scorm_id' => array(
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

/**
 * Get CMI Value
 * @param string $varname
 * @access public
 * @void mixed array or Null
 */
 public function getValue($varname)
 {
  $this->conditions['varname'] = $varname; 
  $value = (string) $this->field('varvalue', $this->conditions);
  return $value;
 }

/**
 * Get SCORM points
 * @param int $user_id
 * @param int $vclassroom_id
 * @access public
 * @void integer
 */
 public function getPoints($user_id, $vclassroom_id, $scorm_id)
 {
  $points = (int) 0;
  $params = array('conditions' => array('ResultScorm.varname'       => 'raw', 
                                        'ResultScorm.user_id'       => $user_id, 
                                        'ResultScorm.vclassroom_id' => $vclassroom_id,
                                        'ResultScorm.scorm_id'      => $scorm_id
                                       ),
                  'fields'     => array('ResultScorm.varvalue'),
                  'contain'    => False
   ); 

  $data = $this->find('all', $params);
 
  foreach($data as $r):
      $points += $r['ResultScorm']['varvalue'];
  endforeach;
  return $points;
 }
}

# ? > EOF
