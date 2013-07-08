<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package forums
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/forum.php

class Forum extends AppModel {

 public $actsAs   = array('Containable'); 

 public $hasMany = array('Topic' => 
                                     array('className'  => 'Topic', 
                                           'foreignkey' => 'forum_id',
                                           'conditions' => Null,
                                           'order'      => 'id DESC',
                                           'fields'     =>  Null
                                           )
				     );

 public $belongsTo = array('Catforum' => 
                                     array('className' => 'Catforum', 
                                           'foreignkey' => 'catforum_id'),
                          'Vclassroom' => 
                                     array('className' => 'Vclassroom', 
                                           'foreignkey' => 'vclassroom_id'),
                          'User' => 
                                     array('className' => 'User', 
                                           'foreignkey' => 'user_id')
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
  'description' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Description must be at least 4 characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),
  'catforum_id' => array(
		              'rule'      => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', // but not on update
                     'required'   => True 
		     )
   );

}
# ? > EOF
