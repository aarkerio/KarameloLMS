<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package faqs
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /app/models/catfaq.php

class Catfaq extends AppModel {

/**
 *  CakePHP Model class name
 *  @access public
 *  @var array
 */
 public $name    = 'Catfaq';

/**
 *  CakePHP behaviour
 *  @access public
 *  @var array
 */
 public $actsAs  = array('Containable');
 
/**
 *  CakePHP hasMany
 *  @access public
 *  @var array
 */
 public $hasMany = array('Faq' =>
                        array('className'     => 'Faq',
			                  'conditions'    =>  Null,
			                  'order'         => 'Faq.display ASC',
			                  'limit'         => Null,
			                  'foreignKey'    => 'catfaq_id',
			                  'dependent'     => True,
		                      'exclusive'     => False,
		                      'finderQuery'   => ''
		              )
		         );

/**
 *  validate  CakePHP framework array element
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
                    'rule'       => array('minLength', 10),
                    'message'    => 'Field must contain at least 10 characters',
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
