<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Subject.php

class Subject extends AppModel {

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
  public $actsAs  = array('Containable');


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
    'code' => array(
                    'minLength'=>array(
                                'rule'       => array('minLength', 2),
                                'message'    => 'Field must be at least two characters long',
	  	                        'allowEmpty' => False,
                                'required'   => True 
	          		             ),
		            'isUnique'   =>array(
                                'rule'    => 'isUnique',
                                'message' => 'This field should be unique'
                                   )
		   )
   );

/**
 * Get Lesson, Share POdcast, and entries belong to this subject 
 * used in  /subjects/view/  view. 
 * @param string $code
 * @access public
 * @return mixed  array or Null
 */
 public function getSubject($code)
 {
  try{
     $data   = array();
     $params = array('conditions' => array('Subject.code'=>$code), 
                   'fields'     => array('Subject.id', 'Subject.code', 'Subject.title'),
                   'contain'    => False
                   );
     $data['S']  = $this->find('first', $params);
     
     $params = array('conditions'     => array('Lesson.subject_id'=>$data['S']['Subject']['id'], 'Lesson.public'=>1),
                     'fields'         => array('Lesson.id', 'Lesson.title', 'User.username', 'User.id'),
                     'order'          => 'Lesson.id DESC',
                     'limit'          => 10);
     $this->_bindFly();
     $data['Lesson'] = $this->Lesson->find('all', $params);

     $params = array('conditions'     => array('Entry.subject_id'=>$data['S']['Subject']['id']),
                     'fields'         => array('Entry.id', 'Entry.title', 'User.username', 'User.id'),
                     'order'          => 'Entry.id DESC',
                     'limit'          => 10);
     $this->_bindFly();
     $data['Entry']  = $this->Entry->find('all', $params);

     $params = array('conditions'     => array('Share.subject_id'=>$data['S']['Subject']['id'], 'Share.public'=>1),
                   'fields'         => array('Share.secret', 'Share.description', 'User.username', 'User.id'),
                   'order'          => 'Share.id DESC',
                   'limit'          => 10);
     $this->_bindFly();
     $data['Share']  = $this->Share->find('all', $params);

   return $data;
  }

  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }

/**
 *  Not cool for works
 *  @access private
 *  @return void
 */
 private function _bindFly()
 {

 $this->bindModel(array('hasMany' => array('Lesson' =>
                         array('className'     => 'Lesson',
                               'conditions'    => 'status=1',
                               'order'         => 'id DESC',
                               'limit'         => 10,
                               'fields'        => 'id, title',
                               'foreignKey'    => 'subject_id',
                               'dependent'     => True,
                               'exclusive'     => False,
                               'finderQuery'   => ''
                         ),
			       'Share' =>
                         array('className'     => 'Share',
                               'conditions'    => 'public=1',
                               'order'         => Null,
                               'fields'        => 'secret, description',
                               'limit'         => 10,
                               'foreignKey'    => 'subject_id',
                               'dependent'     => True,
                               'exclusive'     => False,
                               'finderQuery'   => ''
                         ),
                       'Entry' =>
                         array('className'     => 'Entry',
                               'conditions'    => 'status=1',
                               'order'         => 'id DESC',
                               'limit'         => 10,
                               'fields'        => 'id, title',
                               'foreignKey'    => 'subject_id',
                               'dependent'     => True,
                               'exclusive'     => False,
                               'finderQuery'   => ''
			       )))
                  );
  }
}

# ? > EOF
