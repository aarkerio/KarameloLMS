<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package lessons
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/Model/Lesson.php

class Lesson extends AppModel {
 
/**
 *  Behaviours
 *  @access public
 *  @var array
 */
  public $actsAs   = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */     
  public $belongsTo = array('User' =>
			    array('className'  => 'User',
				  'conditions' => '',
				  'order'      => '',
                  'fields'     => 'id, username, avatar',
                  'foreignKey' => 'user_id'
				  ),
               'Subject' =>
			    array('className'  => 'Subject',
				      'conditions' => '',
				      'order'      => '',
                      'fields'     => 'title',
                      'foreignKey' => 'subject_id'
				  )
			    ); 

/**
 *  CakePHP hasMany relation
 *  @access public
 *  @var array
 */
 public $hasMany = array('Annotation' =>
                        array('className'     => 'Annotation',
			                  'conditions'    =>  Null,
			                  'order'         => 'Annotation.id',
			                  'limit'         =>  Null,
			                  'foreignKey'    => 'lesson_id'
		              )
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
  'body' => array(
                    'rule'       => array('minLength', 8),
                    'message'    => 'Lesson must be at least 8 characters long',
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
 *  Get commments in lessons
 *  @param integer $blogger_id
 *  @access public
 *  @return void 
 */
 public function getComments($blogger_id)
 {
  $this->bindModel(array('hasMany' => array('Annotation' =>
                         array('className'     => 'Annotation',
                               'conditions'    => Null,
                               'order'         => 'Annotation.created DESC',
                               'limit'         => Null,
                               'foreignKey'    => 'lesson_id',
                               'dependent'     => True,
                               'exclusive'     => False,
                               'finderQuery'   => ''
                         )
                  )));

  $params = array('conditions'   => array('Lesson.user_id'=>$blogger_id),
                  'fields'       => array('Lesson.title', 'Lesson.id'),
                  'order'        => 'Lesson.id DESC',
                  'limit'        => 50,
                  'recursive'    => 2,
                  'contain'      => False);
  $data    = $this->find('all', $params); 
  
  foreach($data as $k=>$v):
      if ( count($v['Annotation']) < 1):
          unset($data[$k]); 
      endif;
  endforeach;

  return $data;
 }

/**
 *  Sum 1 to number of times this lesson has been saw
 *  @param integer $lesson_id
 *  @access public
 *  @return void 
 */  
 public function addVisit($lesson_id)  
 { 
   $conditions = array('Lesson.id'=>$lesson_id); 
   $visits = (int) $this->field('visits',$conditions);
         
   $this->id  = (int) $lesson_id; 
   $n_visits  = (int) ($visits + 1);
    
   if ( $this->saveField('visits', $n_visits) ):
        return True;
   else:
        die('Error on addVisit function');
   endif;
   return True;
 }
}
# ? > EOF

