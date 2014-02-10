<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/group.php

class Group extends AppModel
{
  public $name    = 'Group';

  public $actsAs = array('Acl' => array('requester'));

  public $hasMany = array('User'=>array('className' =>'User')); 

  public $validate = array(
        'code'      => array(
                             'required'  => True,
                             'rule'      => array('minLength', 5),  
                             'message'   => 'Code must be at least 5 characters long.' 
                            )
                          );
/**
 *  ACL stuff
 */
  public function parentNode() 
  {
    return Null;
  }
}
# ? > EOF
