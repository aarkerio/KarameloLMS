<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package treasures
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Treasure.php

class Treasure extends AppModel {

/**
 *  CakePHP Model class name
 *  @access public
 *  @var atring
 */
 public $name      = 'Treasure';

/**
 *  CakePHP behaviours
 *  @access public   
 *  @var array
 */ 
  public $actsAs   = array('Containable');


/**
 *  CakePHP belongsTo
 *  @access public   
 *  @var array
 */ 
  public $belongsTo = array('User');

/**
 *  CakePHP hasMany
 *  @access public 
 *  @var array
 */ 
  public $hasMany = array(
		          'ResultTreasure' =>
		                   array('className'     => 'ResultTreasure',
				                 'conditions'    => Null,
                                 'foreignKey'    => 'treasure_id'
				                 ),
                  'TreasureVclassroom' =>
					       array('className'     => 'TreasureVclassroom',
						         'foreignKey'    => 'treasure_id'
						        )
                       );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */	
  public $validate = array(
	    'title'  => array(
			              'rule'       => array('minLength', 4),
                          'required'   => True,
                          'allowEmpty' => False,
                          'message'    => 'Title can not be empty'  
			      ),
	   'instructions' => array(
                          'rule'       => array('minLength', 0),
                          'required'   => True,
                          'allowEmpty' => False,
                          'message'    => 'Instructions at least 20 characters'
			      ),
	     'secret' => array(
				          'rule'       => array('minLength', 4),
			              'message'    => 'Secret can not be less than three characters',
                          'required'   => True,
                          'allowEmpty' => False
			      )
		       );

/**
 *  return shared Treasures by teacher
 *  @access public
 *  @return mixed array or Null
 */
 public function getKnet()
 {
   $params = array('conditions' => array('Treasure.knet' => 1),
                   'fields'     => array('Treasure.title', 'Treasure.id'),
                   'contain'    => array('User'=>array('conditions'=>array('User.active'=>1),'fields'=>array('User.username')))
                   );
   return $this->find('all', $params);
 }

/**
 *  Get Scavenger hunt already answered by student
 *  @param integer $treasure_id
 *  @param integer $user_id
 *  @access public
 *  @return array 
 */
 public function getTreasure($user_id, $treasure_id)
 {
   $params = array('conditions' => array('ResultTreasure.treasure_id'=>$treasure_id, 'ResultTreasure.user_id'=>$user_id),
                   'fields'     => array('User.username',  'ResultTreasure.id', 'ResultTreasure.points', 'ResultTreasure.created', 'Treasure.points', 'Treasure.title', 'Treasure.instructions'));

   return $this->ResultTreasure->find('first', $params);
 }

/**
 *  student Treasure points
 *  @access public
 *  @return mixed array or Null
 */
 public function getPoints($user_id, $treasure_id)
 {
    $conditions = array('ResultTreasure.treasure_id'=>$treasure_id, 'ResultTreasure.user_id'=>$user_id);
   
    $data       = $this->ResultTreasure->field('ResultTreasure.points', $conditions);

    return $data;
 }

/**
 * Return treasures owned by teacher and not already linked to the vclassrooms
 * @access public
 * @param integer $user_id
 * @param integer $vclassroom_id
 * @return mixed array or null
 */
 public function getScaven($user_id, $vclassroom_id)
 {
   $params = array('conditions' => array('Treasure.user_id'=>$user_id),
                   'fields'     => array('Treasure.id', 'Treasure.title'),
                   'contain'    => False,
                   'order'      => 'Treasure.title');
   $ts     = $this->find('all', $params);
   foreach ($ts as $k =>$t):
       $params = array('conditions' => array('TreasureVclassroom.treasure_id' => $t['Treasure']['id'],'TreasureVclassroom.vclassroom_id'=>$vclassroom_id),
                       'fields'     => array('TreasureVclassroom.treasure_id'));
       $assigned = $this->TreasureVclassroom->find('first', $params);
       if ( $assigned ): # test is already assigned to this Vclassroom, so unset
           unset($ts[$k]);
       endif; 
   endforeach;

  return $ts;
 }

/**
 *  check if studen already found treasure
 *  int treasure_id 
 *  int user_id      
 *  int vclassroom_id
 *  return boolean 
 */
 public function chk($treasure_id, $user_id, $vclassroom_id)
 { 
   $conditions = array('ResultTreasure.user_id'=>$user_id, 'ResultTreasure.treasure_id'=>$treasure_id, 'ResultTreasure.vclassroom_id'=>$vclassroom_id); 

   $data      = $this->ResultTreasure->field('ResultTreasure.id', $conditions);
   
   if ( $data == False ):
       return False;   
   else:
       return True;
   endif;
 }
}

# ? > EOF
