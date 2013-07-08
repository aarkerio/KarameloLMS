<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package ecourse
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /APP/Model/Ecourse.php

class Ecourse extends AppModel {

/**
 *  CakePHP Model class name
 *  @access public
 *  @var string
 */  
  public $name        = 'Ecourse'; 

/**
 *  CakePHP Model behaviours
 *  @access public
 *  @var string
 */
  public $actsAs      = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
  public $belongsTo   = array('User', 'Subject', 'Lang');
  
/**
 *  CakePHP hasMany relationship
 *  @access public
 *  @var array
 */
  public $hasMany   =  array(
               'Vclassroom' =>
			    array( 
				      'className'  =>  'Vclassroom',     
				      'foreignKey' =>  'ecourse_id', 
				      'order'      =>  'name'
                     ),
               'Activity' =>
			    array( 
				      'className'  =>  'Activity',     
				      'foreignKey' =>  'ecourse_id',
                      'order'      =>  'Activity.order'
                     )
   );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
        'title' => array(
                'alphanumeric' => array(
                'rule'       => array('minLength', 4),
                'required'   => True,
		        'allowEmpty' => False,
                'message'    => 'Title must be at least four characters long'
                )
        ),
        'description'    => array(
                'rule'       => array('minLength', 20),
                'allowEmpty' => False,
                'message'    => 'Mimimum 20 characters long'
        )
    );

/**
 *  Show filed vclassrooms
 *  Deprecated ?
 */
 public function filed() 
 {
      $this->unbindModel(array('hasMany'=>array('Vclassroom')));

      $this->bindModel( array('hasMany' => array('Vclassroom' =>
			                                   array( 
	                                                 'className'  =>  'Vclassroom',     
				                                     'foreignKey' =>  'ecourse_id', 
				                                     'conditions' =>  'status = 0'
                                                     )
							       ))
				      );
     return True; 
  }
    
/** 
 * getPoints Get ecourse total points 
 * @access public
 * @param  integer $ecourse_id
 * @return integer points 
 */
 public function getPoints($ecourse_id)
 {
  $points = (int) 0;
  $params = array('conditions' => array('Activity.ecourse_id'=>$ecourse_id, 'Activity.status'=>1),
                  'fields'     => array('Activity.points'));
  $data  = $this->Activity->find('all', $params);
  foreach($data as $v):
      $points += $v['Activity']['points'];
  endforeach;
  
  return $points;
 }

/** 
 * getMinutes Get ecourse total minutes 
 * @access public
 * @param  integer $ecourse_id
 * @return integer minutes 
 */
 public function getMinutes($ecourse_id)
 {
  $minutes  = (int) 0;
  $params   = array('conditions' => array('Activity.ecourse_id'=>$ecourse_id, 'Activity.status'=>1),
                  'fields'     => array('Activity.minutes'));
  $data     = $this->Activity->find('all', $params);
  foreach($data as $v):
      $minutes += $v['Activity']['minutes'];
  endforeach;
  
  return $minutes;
 }


/**
 *  Return shared eCourses
 *  @access public
 *  @return mixed array or Null
 */
 public function getKnet()
 {
   $params = array('conditions' => array('Ecourse.knet' => 1),
                   'fields'     => array('Ecourse.title', 'Ecourse.id'),
                   'contain'    => array('User'=>array('conditions'=>array('User.active'=>1),'fields'=>array('User.username')))
                  );
   return $this->find('all', $params);
 }


/**
 * getActivities 
 * @access public
 * @param integer $user_id
 * @param integer $ecourse_id
 * @return array  empty or populated
 */
 public function getActivities($user_id, $ecourse_id)
 {
  $conditions =  array('Ecourse.user_id'=>$user_id, 'Ecourse.id'=>$ecourse_id);
  $fields     =  array('Ecourse.id', 'Ecourse.title');
  $fieldsAct  =  array('Activity.id',  'Activity.order', 'Activity.title', 'Activity.points',  'Activity.status', 'Activity.minutes'); 
  $data = $this->find('first', array('fields'=>$fields, 'conditions'=>$conditions, 
                                            'contain' => array(
                                                    'Activity' => array(
                                                                 'conditions' => array('Activity.ecourse_id'=>$ecourse_id),
                                                                 'order'      => 'Activity.order ASC',
                                                                 'fields'     => $fieldsAct
                                                                       ))));
  $data['Ecourse']['points']  = (int) $this->getPoints($ecourse_id);
  $minutes = (int) $this->getMinutes($ecourse_id);
  $data['Ecourse']['hours'] = ($minutes/60);

  return $data;
 }

/**
 * getEcourses
 * @access public
 * @return array  empty or populated
 */
 public function getEcourses()
 {
  $conditions   =  array('Ecourse.status'=>1, 'Ecourse.public'=>True);
  $fields       =  array('Ecourse.id', 'Ecourse.title');
  $fieldsUser   =  array('User.id',  'User.username', 'User.avatar'); 
  $data = $this->find('all', array('fields'=>$fields, 'conditions'=>$conditions, 
                                            'contain' => array(
                                                               'User'    => array('fields'=> $fieldsUser),
                                                               'Subject' => array('fields'=> array('id', 'title'))
                                                               )));
  return $data;
 }

/**
 * diploma  Generate student diploma when points are gathered
 * @access public
 * @param array $data
 * @return boolean
 */
 public function diploma($data=array())
 {
   App::import('Model','College');
   $College = new College;
   $college = $College->read(array('name', 'logo'), 1);
   #die(debug($college));
   $diploma = imagecreatefrompng('../webroot/img/admin/diploma_karamelo.png');
   # create image with text
   $width  = 500;
   $height = 400;
   $image = imagecreate($width, $height);
   $background = imagecolorallocate($image, 255, 255, 255);
   # sets some colors
   $white = imagecolorallocate($image, 255, 255, 255);
   $black = imagecolorallocate($image, 0, 0, 0);
   /* colors of image - tries to be difficult
    * creates a wine background
    * and similar letter color */

   /* NOTE:
    * 28 = font size 
    * 20 = gives the text a slight angle 
    * 15,70 = the X and Y coordinates of text */
   $date  = date("F j, Y"); ;
   $text   = $date."\n\n" . $college['College']['name'] ."\n\n\n"; 
   $text  .= __('Otorga el presente diploma a', True).":\n\n". "           ".$data['name']."\n\n";
   $text  .= __('Por aprobar satisfactoriamente el curso', True) .":\n\n            ". $data['e']['Ecourse']['title']. "\n";
   
   putenv('GDFONTPATH=' . realpath('../vendors/chipotle/ttf/'));
   putenv('gdfontpath=../vendors/chipotle/ttf/'); 
   $font = '../Vendor/chipotle/ttf/elephant.ttf';
   #if (file_exists($font))     die('no font');
    
   #imagettftext  ( resource $image, float $size, float $angle, int $x, int $y  , int $color  , string $fontfile  , string $text  )
   #$black = imagecolorallocate($im, 0, 0, 0);
   #$im = imagecreate(100, 100);
   # sets background to red
   #$bg = imagecolorallocate($im, 10, 10, 10);
   imagettftext($image, 14, 0, 15, 70, $black, $font, $text);
   imagecopymerge($diploma, $image,  210, 560, 0, 0, $width, $height, 100);
   # have a different name everytime we show the image
   
   
   #$diploma = '../webroot/img/admin/diploma_karamelo.png';
   $logo    = (string) '../webroot/img/static/'.$college['College']['logo'];
   $size    = getimagesize($logo); 
   #die(debug($size));
   switch ($size['mime']):
       case "image/gif":
           $image = imagecreatefromgif($logo);
           break;
       case "image/jpeg":
           $image = imagecreatefromjpeg($logo);
           break;
       case "image/png":
           $image = imagecreatefrompng($logo);
           break;
       case "image/bmp":
           $image = imagecreatefrombmp($logo);
           break;
   endswitch;
   
   # Copy and merge
   #                             $diploma_x , $diploma_y , $image_x  , int $image_y  , int $src_w  , int $src_h  , int $pct)
   imagecopymerge($diploma, $image,  210, 450, 0, 0, $size[0], $size[1], 100);
   $seal  = imagecreatefromjpeg('../webroot/img/static/emblem-excellence-seal.jpg');
    imagecopymerge($diploma, $seal,  560, 860, 0, 0, 170, 163, 100);
   # Output and free from memory
   header('Content-type: image/png');
   imagepng($diploma);

   imagedestroy($diploma);
   imagedestroy($image);
   return False; 
 }
}

# ? > EOF
