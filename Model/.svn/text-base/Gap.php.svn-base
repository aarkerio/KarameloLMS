<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package gaps
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Model/Gap.php

class Gap extends AppModel {

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs    = array('Containable');
 
/**
 *  CakePHP belongsTo array 
 *  @access public
 *  @var array
 */   
 public $belongsTo = array('User' =>
			 array('className'  => 'User',
			       'conditions' => '',
			       'order'      => '',
                               'foreignKey' => 'user_id',
                               'fields'     => 'id, username'
			       )
			 );

/**
 *  hasMany CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $hasMany = array(
		          'ResultGap' =>
		                   array('className'     => 'ResultGap',
                                 'conditions'    => Null,
					             'foreignKey'    => 'gap_id'
                                 ),
                  'GapVclassroom' =>
                           array('className'             => 'GapVclassroom',
						         'foreignKey'            => 'gap_id'
	                             )
                        );
 

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
		      'title' => array(
			              'rule'    => array('minLength', 4),
                                      'message' => 'Minimum 4 characters long'
				       ),
		      'gaps' => array(
			              'rule'    => array('minLength', 4),
                                      'message' => 'Minimum 4 characters long'
					 ),
                      'user_id' => array(
		                       'rule'       => 'numeric',
                                       'allowEmpty' => False,
                                       'on'         => 'create',  # but not on update
                                       'required'   => True 
		                        )	
		        );
 
/**
 * getGaps Return gaps owned by teacher and not already linked to the vclassrooms
 * @param integer $user_id
 * @param integer $vclassroom_id
 * @return array  list gaps already linked to vclassroom
 */
 public function getGaps($user_id, $vclassroom_id)
 {
   $params = array('conditions'   => array('Gap.user_id'=>$user_id),
                   'fields'       => array('Gap.id', 'Gap.title'),
                   'contain'      => False,
                   'order'        => 'Gap.title');
   $gaps        = $this->find('all', $params);
   foreach ($gaps as $k =>$t):
       $params = array('conditions' => array('GapVclassroom.gap_id' => $t['Gap']['id'],'GapVclassroom.vclassroom_id'=>$vclassroom_id),
                       'fields     '=> array('GapVclassroom.gap_id'));
       $assigned = $this->GapVclassroom->find('first', $params);
       if ( $assigned ): # test is already assigned to this Vclassroom, so unset
           unset($gaps[$k]);
       endif; 
   endforeach;

  return $gaps;
 }

/**
 *  return shared Gaps on Knetwork
 *  @access public
 *  @return mixed array or Null
 */
 public function getKnet()
 {
   $params = array('conditions' => array('Gap.knet' => 1),
                   'fields'     => array('Gap.title', 'Gap.id'),
                   'contain'    => array('User'=>array('conditions'=>array('User.active'=>1),'fields'=>array('User.username')))
                  );
   return $this->find('all', $params);
 }

/**
 *  return formated Gaps
 *  @param integer $gap_id
 *  @param boolean $all
 *  @access public
 *  @return void
 */
 public function buildGaps($gap_id, $all = True)
 {
   $i           = (int) 0;
   $my_array    = array();
   $replacement = '&&&&';
   $pattern     = "#\*(.+)\*#";  # between asteriks 
   $params = array('conditions'  => array('Gap.id'=>$gap_id, 'Gap.status'=>1),
                   'fields'      => array('Gap.id', 'Gap.title', 'Gap.gaps', 'Gap.points', 'Gap.instructions'),
                   'contain'     => False
                  );
   $data  = $this->find('first', $params);
   $lines = explode("\n", $data['Gap']['gaps']);
   foreach( $lines as $line):
     $do = preg_match($pattern, $line, $match);
     #debug($match);
     if ( $do == True):
         $i++;
         $line = str_replace($match[0], '&&&', $line);
         $my_array[$i]['secret'] = trim($match[1]);
         if ( $all ):
             $my_array['gap_id']       = $data['Gap']['id'];
             $my_array['title']        = $data['Gap']['title'];
             $my_array['points']       = $data['Gap']['points'];
             $my_array['instructions'] = $data['Gap']['instructions'];
             $my_array[$i]['line']     = $line;
             $my_array[$i]['length']   = mb_strlen(trim($match[1]), 'UTF-8'); 
	     endif;
     endif;
   endforeach;
   return $my_array;
 }

/**
 *  getPoints  returns points from already answered test by student
 * @access public
 * @param integer $gap_id
 * @param integer $gap_id
 * @param integer $gap_id
 * @return void
 */
 public function getPoints($gap_id, $user_id, $vclassroom_id)
 {
  $points = (int) 0;
  $params = array('conditions' => array('Result.test_id'=>$gap_id, 'Result.user_id'=>$user_id, 'Result.vclassroom_id'=>$vclassroom_id),
                  'contain'    => False);
  $answers    = $this->Result->find('all', $params);  # get the answers gived by student

  if ( count($answers) < 1):    # test not answer yet
      return False;
  endif;

  foreach($answers as $a):
      $question = $this->Question->find(array('Question.id'=>$a['Result']['question_id']), array('worth'));  # how much points question worth
      foreach($question['Answer'] as $qa):
          if ($qa['id'] == $a['Result']['answer_id'] && $qa['question_id'] == $a['Result']['question_id'] && $qa['correct'] == 1):
              $points += (int) $question['Question']['worth'];  
	      endif;
      endforeach;
  endforeach;
  
  return $points;
 }

/**
 *  Link to vClassroom
 * @return array
 * @access public
 */
 public function findKnet($gap_id, $user_id)
 {
  $params = array('conditions' => array('Gap.knet'=>1, 'Gap.user_id'=>$user_id, 'Gap.id'=>$gap_id),
                  'fields'     => array('Gap.title', 'Gap.points', 'Gap.instructions', 'Gap.gaps', 'Gap.created'),
                  'contain'    => array('User'=>array('fields'=>array('username', 'id', 'email'))));
  $result = $this->find('first', $params);
  return $result;
 }

/**
 *  Link to vClassroom
 * @return array
 * @access public
 */
 public function linkClassroom($gap_id, $user_id)
 {
  $params = array('conditions' => array('Test.status'=>1, 'Test.user_id'=>$user_id, 'Test.id'=>$gap_id)); 
  $vclassrooms = array();
  $result = $this->find('first', $params);
    
  foreach ($result['Vclassroom'] as $val):
      $vclassrooms[$val['name']] = $val['id'];
  endforeach;
    
  return $vclassrooms;
 }
}
# ? > EOF
