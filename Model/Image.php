<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package images
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/image.php
class Image extends AppModel
{
    public $name        = 'Image';

    public $belongsTo = array('User' =>
                           array('className'  => 'User',
                                 'conditions' => '',
                                 'fields'     => 'id, username',
                                 'foreignKey' => 'user_id'
                           )
                          );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'file' => array(
                  'rule'       => array('minLength', 4),
                  'message'    => 'File be at least four characters long',
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

/**
 *  New validation rule
 *  @acces public
 *  @return void 
 */
 public function isUploadedFile($params)
 {
  $val = array_shift($params);
  if ((isset($val['error']) && $val['error'] == 0) or (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')):
      return is_uploaded_file($val['tmp_name']);
  endif;
  return False;
 }
}
# ? > EOF
