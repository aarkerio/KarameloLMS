<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Chipotle Software(c)  2006-2012
*  @version 0.7
*  @package quotes
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/Model/Quote.php

class Quote extends AppModel {

 public $name = 'Quote';

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
		    'quote' => array(
				           'rule' => array('minLength', '4'),
                           'message' => 'Mimimum 4 characters long'
				            ),
			'author' => array(
				           'rule' => array('minLength', '4'),
                           'message' => 'Mimimum 4 characters long'
                            ),
            'user_id' => array(
                           'rule'       => 'numeric',
                           'allowEmpty' => False,
                           'on'         => 'create',   # but not on update
                           'required'   => True 
                          )
			 );

/**
 *  Test PHPUnit Method
 *
 */
 public function threeQuotes($user_id=1)
 {
  $params = array('conditions' => array('user_id'=>$user_id),
                  'order '     =>'id ASC',
                  'limit'      => 3
                 );
  $result  =  $this->find('all', $params);
 
  return $result;
 }

}

# ? > EOF
