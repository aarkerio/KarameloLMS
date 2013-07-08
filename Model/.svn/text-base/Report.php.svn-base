<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package vclassroom
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Report.php

class Report extends AppModel {

/**
 *  CakePHP Model class name
 *  @access public
 *  @var string
 */
 public $name       = 'Report';

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
                                            'foreignKey'   => 'student_id'
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
       'filename' => array(
                       'rule'       => array('minLength', 4),
                       'message'    => 'File must be at least four characters long',
         		       'allowEmpty' => False,
                       'on'         => 'create',  # but not on update
                       'required'   => True 
		              ),
       'student_id' => array(
		               'rule'       => 'numeric',
                       'allowEmpty' => False,
                       'on'         => 'create',  # but not on update
                       'required'   => True 
		             )
		 ); 


/**
 *  Get all data to send email after teacher graded file report 
 *  @param integer $report_id
 *  @access public
 *  @return array 
 *  @var array
 */
 public function getData($report_id)
 {
  $params =array(
                  'conditions'=> array('Report.id'=>$report_id), 
                  'fielfds'    => array('Report.description', 'Report.created', 'Report.vclassroom_id'),
                  'contain'   => array(
                                       'User'       => array('fields'=>array('email')), 
                                       'Vclassroom' => array('fields'=>array('name', 'id'))
                                       )
                 );
 
  $data = $this->find('first', $params);
  #die(debug($data));
  $data['teacher_id'] = $this->User->UserVclassroom->field('UserVclassroom.user_id', array('UserVclassroom.vclassroom_id'=>$data['Vclassroom']['id'], 'UserVclassroom.kind'=>'1'));
  $conditions = array('User.id'=>$data['teacher_id']);
  $data['teacher_username'] = $this->User->field('username', $conditions);
  #die(debug($data));
  return $data;
 }
}
# ? > EOF
