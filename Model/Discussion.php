<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/models/discussion.php

class Discussion extends AppModel
{

/**
 *  CakePHP Model class name
 *  @access public
 *  @var string
 */
  public $name = 'Discussion';

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */  
  public $belongsTo = array(
                           'News' =>
                            array('className'     => 'News',
                                  'conditions'    => Null,
                                  'order'         => Null,
                                  'limit'         => Null,
                                  'foreignKey'    => 'new_id',
                                  'dependent'     => True,
                                  'exclusive'     => False,
                                  'finderQuery'   => ''
			       ),
                          'User' =>
                            array('className'     => 'User',
                                  'conditions'    => Null,
                                  'fields'        => 'id, username, avatar',
                                  'order'         => Null,
                                  'limit'         => Null,
                                  'foreignKey'    => 'user_id',
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
	                  'comment' => array(
					       'rule' => array('minLength', 4),  
                           'message' => 'Comment must be at least 4 characters long.'
					 ) 
			  );
}

# ? > EOF
