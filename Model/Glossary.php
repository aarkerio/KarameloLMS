<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package glossaries
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /app/models/glossary.php

class Glossary extends AppModel {

  public $name        = 'Glossary';
	 
  public $belongsTo  = array(
             'User' => array(
                        'className' => 'User'
                          ),
             'Catglossary' => array(
                        'className' => 'Catglossary'
                          )
             );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */    
 public $validate = array(
			     'item' => array('rule'       => array('minLength', 3),
                                 'required'   => True,
						         'message'    => 'Item at least three characters',
                                 'allowEmpty' => False
                                ),
			     'definition' => array('rule' => array('minLength', 10),
                                       'required'   => True,
						               'message'    => 'Definition least ten characters',
                                       'allowEmpty' => False
                                      ),
                             'catglossary_id' => array('rule' => array('minLength', 1),
                                       'required'   => True,
						               'message'    => 'Catglossary can not be empty',
                                       'allowEmpty' => False
                                                       )
   );
}
# ? > EOF
