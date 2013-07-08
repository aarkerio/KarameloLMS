<?php
/**
*  Karamelo e-Learning Platform
*  GPLv3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package links
*  @license http://www.gnu.org/licenses/gpl-3.0.html
*/
#File: /APP/Model/PermanentClass.php

class PermanentClass extends AppModel {

/**
 *  CakePHP Model behaviour
 *  @access public
 *  @var array
 */
  public $actsAs   = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
  public $belongsTo = array(
		 'User' => array(
		                 'className'   => 'User',
                                 'foreignKey'  => 'user_id',
                                 'fields'      => 'id, username'
			         )
			      );  


/**
 * hasMany CakePHP Model relationship
 * @access public
 * @var array
 */
  public $hasMany = array(
                   'PcStudent' =>
                     array('className'     => 'PcStudent',
                           'foreignKey'    => 'pc_id')
                          );
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'title' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Title must be at least four characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),
  'user_id' => array(
		            'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'on'         => 'create', # but not on update
                    'required'   => True 
		     )
   );

/**
 * Get students list in permanent classrooms
 * @param  integer $user_id:  in $fact student_id
 * @param  integer $pc_id  description
 * @return array   $record description
 * @access public
 **/
 public function getStudents($user_id, $pc_id)
 {
  try{
      $students = array();
      $params = array('conditions' => array('pc_id'=>$pc_id),
                      'fields'     => array('student_id', 'created', 'id'));
      $data = $this->PcStudent->find('all', $params);
      #die(debug($data));      
      foreach($data as $v):
          $tmp = $this->User->find('first', array('conditions'=> array('User.id'=>$v['PcStudent']['student_id']), 
                                                  'fields'    => array('id', 'username', 'avatar', 'name'),
                                                  'contain'   => False ));
          $tmp['student_id'] = $v['PcStudent']['student_id'];  # id table row to delete in view  
          $tmp['created']    = $v['PcStudent']['created'];
          $tmp['ps_id']      = $v['PcStudent']['id'];  # PcStudent id row
          array_push($students, $tmp);
      endforeach;

      return $students;
    }
  
    catch(Exception $e)
    {
      echo $e->getMessage();
      exit('In Model');
    }
   }

/**
 *  Creating students list from a virtual classroom 
 *  @param  integer $user_id:  in $fact student_id
 *  @param  integer $vclassroom_id  description
 *  @param  integer $pc_id  description
 *  @return array   $record description
 *  @access public
 **/
 public function addList($user_id, $vclassroom_id, $pc_id)
 {
  try{
      $params = array('conditions' => array('UserVclassroom.vclassroom_id' => $vclassroom_id, 'UserVclassroom.kind' => 0), # 0 = student
                      'fields'     => array('UserVclassroom.user_id')
                     );
      $users = $this->User->UserVclassroom->find('all', $params);
      $data['PcStudent']['user_id'] = $user_id;
      $data['PcStudent']['pc_id']   = $pc_id;
      $count = (int) 0; 
      
      foreach($users as $v):
          $data['PcStudent']['student_id'] = $v['UserVclassroom']['user_id'];
          $this->PcStudent->create();
          if ($this->PcStudent->save($data)):
              $count++;
          endif;
      endforeach;
      #die(debug($count));
      return True;
    }
  
    catch(Exception $e)
    {
      echo $e->getMessage();
      exit('In Model');
    }
   }

/**
 *  Insert students list in a virtual classroom 
 *  @param  integer $user_id:  in $fact student_id
 *  @param  integer $vclassroom_id  description
 *  @param  integer $pc_id  description
 *  @return array   $record description
 *  @access public
 **/
 public function insertList($user_id, $vclassroom_id, $pc_id)
 {
  try{
      $params = array('conditions' => array('PcStudent.pc_id' => $pc_id),
                      'fields'     => array('PcStudent.student_id')
                     );
      $users = $this->PcStudent->find('all', $params);
      #die(debug($users));
      $data['UserVclassroom']['user_id']       = $user_id;
      $data['UserVclassroom']['vclassroom_id'] = $vclassroom_id;
      $data['UserVclassroom']['kind']          = 0;
      $count   = (int) 0;
      $already = (int) 0;
      $chk = False;
      foreach($users as $v):
          $chk = $this->User->UserVclassroom->field('id', array('user_id'=>$v['PcStudent']['student_id'], 'kind'=>0, 'vclassroom_id'=>$vclassroom_id));
          if ( !$chk ):
              $data['UserVclassroom']['user_id'] = $v['PcStudent']['student_id'];
              $this->User->UserVclassroom->create();
              if ($this->User->UserVclassroom->save($data)):
                  $count++;
              endif;
          else:
              $already++;
          endif;
      endforeach;
      #die(debug($count));
      $pro['inserted'] = $count; 
      $pro['already']  = $already;  # studenst already in virtual classroom
      return $pro;
    }
  
    catch(Exception $e)
    {
      echo $e->getMessage();
      exit('In Model');
    }
   }
 }

# ? > EOF
