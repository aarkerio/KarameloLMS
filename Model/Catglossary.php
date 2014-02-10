<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package glossary
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Model/Catglossary.php

class Catglossary extends AppModel
{
/**
 *  CakePHP Model class name
 *  @access public
 *  @var array
 */
  public $name      = 'Catglossary';

/**
 *  CakePHP behaviour
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
                         array('className'      => 'User',
                               'conditions'     => Null,
	                           'fields'         => Null,
                               'order'          => Null,
                               'limit'          => Null,
                               'foreignKey'     => 'user_id'
                           )
                         );
    
/**
 *  CakePHP hasMany relationship
 *  @access public
 *  @var array
 */
 public $hasMany = array('Glossary' =>
			             array('className'   => 'Glossary',
                               'foreignKey'  => 'catglossary_id',
                               'conditions'  => '',
                               'order'       => 'Glossary.display ASC'
                         )
                  );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */    
 public $validate = array(
              'title' => array(
                              'rule'       => array('minLength', 8),
                              'message'    => 'Title must be at least 8 characters long',
		                      'allowEmpty' => False,
                              'required'   => True 
		    ),
      
              'description' => array(
                              'rule'       => array('minLength', 8),
                              'message'    => 'Field must contain at least 10 characters',
		                      'allowEmpty' => False,
                              'required'   => True 
		    )
   );

/**
 * Set Glossary conditions
 * @access public
 * @param string
 * @return void
 */
 public function setGC($status)
 {
   $this->glossCond = array('Glossary.status' => $status);
 }
}

# ? > EOF
