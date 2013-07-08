<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.8
*  @package ecourses
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/VclassroomWebquest.php

class VclassroomWebquest extends AppModel {

/**
 *  Class Name
 *  @access public
 *  @var string
 */
  public $name = 'VclassroomWebquest';

/**
 *  Use Table
 *  @access public
 *  @var string
 */
  public $useTable = 'vclassrooms_webquests';

/**
 *  CakePHP balongsTo relatinoship
 *  @access public
 *  @var array 
 */
  public $belongsTo = array(
                              'Webquest', 'Vclassroom'  # webquest_vclassrooms is the SQL table
                           );

/**
 *  Check if test is open
 *  @param integer user_id 
 *  @param integer vclassroom_id
 *  @access public
 *  @return boolean
 */
 public function chkDate($webquest_id=Null, $vclassroom_id)
 {
   if ($test_id === Null):
       return False; 
   endif;

   # check if users is Vclassroom teacher, I mean owner vclassroom
   # kind IS = Owner 1, tuthor 2, or student 0
   $conditions = array('UserVclassroom.vclassroom_id'=>$vclassroom_id, '(UserVclassroom.kind = 2 OR UserVclassroom.kind = 1)', 'UserVclassroom.user_id'=>$user_id);
   $test_vclassroom_id  =  $this->User->field('UserVclassroom.id',$conditions);
   #die(debug($user_vclassroom_id));
   if ( $test_vclassroom_id  ):    # Teacher wants to see his/her own vclass
       return True;
   endif;
   $conditions =  array('UserVclassroom.user_id'=>$user_id, 'TestVclassroom.vclassroom_id'=>$vclassroom_id);
   $data   =  $this->field('testVclassroom.user_id',$conditions);
   #die(debug($data));
   if ($data == False ):
       return False;   
   else:
       return True;
   endif;
 }

/**
 * check if Vclassrom is out of date before 
 * Used in: /vclassrooms/show/$username/$vclassroom_id
 * @access private
 * @return boolean
 */
 private function __KandieDate($vclassroom_id)
 {
   $this->recursive = 0;

   $field = $this->field('GapVclassroom.id', array('GapVclassroom.id'=>$vclassroom_id, 'CURRENT_DATE <= GapVclassroom.fdate','CURRENT_DATE >= GapVclassroom.sdate'));
   
   if ( !$field ): # vclassroom exist but is out of date
       return True;
   else:
       return False;
   endif;
 }
}

# ? > EOF
