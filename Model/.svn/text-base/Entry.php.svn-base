<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package blog
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Model/Entry.php

class Entry extends AppModel {

/**
 *  Load behaviours
 *  @access public   
 *  @var array
 */ 
 public $actsAs    = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
 public $belongsTo = array('User' =>
                           array('className'  => 'User',
                                 'conditions' => '',
                                 'fields'     => 'id, username, avatar',
                                 'foreignKey' => 'user_id'
                           ),
                           'Subject' =>
                           array('className'  => 'Subject',
                                 'conditions' => '',
                                 'order'      => Null,
                                 'foreignKey' => 'subject_id'
                           )
                     );

/**
 *  CakePHP hasMany relationship
 *  @access public
 *  @var array
 */
 public $hasMany = array('Comment' =>
                         array('className'     => 'Comment',
                               'fields'        => 'id, comment, user_id, created, status, username, email, website',
                               'conditions'    => 'Comment.status = 1',
                               'order'         => 'Comment.created',
                               'limit'         => Null,
                               'foreignKey'    => 'entry_id'
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
                    'message'    => 'Entry must be at least 8 characters long',
		            'allowEmpty' => False,
                    'required'   => True
		    ),
  'user_id' => array(
		              'rule'      => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True
		     )
   );


/**
 * BeforeSave usein ajax autosave
 * @access public
 * @return mixed array or Null
 */
  public function beforeSave($options = array())
  {
   parent::beforeSave(); 
   if (!$this->id && !isset($this->request->data[$this->alias][$this->primaryKey])):
       $order = $this->field('order','id > 0','order DESC');
       if ( !$order ):
           $order = (int) 1;
       else:
           $order = (int) $order + 1;
       endif;
       #echo var_dump($order);
       #$this->data['order']   = (int) $order;
       $this->data['Entry']['order'] =  (int) $order;
   endif;
   return True;
 }

/**
 * Get comments on this blog
 * @access public
 * @param integer $blogger_id
 * @return mixed array or Null
 */
 public function getComments($blogger_id)
 {

  $data  = $this->Comment->find('all', array(
                  'conditions' => array('Comment.blogger_id'=>$blogger_id),

                  'order'      => 'Comment.id DESC',
                  'limit'      => 50,
                  'recursive'  => 2
                        ));
  #die(debug($data));
  #remove entries without comments
  foreach($data as $k=>$v):
      if ( count($v['Comment']) < 1):
          unset($data[$k]);
      endif;
  endforeach;

  return $data;
 }

/**
 * Sum 1 to number of times this blog has been visited
 * @access public
 * @param integer $user_id
 * @return boolean
 */
  public function addVisit($user_id)
  {
    $conditions = array('User.id'=>$user_id);
    $visits = $this->User->field('visits', $conditions);

    $this->User->id  = (int) $user_id;
    $n_visits        = (int) ($visits + 1);

    if ( $this->User->saveField('visits', $n_visits) ):
        return True;
    else:
        return False;
    endif;

    return True;
  }

/**
 * Sum 1 to number of times this entry has been saw
 * @access public
 * @return int
 */ 
 public function totalVisits($user_id) 
 { 
   $visits = (int) 0;
   $params = array(
             'conditions' => array('Entry.status'=>1, 'Entry.user_id'=>$user_id),
             'fields'     => array('Entry.visits'),
             'contain'    => False
             );
     
   $fields =  $this->find('all', $params);
   foreach($fields as $f):
         $visits  += $f['Entry']['visits'];
   endforeach;
   
   return $visits;
 }
}

# ? > EOF
