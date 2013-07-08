<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package forums
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/catforum.php

class Catforum extends AppModel
{

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
  public $belongsTo = array('User' =>
			                  array('className' => 'User')
			               );

/**
 *  CakePHP hasMany relationship
 *  @access public
 *  @var array
 */
  public $hasMany = array('Forum' =>
                         array('className'     => 'Forum',
                               'conditions'    => Null,
                               'order'         => 'id',
                               'limit'         => Null,
                               'foreignKey'    => 'catforum_id',
                               'dependent'     => True,
                               'exclusive'     => False,
                               'finderQuery'   => ''
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
   'description' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Field must be at least 4 characters long',
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
}

# ? > EOF
