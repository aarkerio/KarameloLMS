<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package faqs
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/faq.php

class Faq extends AppModel {

 public $belongsTo   = 'Catfaq';    
  
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
         'question' => array('rule'       => array('minLength', 2),
                             'message'    => 'Mimimum 2 characters long',
			                 'allowEmpty' => false,
                             'required'   => true
		           ),
          'answer' => array('rule'       => array('minLength', 2),
			                'message'    => 'Mimimum 2 characters long',
			                'allowEmpty' => false,
                            'required'   => true
		            ),
           'catfaq_id' => array(
		                'rule'       => 'numeric',
                        'allowEmpty' => false,
                        'required'   => true 
		       )
	         ); 
}
# ? > EOF
