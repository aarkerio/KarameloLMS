<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.8
*  @package ecourses
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/Model/Vclassroom.php

class Vclassroom extends AppModel {

/**
 * Permissions array 
 * @access private
 * @var string
 */
  public $name       = 'Vclassroom';

/**
 * Actas
 * @access public
 * @var array
 */
  public $actsAs     = array('Containable');

/**
 * Permissions array 
 * @access private
 * @var array
 */
  private $__Kandies = array(
       'Test'    => array('origin'=>'Test',      'model'=>'TestVclassroom',     'model_id'=>'test_id',     'results'=>'Result'),
       'Gap'     => array('origin'=>'Gap',       'model'=>'GapVclassroom',      'model_id'=>'gap_id',      'results'=>'ResultGap'),
       'Treasure'=> array('origin'=>'Treasure',  'model'=>'TreasureVclassroom', 'model_id'=>'treasure_id', 'results'=>'ResultTreasure'),
       'Webquest'=> array('origin'=>'Webquest',  'model'=>'VclassroomWebquest', 'model_id'=>'webquest_id', 'results'=>'ResultWebquest'), 
       'Scorm'   => array('origin'=>'Scorm',     'model'=>'ScormVclassroom',    'model_id'=>'scorm_id',    'results'=>'ResultScorm')
    );

/**
 * belongsTo CakePHP Model relationship
 * @access public
 * @var array
 */
  public $belongsTo  = array('Ecourse' =>
	                   array('className'  => 'Ecourse',
                             'conditions' => '',
	                         'order'      => '',
	                         'foreignKey' => 'ecourse_id'
		                )
			    );
/**
 * hasMany CakePHP Model relationship
 * @access public
 * @var array
 */
  public $hasMany = array(
                 'UserVclassroom' =>
                          array('className'     => 'UserVclassroom',
                                'foreignKey'    => 'vclassroom_id'),
                 'TestVclassroom' =>
                          array('className'     => 'TestVclassroom',
                                'foreignKey'    => 'vclassroom_id'),
                 'TreasureVclassroom' =>
                          array('className'     => 'TreasureVclassroom',
                                'foreignKey'    => 'vclassroom_id'),
                 'GapVclassroom' =>
                          array('className'     => 'GapVclassroom',
                                'foreignKey'    => 'vclassroom_id'),
                 'VclassroomWebquest' =>
                          array('className'     => 'VclassroomWebquest',
                                'foreignKey'    => 'vclassroom_id'),
                 'ScormVclassroom' =>
                          array('className'     => 'Scorm.ScormVclassroom',
                                'foreignKey'    => 'vclassroom_id'),
                 'Forum' =>
	                      array('className'     => 'Forum',
			                    'conditions'    => Null,
			                    'order'         => Null,
			                    'limit'         => Null,
			                    'foreignKey'    => 'vclassroom_id',
			                    'dependent'     => True,
			                    'exclusive'     => False
			     ),
              'Participation' =>
		                  array('className' => 'Participation',
			                    'conditions'    => Null,
			                    'order'         => Null,
 			                    'limit'         => Null,
			                    'foreignKey'    => 'vclassroom_id'
			     ),
              'Report' =>
		                  array('className'  => 'Report',
			                    'conditions'    => Null,
			                    'order'         => Null,
			                    'limit'         => Null,
			                    'foreignKey'    => 'vclassroom_id'
			          ),
              'Chat' =>
		                  array('className' => 'Chat',
			                    'conditions'    => Null,
			                    'order'         => Null,
			                    'limit'         => Null,
			                    'foreignKey'    => 'vclassroom_id'
                     )
	        );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
public $validate = array('name' => array(
					                     'rule'       => array('minLength', 4),
					                     'required'   => True,
					                     'message'    => 'Title must be at least four characters long'
       			                    ));

/**
 * vcOnBlog -- show a list of Virtualclassrooms in edublog if VC are actived and in valid date
 * @access public
 * @param integer $user_id  Student ID
 * @return mixed  array data or False
 */
 public function vcOnBlog($user_id)
 {
  #kind          | smallint | not null default 0   | Owner 1, tuthor 2, or student 0
  $params = array('conditions' => array('Vclassroom.status'=>'1','Vclassroom.fdate >= CURRENT_DATE','Vclassroom.sdate <= CURRENT_DATE','UserVclassroom.kind'=>1,
                                        'UserVclassroom.user_id' => $user_id),
                  'fields'     => array('Vclassroom.id', 'Vclassroom.name'),
                  'limit'      => 10
                 );

  $data = $this->UserVclassroom->find('all', $params);
  #die(debug($data));
  return $data;
 } 

/*
 * chkDateKandie -- check if kandie have the correct dates to be show to student in edublog
 * @param integer $kandie_id  Kandie ID
 * @param integer $vclassroom__id VC ID
 * @param string  $kandie_model   Model name
 * @return bool   
 */
 public function chkDateKandie($kandie_id, $vclassroom_id, $kandie_model)
 {
  $m = $this->__Kandies[$kandie_model];
  #die(debug($model));
  $current = (string) 'current_timestamp';
  $params  = array('conditions' => array("{$m['model']}.vclassroom_id"=>$vclassroom_id, "{$m['model']}.{$m['model_id']}"=>$kandie_id,
                                         "$current > {$m['model']}.sdate", "$current < {$m['model']}.fdate"),
                  'fields'     => array("{$m['model']}.id"),
                  'recursive'  => 0 
                 );
  #die(debug($params));
  $data = $this->{$m['model']}->find('first', $params);
  #die(debug($data));
  if ( !$data):
      return False;
  else:
      return True;
  endif;
 } 

/*
 *  currentVclassroom -- return current teachers sharing this vClassroom
 *  @param integer $vclassroom_id
 *  @param integer $user_id
 *  @return mixed data array or False
 */
 public function currentVclassroom($vclassroom_id, $user_id)
 {
  $this->UserVclassroom->bindModel(array('belongsTo'=>array('Vclassroom', 'User')));
  $params = array('conditions' => array('UserVclassroom.kind >'        => 1,
                                        'UserVclassroom.vclassroom_id' => $vclassroom_id,
                                        'UserVclassroom.user_id !='   => $user_id),
                  'fields'     => array('User.id',  'User.name', 'User.username', 'User.avatar','UserVclassroom.id'),
                  'recursive'  => 1 
                 );
  $data = $this->UserVclassroom->find('all', $params);
  #die(debug($data));
  return $data;
 }

/**
 * vcShared -- Virtual Vclassrooms shared with other teachers
 *  @param integer $vclassroom_id
 *  @param integer $user_id
 *  @return mixed data array or False
 */
 public function vcShared($vclassroom_id, $user_id)
 {
  $this->UserVclassroom->bindModel(array('belongsTo'=>array('Vclassroom', 'User')));
  $params = array('conditions' => array('User.group_id <'=>'3', 'User.id !=' => $user_id, 'User.active'=>'1'),
                  'fields'     => array('User.id',  'User.name'),
                  'order'      => 'User.username',
                  'recursive'  => 1,
                  'contain'    => False 
                 );
  $teachers = $this->UserVclassroom->User->find('list', $params);
  #die(debug($teachers));
  foreach ($teachers as $k => $t):
      $field = $this->UserVclassroom->field('id', array('user_id'=>$k, 'vclassroom_id'=>$vclassroom_id));
      if ($field):
          unset($teachers[$k]);
      endif;
  endforeach;
  #die(debug($teachers));
  return $teachers;
 }


/**
 *  Get teachers Vclassroom(s), return array used in admin_listing method (VclassroomController.php)
 *
 * @param  integer $historic
 * @param  integer $user_id: 
 * @return mixed  array  $data or Null
 * @access public
**/
 public function getVclassrooms($historic, $user_id)
 {
  $historical = $historic ? 1 : 0 ;
  # I remake this method ein 1519 revision, check 1518 to see changes I made
  #$this->UserVclassroom->unbindModel(array('belongsTo'=>array('User')));
  $params = array('conditions' => array('UserVclassroom.kind != 0', 'UserVclassroom.user_id' => $user_id),
                  'contain' =>array('Vclassroom', 'Ecourse')
                  );    
  $data = $this->UserVclassroom->find('all', $params);

  #die(debug($data));
  foreach($data as $k => $v):
       $data[$k]['Ecourse']['title'] = $this->Ecourse->field('title', array('id'=>$v['Vclassroom']['ecourse_id']));
       $owner_id = $this->UserVclassroom->field('user_id', array('vclassroom_id'=>$v['Vclassroom']['id'], 'kind'=>1));
       $data[$k]['User']['username']       =  $this->UserVclassroom->User->field('username', array('id'=>$owner_id));
       $data[$k]['Vclassroom']['students'] =  $this->UserVclassroom->find('count', array('conditions'=>array('UserVclassroom.kind'=>0, 'UserVclassroom.vclassroom_id'=>$v['Vclassroom']['id'])));
  endforeach;
  #die(debug($data));
  return $data;
 }

/**
 *  Get full student record in Vclassroom , return array used in admin_record method (vclassrooms_controller.php)
 *
 * @param  integer $user_id:  in $fact student_id
 * @param  integer $vclassroom_id  description
 * @return array   $record description
 * @access public
 **/
 public function studentRecord($user_id, $vclassroom_id)
 {
  # See: http://trac.chipotle-software.com/karamelo/wiki/studentRecord
  try{
     $record  = $this->__studentPoints($user_id, $vclassroom_id);
     $record['Vclassroom']['id']   = (int) $vclassroom_id; # dirty but works     
     $record['Vclassroom']['name'] = (string) $this->field('name', array('Vclassroom.id'=>$vclassroom_id));
     $teacher_id = $this->UserVclassroom->field('user_id', array('vclassroom_id'=>$vclassroom_id, 'kind'=>1));
     $record['Owner'] = $this->UserVclassroom->User->field('username', array('id'=>$teacher_id));
     return $record;
  }

  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }
/**
 *  Send record to student
 *
 * @param  integer $user_id:  in $fact student_id
 * @param  integer $vclassroom_id  description
 * @return array   $record description
 * @access public
**/
 public function sendRecord($user_id, $vclassroom_id)
 {
  try{
     $record  = $this->__studentPoints($user_id, $vclassroom_id);
     $record['Vclassroom']['id']   = (int) $vclassroom_id; # dirty but works     
     $record['Vclassroom']['name'] = (string) $this->field('name', array('Vclassroom.id'=>$vclassroom_id));
     $teacher_id = $this->UserVclassroom->field('user_id', array('vclassroom_id'=>$vclassroom_id, 'kind'=>1));
     $record['Owner'] = $this->UserVclassroom->User->find('first', array('fields'=>array('User.username', 'User.email'), 'conditions'=>array('User.id'=>$teacher_id)));
     return $record;
  }

  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }


/**
 *  Get current Kandies linked to this vclassrooms
 *  @param integer $vclassroom_id
 *  @access public
 *  @return mixed array or null
 */       
 public function getKandies($vclassroom_id)
 { 
  $this->contain(array(
           'TestVclassroom'   => array(
                                       'conditions' => array('TestVclassroom.vclassroom_id' =>$vclassroom_id),
                                       'fields'     => array('TestVclassroom.id', 'TestVclassroom.test_id', 'TestVclassroom.vclassroom_id', 
                                                             'TestVclassroom.sdate', 'TestVclassroom.fdate'),
                                       'Test' => array(
                                                         'fields' => array('Test.title')
                                                   )),
           'GapVclassroom'    => array(
                                       'conditions' => array('GapVclassroom.vclassroom_id' =>$vclassroom_id),
                                       'fields' => array('GapVclassroom.id', 'GapVclassroom.gap_id', 'GapVclassroom.vclassroom_id',
                                                         'GapVclassroom.sdate', 'GapVclassroom.fdate'),
                                       'Gap' =>array( 
                                                         'fields' => array('Gap.title')           
                                                      )), 
           'TreasureVclassroom' => array(
                                       'conditions' => array('TreasureVclassroom.vclassroom_id' =>$vclassroom_id),
                                       'fields'      => array('TreasureVclassroom.id', 'TreasureVclassroom.sdate', 'TreasureVclassroom.fdate'), 
                                       'Treasure'    => array( 
                                                         'fields' =>array('Treasure.title')     
                                                         ) 
                                      ),
           'VclassroomWebquest' => array( 
                                       'conditions' => array('VclassroomWebquest.vclassroom_id' =>$vclassroom_id),
                                       'fields'   => array('VclassroomWebquest.id', 'VclassroomWebquest.sdate', 'VclassroomWebquest.fdate'),
                                       'Webquest' => array( 
                                                         'fields' =>array('Webquest.title')                  
                                                    )),
           'ScormVclassroom'    => array( 
                                         'fields' => array('ScormVclassroom.id', 'ScormVclassroom.fdate', 'ScormVclassroom.sdate'),
                                         'conditions' => array('ScormVclassroom.vclassroom_id' =>$vclassroom_id),                                
                                         'Scorm' => array(
                                                         'fields' =>array('Scorm.name')
                                                         ))
                       ));

   $params = array('conditions' => array('Vclassroom.id'=>$vclassroom_id),
                   'fields'     => array('Vclassroom.id', 'Vclassroom.name'));

   $data       = $this->find('first', $params);

   #die(debug($data));
   return $data;
 }

/**
 * Big method
 * Consult nine Model to get all student points in vClassroom and full details not just points 
 * Used in other methods 
 * See: http://trac.chipotle-software.com/karamelo/wiki/studentRecord 
 * return @array record
 */
 private function __studentPoints($user_id, $vclassroom_id)
 {
  $record  = array();
  $params = array('conditions' => array('User.id'=>$user_id),
                  'fields'     => array('User.id', 'User.name', 'User.email', 'User.username', 'User.avatar'),
                  'contain'    => False); 

  $record = $this->UserVclassroom->User->find('first', $params);
 
  # 1) Consult Test Model associated to this Vclassroom
  $this->TestVclassroom->bindModel(array('belongsTo'=>array('Test')));
  $params = array('conditions' => array('TestVclassroom.vclassroom_id'=>$vclassroom_id),
                  'fields'     => array('TestVclassroom.test_id', 'TestVclassroom.id', 'Test.title', 'Test.id'));
  $record['tests']    = $this->TestVclassroom->find('all', $params);
  
  # foreach Test check in Result model and put in $record 
  foreach($record['tests'] as $k => $t):
      $record['tests'][$k]['Test']['points'] = $this->TestVclassroom->Test->getPoints($t['TestVclassroom']['test_id'],$user_id,$vclassroom_id);
      $record['tests'][$k]['Test']['title']  = $t['Test']['title'];
      $record['tests'][$k]['Test']['id']     = $t['Test']['id'];
  endforeach;
  #die(debug($record));
  # 2) Treasures
  $params = array('conditions' => array('ResultTreasure.vclassroom_id'=>$vclassroom_id, 'ResultTreasure.user_id'=>$user_id),
                  'fields'     => array('ResultTreasure.id','ResultTreasure.points', 'Treasure.title', 'Treasure.id'));
  $record['treasures']  = $this->TreasureVclassroom->Treasure->ResultTreasure->find('all', $params);

  # 3) Topics in forums 
  $params = array('conditions'  => array('Reply.vclassroom_id'=>$vclassroom_id, 'Reply.user_id'=>$user_id),
                  'fields'      => array('Reply.topic_id', 'Reply.vclassroom_id', 'Reply.id', 'Reply.points', 'Reply.created'),
                  'order'       => 'Reply.id DESC');
  $record['replies'] = $this->Forum->Topic->Reply->find('all', $params);
   
  # 4) Participation
  $params = array('conditions'  => array('Participation.vclassroom_id'=>$vclassroom_id, 'Participation.user_id'=>$user_id),
                  'fields'      => array('Participation.title', 'Participation.id','Participation.points', 'Participation.checked'));
  $record['participations'] = $this->Participation->find('all', $params);
  
  # 5) Reports
  $params = array('conditions'  => array('Report.vclassroom_id'=>$vclassroom_id, 'Report.student_id'=>$user_id),
                  'fields'      => array('Report.filename', 'Report.description', 'Report.id', 'Report.points', 'Report.created', 'Report.checked'));
  $record['reports'] = $this->Report->find('all', $params);

  # 6) Webquest  
  $params = array('conditions'  => array('ResultWebquest.vclassroom_id'=>$vclassroom_id, 'ResultWebquest.user_id'=>$user_id),
                  'fields'      => array('Webquest.title', 'Webquest.id', 'ResultWebquest.points', 'ResultWebquest.id'));
  $record['webquests']  = $this->VclassroomWebquest->Webquest->ResultWebquest->find('all', $params);

  # 7) Gap fillings
  $params = array('conditions'  => array('ResultGap.vclassroom_id'=>$vclassroom_id, 'ResultGap.user_id'=>$user_id),
                  'fields'      => array('Gap.title', 'Gap.id', 'Gap.points', 'ResultGap.id'));
  $this->GapVclassroom->Gap->ResultGap->bindModel(array('belongsTo'=>array('Gap')));
  $record['gaps'] = $this->GapVclassroom->Gap->ResultGap->find('all', $params);

  # 8) revisions wikis
  $this->bindModel(array('hasMany'=>array('Wiki')));
  $this->Wiki->bindModel(array('hasMany'=>array('Revision'=>
            array('fields'=>'id, user_id, revision, points', 'conditions'=>array('Revision.user_id' => $user_id)))));
  $params = array('conditions' => array('Wiki.vclassroom_id'=>$vclassroom_id),
                  'fields'     => array('Wiki.title', 'Wiki.id', 'Wiki.slug'),
                  'contain'    => False);
  $record['wikis']   = $this->Wiki->find('all', $params);

  # 9) Scorm
  $record['scorms'] = $this->ScormVclassroom->Scorm->getResults($user_id, $vclassroom_id);

  return $record;
 }

/**
 *  Get class (group) record
 *
 * @param  integer $vclassroom_id  description
 * @return array   $record description
 * @access public
 */
 public function recordClass($vclassroom_id)
 {
  try{   
    $records = array();
    $params  = array('conditions'=>array('UserVclassroom.vclassroom_id'=>$vclassroom_id, 'UserVclassroom.kind'=>0), 'fields'=>array('user_id'));
    $data    = $this->UserVclassroom->find('all', $params);
    #die(debug($data));
    $i = (int) 0;
    foreach ($data as $u): 
        $this->UserVclassroom->User->contain(False);  # remove innecesaries user binds  
        $user_id      = (int) $u['UserVclassroom']['user_id'];  # get and charge every user
        $records[$i]  = $this->__studentPoints($user_id, $vclassroom_id);
        $i++;
    endforeach;
    #die(debug($records));
    return $records;
  }

  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }

/**
 * classElements 
 * Get class (vClassroom) active elements (Webquest, Test, Scavenger, Forums, WikiPages, etc)
 * this method is used in show() method, vclassrooms_controller.php
 * @param  integer $vclassroom_id  description
 * @return array   $record description
 * @access public 
 **/
 public function classElements($vclassroom_id)
 {
  try{   

   $this->unbindModel(array('hasAndBelongsToMany'=>array('Test', 'Webquest', 'Treasure'), 
                            'hasMany'            =>array('Participation', 'Report', 'Chat', 'Forum')
                     ));
 
   $this->bindModel(array(
                          'belongsTo'           =>array('Ecourse'),
                          'hasMany'             =>array(
                                                        'Wiki'=>array('fields'=>'id,title,slug', 'conditions'=>array('Wiki.status'=>'1')),
                                                        'Forum'=>array('conditions'=>array('Forum.status' => '1')) 
                                                        ),
         'hasAndBelongsToMany' =>array(
                    'Test' =>
					   array('className'         => 'Test',
						 'joinTable'             => 'tests_vclassrooms',
						 'foreignKey'            => 'vclassroom_id',
						 'associationForeignKey' => 'test_id',
						 'conditions'            => 'status=1',
						 'fields'                => 'id, title'
						 ),
                    'Webquest' =>
					   array('className'         => 'Webquest',
						 'joinTable'             => 'vclassrooms_webquests',
						 'foreignKey'            => 'vclassroom_id',
						 'associationForeignKey' => 'webquest_id',
                         'conditions'            => 'status=1',
						 'unique'                => true,
						 'fields'                => 'id, title'						 
                                                 ),
                     'Treasure' =>
					   array('className'             => 'Treasure',
						 'joinTable'             => 'treasures_vclassrooms',
						 'foreignKey'            => 'vclassroom_id',
						 'associationForeignKey' => 'treasure_id',
						 'conditions'            => 'Treasure.status=1',
                         'fields'                => 'id, title',
						 'unique'                => True
						 ),
                    'Gap' =>
					   array('className'             => 'Gap',
						 'joinTable'             => 'gaps_vclassrooms',
						 'foreignKey'            => 'vclassroom_id',
						 'associationForeignKey' => 'gap_id',
						 'conditions'            => 'Gap.status=1',
                         'fields'                => 'id, title',
						 'unique'                => True
                           ),
                    'Scorm' =>
					   array('className'         => 'Scorm.Scorm',
						 'joinTable'             => 'scorms_vclassrooms',
						 'foreignKey'            => 'vclassroom_id',
						 'associationForeignKey' => 'scorm_id',
                         'fields'                => 'id, name',
						 'unique'                => True
                        )
                        )
			          )
                    );
   
   $params = array('conditions' => array('Vclassroom.status'=>1,'Vclassroom.id'=>$vclassroom_id),
                   'fields'     => array('Vclassroom.status', 'Vclassroom.id','Vclassroom.name', 'Vclassroom.secret', 'Vclassroom.fdate',
                                         'Vclassroom.sdate','Vclassroom.ecourse_id','Vclassroom.diploma','Vclassroom.chat','Vclassroom.message', 
                                         'Vclassroom.gcalendar_id', 'Ecourse.id', 'Ecourse.title', 'Ecourse.percentage'));
  
   $data = $this->find('first', $params);
   #die(debug($data));
   if ( $data ):
       if ( $this->__chkVclassroomDate($vclassroom_id) ):
           throw new AppExceptionHandler(__('This Vclassroom is out of date'));
       endif;
   else:
       throw new AppExceptionHandler('Not such Vclassroom');
   endif;
   $this->Ecourse->bindModel(array('hasMany'=>array('Activity'=>array('className'=>'Activity','conditions'=>array('Activity.status' => 1), 'order'=>'Activity.order ASC'))));
   $params = array(
                   'conditions' => array('Activity.status'=>1, 'Activity.ecourse_id'=>$data['Ecourse']['id']),
                   'fields'     => array('Activity.id', 'Activity.title',  'Activity.points'),
                   'order'      => 'order ASC'
                  );
   $data['activities'] = $this->Ecourse->Activity->find('all', $params);
   #die(debug($data));
   return $data;
  }

  catch(Exception $e)
  {   
      #die(debug($e));
      # re-throw exception
      throw new AppExceptionHandler($e->getMessage());
  }
 }

/**
 * Check if Vclassrom is out of date before 
 * Used in: /vclassrooms/show/$username/$vclassroom_id
 * @access private
 * @return boolean 
 */
 private function __chkVclassroomDate($vclassroom_id)
 {
   $this->recursive = 0;

   $field = $this->field('Vclassroom.id', array('Vclassroom.id'=>$vclassroom_id, 'CURRENT_DATE <= Vclassroom.fdate','CURRENT_DATE >= Vclassroom.sdate'));
   
   if ( !$field ):  # vclassroom exist but is out of date
       return True;
   else:
       return False;
   endif;
 }

/**
 *  Get student evaluation, return integer
 *
 * @param  integer $user_id  description
 * @param  integer $vclassroom_id  description
 * @return array   $record description
 * @access public
 **/
 public function getEval($user_id, $vclassroom_id)
 {
   return $record;
 }

/**
 *  Check if the student already exist in the classroom
 *  @param  integer $user_id  description
 *  @param  integer $vclassroom_id  description
 *  @return boolean   description
 *  @access public
 **/
 public function chkMember($vclassroom_id, $user_id)
 { 
   $conditions = array('vclassroom_id'=>$vclassroom_id, 'user_id'=>$user_id);
   
   $data = $this->UserVclassroom->field('user_id', $conditions);
   
   if ($data == Null):
       return False;
   else:
       return True;
   endif; 
 }
 /**
 *  memebersDetails 
 *  used in /admin/vclassrooms/members view
 */
 public function membersDetails($vclassroom_id)
 {
  $params = array('conditions' => array('Vclassroom.id'=>$vclassroom_id),
                  'fields'     => array('Vclassroom.id', 'Vclassroom.name', 'Vclassroom.chat', 'Ecourse.id', 'Ecourse.title', 'Ecourse.user_id'),
                  'contain'    => array('Ecourse')
                  );
 
  $data = $this->find('first', $params);
  $data['owner'] = (string) $this->UserVclassroom->User->field('User.username',array('User.id'=>$data['Ecourse']['user_id']));
  #die(debug($data));
  # get total Ecourse points
  $data['Ecourse']['points'] = (int) $this->Ecourse->getPoints($data['Ecourse']['id']);
  $params = array('conditions' => array('UserVclassroom.vclassroom_id' => $vclassroom_id, 'UserVclassroom.kind' =>0),
                  'fields'     => array('User.id', 'User.name', 'User.avatar', 'User.username', 'User.email', 'User.last_visit'),
                  'contain'    => array('User'));
  # get students in Vclassroom
  $users = $this->UserVclassroom->find('all', $params);
  #die(debug($users));
  # add gained points for each student
  foreach( $users as $k => $u):
      $users[$k]['User']['points'] = $this->totalPoints($u['User']['id'], $vclassroom_id); 
  endforeach;
  #die(debug($users)); 
  $data['U'] = $users;
  #die(debug($data));
  return $data;
 } 

/**
 *  studentPoints 
 *  Used in ajax function total points tp() in admin.js 
 *  @access public
 */
 public function totalPoints($user_id, $vclassroom_id)
 {
  try{   
     $points  = (int) 0; # student total points in eCourse 
     # 1) Consult TestVclassroom  Model 
     $params = array('conditions' => array('TestVclassroom.vclassroom_id'=>$vclassroom_id), 'fields' => array('TestVclassroom.test_id'));
     $tests  = $this->TestVclassroom->find('all', $params);
     
     foreach ($tests as $test):
            $points += (int) $this->TestVclassroom->Test->getPoints($test['TestVclassroom']['test_id'], $user_id, $vclassroom_id);
     endforeach;
     
     # 2) Consult Treasure Model
     $params = array('conditions' => array('ResultTreasure.vclassroom_id'=>$vclassroom_id, 'ResultTreasure.user_id'=>$user_id), 
                     'fields'     => array('ResultTreasure.points'));
     $treasures  =  $this->TreasureVclassroom->Treasure->ResultTreasure->find('all', $params);
     foreach ($treasures as $t):
            $points += $t['ResultTreasure']['points'];
     endforeach;
  
     # 3) Consult Reply Model    
     $params = array('conditions'  => array('Reply.vclassroom_id'=>$vclassroom_id, 'Reply.user_id'=>$user_id),
                     'fields'      => array('Reply.points'));
     $replies       = $this->Forum->Topic->Reply->find('all', $params);
     foreach ($replies as $r):
            $points += $r['Reply']['points'];
     endforeach;
  
     # 4) Participations
     $params = array('conditions' => array('Participation.vclassroom_id'=>$vclassroom_id, 'Participation.user_id'=>$user_id),
                     'fields'     => array('Participation.points')); 
     $participations = $this->Participation->find('all', $params);
     foreach ($participations as $pa):
            $points += $pa['Participation']['points'];
     endforeach;

     # 5) Reports
     $params = array('conditions' => array('Report.vclassroom_id'=>$vclassroom_id, 'Report.student_id'=>$user_id),
                     'fields'     => array('Report.points')); 
     $reports  = $this->Report->find('all', $params);
     foreach ($reports as $rep):
            $points += $rep['Report']['points'];
     endforeach;
     
     # 6) Webquest
     $params = array('conditions' => array('ResultWebquest.vclassroom_id'=>$vclassroom_id, 'ResultWebquest.user_id'=>$user_id),
                     'fields'     => array('Webquest.title', 'Webquest.id', 'ResultWebquest.points')); 
     $webquests  = $this->VclassroomWebquest->Webquest->ResultWebquest->find('all', $params);
     foreach ($webquests as $w):
            $points += (int) $w['ResultWebquest']['points'];
     endforeach;

     # 7) Gap filling
     $params = array('conditions' => array('ResultGap.vclassroom_id'=>$vclassroom_id, 'ResultGap.user_id'=>$user_id),
                     'fields'     => array('Gap.points'));
     $this->GapVclassroom->Gap->ResultGap->bindModel(array('belongsTo'=>array('Gap')));
     $gaps       = $this->GapVclassroom->Gap->ResultGap->find('all', $params);
     foreach ($gaps as $g):
            $points += (int) $g['Gap']['points'];
     endforeach;

     # 8) Revision on wikis
     $this->bindModel(array('hasMany' => array('Wiki')));
     $params = array('conditions'     => array('Wiki.vclassroom_id'=>$vclassroom_id),
                     'fields'         => array('Wiki.id'));
     $wikis  = $this->Wiki->find('all', $params);
     foreach ($wikis as $wk):
     $params = array('conditions' => array('Revision.user_id'=>$user_id, 'Revision.wiki_id'=>$wk['Wiki']['id']),
                     'fields'     => array('Revision.points'));
              $revisions      = $this->Wiki->Revision->find('all', $params);
              foreach ($revisions as $rev):
                    $points += (int) $rev['Revision']['points'];
              endforeach;
     endforeach;
    
     # 9) SCORMS (not yet done)
     
     #die(debug($points));
     return $points;
  }
  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }

/**
 *  
 *  @access public
 *  @return boolean
 */
 public function chkVclassrooms($user_id)
 {
  $params = array('conditions'  => array('UserVclassroom.user_id'=>$user_id),
                  'fields'      => array('UserVclassroom.vclassroom_id')
       );
   $data        = $this->UserVclassroom->find('all', $params);

   if ( $data == null ):
       return null; 
   else:
       $vclassrooms = array();
       foreach ($data as $v):
	       foreach($v['UserVclassroom'] as $m):
	           array_push($vclassrooms, $m);
	       endforeach;
       endforeach;
   endif;
   return $vclassrooms;
 }
 
/**
 *  Check if student already answered this Kandie
 *  @param integer kandie_id
 *  @param integerint user_id     
 *  @param integerint vclassroom_id
 *  @return boolean
 */
 public function chkAlready($kandie_id, $user_id, $vclassroom_id, $kandie_model)
 {
   $m = $this->__Kandies[$kandie_model];   # Get the model and relationships
   #die(debug($m));

   $conditions =  array("{$m['results']}.user_id"=>$user_id,"{$m['results']}.{$m['model_id']}"=>$kandie_id,"{$m['results']}.vclassroom_id"=>$vclassroom_id);
   if ($m['origin'] == 'Scorm'):
       $conditions["{$m['results']}.varname"]  = 'lesson_status';
       $conditions['OR'] = array(
                                 array("{$m['results']}.varvalue" => 'passed'),
                                 array("{$m['results']}.varvalue" => 'completed')
                                );
   endif;
   # example: Treasure->TreasureVclassroom->Results->field();
   # die(debug($conditions));
   $data      =  $this->{$m['model']}->{$m['origin']}->{$m['results']}->field("{$m['results']}.id", $conditions);
   #die(debug($data)); 
   if ($data == Null ):
       return False;   
   else:
       return True;
   endif;
 }

/** 
 *  getList method
 *  build a list containing vclassrooms to wich the stundent belongs to, used in portal component to display select  
 *  @access public
 *  @param integer  user_id
 *  @return  array
 */
 public function getList($user_id)
 {
 try{   
  $record     = array();
  $params = array('conditions' => array('UserVclassroom.user_id'=>$user_id),
                  'fields'     => array('vclassroom_id'));
  $data       = $this->UserVclassroom->find('all', $params);
  
  if ( $data == False):
      return False;
  else:
      $fields     = array('id', 'name', 'user_id');
      foreach ( $data as $v):
          $conditions = array('Vclassroom.id'=>$v['UserVclassroom']['vclassroom_id']);
          $tmp = $this->find('first', array('conditions'=>$conditions, 'fields'=>$fields, 'contain'=>False));
          array_push($record, $tmp); 
      endforeach;
  endif;
  
  return $record;
  }

  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }

/**
 * Return current student vclassrooms list 
 * @access public
 * @return array()
 */
 public function studentVclassrooms($student_id)
 {
  $this->contain();
  $this->UserVclassroom->bindModel(array('belongsTo'=>array('Vclassroom')));
  $params = array(
                  'conditions' => array('UserVclassroom.user_id'=>$student_id, 'UserVclassroom.kind'=>0),
                  'fields'     => array('Vclassroom.id',  'Vclassroom.name')
                 );	
  $data = $this->UserVclassroom->find('all', $params);
  foreach( $data as $k=>$v):
      $user_id = $this->UserVclassroom->field('UserVclassroom.user_id', 
                                      array('UserVclassroom.vclassroom_id'=>$v['Vclassroom']['id'],'UserVclassroom.kind'=>1));
      $data[$k]['Vclassroom']['username'] = $this->UserVclassroom->User->field('username', array('User.id'=>$user_id));
  endforeach;
  #die(debug($data));
  return $data;
 }

}
# ? > EOF
