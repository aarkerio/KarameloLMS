<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package polls
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Model/Poll.php

class Poll extends AppModel {

  public $hasMany = array('Pollrow' =>
                         array('className'     => 'Pollrow',
                               'conditions'    => null,
                               'order'         => 'id',
                               'limit'         => null,
                               'foreignKey'    => 'poll_id',
                               'dependent'     => true,
                               'exclusive'     => false,
                               'finderQuery'   => ''
                         )
                  );
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'question' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Title must be at least four characters long',
		    'allowEmpty' => false,
                    'required'   => true 
		    )
   );
}

# ? > EOF
