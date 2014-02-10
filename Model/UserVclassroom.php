<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.8
*  @package ecourses
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/UserVclassroom.php

class UserVclassroom extends AppModel {

    public $name = 'UserVclassroom';

    public $belongsTo = array(
                              'User', 
                              'Vclassroom'  # user_vclassroom is the SQL table
                              );


/**
 *  Check if student belongs to virtual classroom
 *  @param integer user_id 
 *  @param integer vclassroom_id
 *  @access public
 *  @return boolean
 */
 public function belongs($user_id=Null, $vclassroom_id)
 {
   if ($user_id === Null):
       return False; 
   endif;
  
   # check if user_id is in fact the Vclassroom teacher or tuthor, I mean She/He owns this vclassroom
   # kind IS = Owner 1, tuthor 2, or student 0
   $conditions = array('UserVclassroom.user_id'=>$user_id);
   #die(debug($conditions));
   $user_vclassroom_id  =  $this->field('UserVclassroom.id',$conditions);
   #die(debug($user_vclassroom_id));
   if ( $user_vclassroom_id  ):    # Teacher wants to see his/her own vclass
       return True;
   endif;

   $conditions =  array('UserVclassroom.user_id'=>$user_id, 'UserVclassroom.vclassroom_id'=>$vclassroom_id);
   $data       =  $this->field('UserVclassroom.user_id',$conditions);

   #die(debug($data));
   if ($data == False ):
       return False;   
   else:
       return True;
   endif;
 }


/**
 *  generalBelongs method
 *  build a list containing vclassrooms to wich the stundent belongs to, used in portal component to display select  
 *  @access public
 *  @param integer  user_id
 *  @return mixed array or null
 */
 public function generalBelongs($user_id)
 {
 try{
     $params = array('contain'    => array('Vclassroom' => array('conditions'=>array('Vclassroom.status'=>1, 'Vclassroom.historical'=>0))),
                     'conditions' => array('UserVclassroom.user_id'=>$user_id),
                     'fields'     => array('vclassroom_id'));
  $data   = $this->find('first', $params);
  #die(debug($data));
  if ( !$data ):
      return False;
  else:
      return True;
  endif;
  }
  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }
}

# ? > EOF
