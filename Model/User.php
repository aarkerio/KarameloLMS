<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/User.php

App::uses('AuthComponent', 'Controller/Component');
 
class User extends AppModel {

/**
 * CakePHP Class Name
 * @access public
 * @var string
 */
  public $name = 'User';

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
  public $actsAs  = array('Acl' => array('requester'), 'Containable');
 
/**
 *  Used searching users
 *  @access public    
 *  @var array
 */ 
 public $Keywords = array();

/**
 *  CakePHP belongsTo
 *  @access public    
 *  @var array
 */  
 public $belongsTo = array('Group' => array('className' => 'Group' ));

/**
 *  CakePHP hasOne
 *  @access public    
 *  @var array
 */
 public $hasOne = array('Profile' => array(
                                           'className'    => 'Profile',
                                           'dependent'    => True
                                           )
                        );
/**
 *  hasMany
 *  @access public 
 *  @var array
 */     
 public $hasMany = array(
    'UserVclassroom' => array(
      'className' => 'UserVclassroom'
    ),
    'Entry' => array(
      'className' => 'Entry'
    ),
    'Faq' => array(
      'className' => 'Faq'
    ),
    'Acquaintance' => array(
      'className' => 'Acquaintance'
    ),
    'Lesson' => array(
      'className' => 'Lesson'
    ),
    'Confirm' => array(
      'className' => 'Confirm'
    )
  );

/**
 *  validate  CakePHP framework array element
 *  @access public
 *  @public array
 */
 public $validate = array(
   'username' => array(
                        array(
                            'rule'       => array('minLength', 5),
                            'message'    => 'Username must be at least 5 characters long',
	                        'allowEmpty' => False,
                            'on'         => 'create',   # but not on update
		                    'required'   => True
			                 ),
                      array(
		                    'rule'    => 'isUnique',
                            'message' => 'This username has already been taken',
                            'on'         => 'create',   # but not on update
		                   )
		               ),
   'email' => array(
		              array(
                            'rule'       => array('minLength', 8),
                            'message'    => 'Email must be at least 8 characters long',
	                        'allowEmpty' => False,
                            'on'         => 'create',   # but not on update
		                    'required'   => True
			                 ),
                      array(
		                    'rule'    => 'isUnique',
                            'message' => 'This email has already been taken',
                            'on'      => 'create',   # but not on update
                            ),
                      array(
                            'rule'    => array('email'),
                            'message' => 'Please supply a valid email address',
                            'on'      => 'create',   # but not on update
                            )
                      ),
  'name'      => array(
		              array(
                            'rule'       => array('minLength', 8),
                            'message'    => 'Name must be at least 8 characters long',
	                        'allowEmpty' => False,
                            'on'         => 'create',   # but not on update
		                    'required'   => True
			                 ),
		               ),
  'group_id' => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'required'   => True,
                     'on'         => 'create',   # but not on update
		     )
   );

/**
 * Kandies models
 * @access private
 * @var array
 */
 public $kandies = array('Gap', 'Test', 'Webquest', 'Treasure', 'Ecourse');

/**
 * CakePHP Callback
 * @param array $options
 * @access private
 * @var array
 */
 public function beforeSave($options = array()) 
 {
  if ( isset($this->data['User']['pwd']) ):
      $this->data['User']['pwd'] = AuthComponent::password($this->data['User']['pwd']);
  endif;
  return True;
 }

/**
 *  Return all Knets in site
 *  @access public
 *  @return mixed array or Null
 */  
 public function findKnets()  
 { 
  $data = array(); 
  #$k = 'Gap';
  foreach( $this->kandies as $k ):
      $this->bindModel(array('hasMany'=>array("{$k}")));
      $data["{$k}"] = $this->{$k}->getKnet();
  endforeach;
  #die(debug($data));
  return $data;
 }
 
/*
 * getVclassrooms Get vclassrooms subscribed by student or teacher 
 * @params integer $user_id 
 * @params boolean $only_my_owns   I am a teacher
 * @return mixed array or null
 * @access public
 */
 public function getVclassrooms($user_id, $only_my_owns=False)
 {
   $this->UserVclassroom->bindModel(array('belongsTo'=>array('Vclassroom')));
   $conditions =  array('UserVclassroom.user_id' => $user_id,  'Vclassroom.historical'=>0);
   if ( $only_my_owns ):
      $conditions['UserVclassroom.kind']= 1;
   endif;
   $params = array('conditions' => $conditions,
                   'fields'     => array('Vclassroom.id',  'Vclassroom.name'),
                   'recursive'  =>1 
                 );
   $data = $this->UserVclassroom->find('list', $params);
   #die(debug($data));
   return $data;
 }

/**
 * getTeachers  this method return array with teachers and invited teachers or tothors (user_id(s)) and emails related to specific Vclassroom
 * @param $vclassroom_id int
 * @return mixed array
 * @access public
 */
 public function getTeachers($vclassroom_id)
 {
 try{
   $params = array('conditions' => array('UserVclassroom.vclassroom_id' => $vclassroom_id, 'UserVclassroom.kind >' => 0),
                   'fields'     => array('UserVclassroom.user_id')
                  );
   $data = $this->UserVclassroom->find('all', $params);
   
   foreach ($data as $k=>$v):
       $data[$k]['UserVclassroom']['email'] = $this->field('email', array('User.id'=>$v['UserVclassroom']['user_id']));
   endforeach;
   #die(debug($data));
   return $data;
  }
  catch (Exception $e) 
  {
      echo "Caught my exception\n" . $e;
  }   
 }

/** 
 * Search for user(s)
 * @access public 
 * @param string $keyword 
 * @param string $lang
 * @return mixed array or Null
 */
 public function search($keywords, $lang)
 {
  $this->Keywords = explode(' ', $keywords); # convert to array for loop
  #die(debug($this->Keywords));
  $u = (string) '';
  foreach($this->Keywords as $k=>$t):
     if ($k != 0):
         $u .=' or ';
     endif;
     $u .='"User"."name" ILIKE \'%'.$t.'%\' or "User"."email" ILIKE \'%'.$t.'%\' or "Profile"."matricula" ILIKE \'%'.$t.'%\' or "User"."username" ILIKE \'%'.$t.'%\'';
  endforeach;
  #die(debug($t));
  $q  = 'SELECT DISTINCT "User"."id" AS "User__id", "User"."username" AS "User__username","User"."name" AS "User__name", "Profile"."matricula" AS "Profile__matricula", ';
  $q .= '"User"."active" AS "User__active","User"."group_id" AS "User__group_id","Profile"."created" AS "Profile__created", ';
  $q .= '"Group"."name" AS "Group__name", ';
  $q .= '"User"."email" AS "User__email" FROM "users" AS "User", "profiles" as "Profile", "groups" AS "Group"  WHERE ';
  $q .= '('.$u.')';
  $q .= ' and ("User"."id" = "Profile"."user_id") and ("User"."group_id" = "Group"."id")';
  #die(debug($q));
  $data = $this->query($q);
  #die(debug($data));
  return $data;
 }

/**
 * getKandies  This method get all shared kandies in this Karamelo server
 * @return mixed array
 * @access public
 */
 public function getKandies()
 {
 try{
  # Get gaps
  $data   = array();
  $params = array(
                  'conditions' => array('Gap.knet' => 1),
                  'fields'     => array('Gap.user_id', 'Gap.title')
                 );
  $data['Gap'] = $this->Gaps->find('all', $params);

  # Get scavenger hunts
  $params = array(
                  'conditions' => array('Treasure.knet' => 1),
                  'fields'     => array('Treasure.user_id', 'Treasure.title')
                 );
  $data['Treasure'] = $this->Treasure->find('all', $params);
  
 
   #die(debug($data));
   return $data;
  }
  catch (Exception $e) 
  {
      echo "Caught my exception\n" . $e;
  }   
 }

/** 
 * Acl connection   http://book.cakephp.org/view/645/Acts-As-a-Requester
 * @access public
 * @return mixed array or Null
 */
 public function parentNode() 
 {
   if (!$this->id && empty($this->data)):
        return null;
   endif;
   $foreignKey = 'group_id';
   $data = $this->data;
   if (empty($data)):
       $data = $this->read();
   endif;
   if (!isset($data[$this->alias][$foreignKey])):
       $data[$this->alias][$foreignKey] = $this->field($foreignKey);
   endif;
   if (!array_key_exists($foreignKey, $data[$this->alias]) || empty($data[$this->alias][$foreignKey])):
       return null;
   endif;
   return array('Group' => array('id' => $data[$this->alias][$foreignKey]));
}


/**
 * After save callback, Update the aro for the user. Every time user is update this method launched
 * @access public
 * @return void
 */
 public function afterSave($created) 
 {
  if (!$created):    # The value of $created will be true if a new record was created (rather than an update).
      $parent = $this->parentNode();
      $parent = $this->node($parent);
      #die(debug($parent));  # contains group_id
      $node = $this->node();
      $aro = $node[0];
      $aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
      #die(debug($aro));
      $this->Aro->save($aro);
  endif;
  } 
}

# ? > EOF
