<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package webquests
*  @license http://www.gnu.org/licenses/agpl.html
*/
#file APP/Model/Webquest.php

class Webquest extends AppModel {

/**
 * Load CakePHP behaviours
 * @access public
 * @var array
 */
 public $actsAs   = array('Containable');

/**
 * CakePHP Model name
 * @access public
 * @var array
 */
 public $name        = 'Webquest';

/**
 * belongsTo CakePHP Model relationship
 * @access public
 * @var array
 */
 public $belongsTo   = array('User');

/**
 * hasMany CakePHP Model relationship
 * @access public
 * @var array
 */
 public $hasMany = array(
                 'VclassroomWebquest' =>
		                   array('className'     => 'VclassroomWebquest',
                                 'conditions'    => Null,
                                 'foreignKey'    => 'webquest_id'),
                 'ResultWebquest' =>
		                   array('className'     => 'ResultWebquest',
			                     'conditions'    => Null,
			                     'order'         => Null,
			                     'limit'         => Null,
			                     'foreignKey'    => 'webquest_id',
			                     'dependent'     => True,
			                     'exclusive'     => False,
                                 'finderQuery'   => Null
			        ));


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
                                	 'on'         => 'create',  # but not on update
                                	 'required'   => True 
		                        )		
		        );
 
/**
 * Get WQ fulldetails
 * @access public
 * @return mixed, array or Null 
 */
 public function getQuest($user_id, $webquest_id)
 {
   $params = array('conditions' => array('ResultWebquest.webquest_id'=>$webquest_id, 'ResultWebquest.user_id'=>$user_id),
                   'fields'     => array('User.username', 'ResultWebquest.answer', 'ResultWebquest.points', 'ResultWebquest.created', 'Webquest.points', 
                                         'Webquest.title', 'Webquest.introduction')
                  );
   $data   = $this->ResultWebquest->find('first', $params);

   return $data;
 }

/**
 *  Return shared Webquests
 *  @access public
 *  @return mixed array or Null
 */
 public function getKnet()
 {
   $params = array('conditions' => array('Webquest.knet' => 1),
                   'fields'     => array('Webquest.title', 'Webquest.id'),
                   'contain'    => array('User'=>array('conditions'=>array('User.active'=>1),'fields'=>array('User.username')))
                  );
   return $this->find('all', $params);
 }

/**
 * Return Webquest owned by one teacher and not already linked to specific vclassroom
 * @access public
 * @param integer $user_id
 * @param integer $vclassroom_id
 * @return mixed
 */
 public function getWebQuests($user_id, $vclassroom_id)
 {
   $params = array('conditions' => array('Webquest.user_id'=>$user_id, 'Webquest.archived'=>0), # get all Webquests owned by teacher 
                   'fields'     => array('Webquest.id', 'Webquest.title'),
                   'order'      => 'Webquest.title');
   $this->contain();
   $wqs        = $this->find('all', $params );
   foreach ($wqs as $k =>$w):
       $params = array('conditions' => array('VclassroomWebquest.webquest_id' => $w['Webquest']['id'],'VclassroomWebquest.vclassroom_id' => $vclassroom_id),
                       'fields'     => array('VclassroomWebquest.id'));
       $assigned = $this->VclassroomWebquest->find('first', $params);
       if ( $assigned ): # webquest is already assigned to this Vclassroom, so unset
           unset($wqs[$k]);
       endif; 
   endforeach;

  return $wqs;
 }

/**
 *  Check if studen already found webquest
 *  @param integer treasure_id 
 *  @param integer user_id      
 *  @access public
 *  @return boolean
 */
 public function chk($webquest_id, $user_id, $vclassroom_id)
 {
    $conditions =  array('ResultWebquest.user_id'=>$user_id, 'ResultWebquest.webquest_id'=>$webquest_id, 'ResultWebquest.vclassroom_id'=>$vclassroom_id);
    $data       =  $this->ResultWebquest->field('ResultWebquest.id', $conditions);
    
    if ($data == False ):
        return False;   
    else:
        return True;
    endif;
  }
  

}

# ? > EOF
