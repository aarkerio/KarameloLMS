<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package vclassrooms
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Participation.php

class Participation extends AppModel {

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
  public $actsAs  = array('Containable');    


/**
 *  CakePHP belongsTo
 *  @access public    
 *  @var array
 */  
  public $belongsTo  = array(
                             'User' => array(
                                            'className'    => 'User',
                                            'foreignKey'   => 'user_id'
                                            ),
                             'Vclassroom' => array(
                                            'className'    => 'Vclassroom',
                                            'foreignKey'   => 'vclassroom_id'
                                                   ),
                             'Activity' => array(
                                            'className'    => 'Activity',
                                            'foreignKey'   => 'activity_id'
                                             )
             );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */    
 public $validate = array(
       'title'        => array(
                               'rule'       => array('minLength', 2),
                               'message'    => 'Title must be at least two characters long',
		                       'allowEmpty' => False,
                               'required'   => True 
		                      ),
      'participation' => array(
                               'rule'       => array('minLength', 8),
                               'message'    => 'Text must be at least 8 characters long',
		                       'allowEmpty' => False,
                               'required'   => True 
                              ),
      'user_id'       => array(
		                       'rule'       => 'numeric',
                               'allowEmpty' => False,
                               'on'         => 'create',  # but not on update
                               'required'   => True 
		                      )
   );


/**
 *  Get all data to send email after teacher graded file report 
 *  @param integer $participation_id
 *  @access public
 *  @return array
 */
 public function getData($participation_id)
 {
  $params =array(
                  'conditions'=> array('Participation.id'=>$participation_id), 
                  'fielfds'    => array('Participation.title', 'Participation.created', 'Participation.vclassroom_id', 'Participation.activity_id'),
                  'contain'   => array(
                                       'User'       => array('fields'=>array('email')), 
                                       'Vclassroom' => array('fields'=>array('name', 'id'))
                                       ));
 
  $data = $this->find('first', $params);
  #die(debug($data));
  $data['title'] = $this->Activity->field('title', 'id='.$data['Participation']['activity_id']);
  $data['teacher_id'] = $this->User->UserVclassroom->field('UserVclassroom.user_id', array('UserVclassroom.vclassroom_id'=>$data['Vclassroom']['id'], 'UserVclassroom.kind'=>'1'));
  $conditions = array('User.id'=>$data['teacher_id']);
  $data['teacher_username'] = $this->User->field('username', $conditions);
  #die(debug($data));
  return $data;
 }

}

# ? > EOF


