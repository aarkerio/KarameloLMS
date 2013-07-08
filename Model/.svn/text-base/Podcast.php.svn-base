<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package podcasts
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/Model/Podcast.php


class Podcast extends AppModel {
 
/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */  
  public $actsAs   = array('Containable');
    
/**
 *  CakePHP belongsTo
 *  @access public    
 *  @var array
 */ 
  public $belongsTo  = array(
                             'User' => array(
				             'className'  => 'User',
                             'foreignKey' => 'user_id'
                                            ),
                             'Subject' => array(
						      'className' => 'Subject',
                                                      'foreignKey' => 'subject_id'
                              )
                          );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
   public $validate = array(
                      'title'       => array(
			                              'rule'	 => array('minLength', '4'),
                                          'message'  => 'Mimimum 4 characters long'), 
                      'description' => array(
			                              'rule' 	 => array('minLength', '8'),
                                          'message'  => 'Description must be at least 8 characters long') 
                           );
}

# ? > EOF
