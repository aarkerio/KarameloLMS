<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package chat
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/Model/Ping.php

class Ping extends AppModel
{
  public $name       = 'Ping';
    
  public $belongsTo  = array(
                             'User' => array(
                                            'className'    => 'User',
                                            'foreignKey'   => 'user_id'
                                            ),
                             'Vclassroom' => array(
                                            'className'    => 'Vclassroom',
                                            'foreignKey'   => 'vclassroom_id'
                                            )
             );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */  
  public $validate = array(
                           'user_id' => array(
                                             'rule'       => 'numeric',
                                             'allowEmpty' => False,
                                             'on' => 'create', # but not on update
                                             'required'   => True 
                                             ),
                          'vclassroom_id' => array(
                                             'rule'       => 'numeric',
                                             'allowEmpty' => False,
                                             'on' => 'create', # but not on update
                                             'required'   => True 
                                             )
                           );

/**
 *   This method do three things: 
 *   1) Update or created ping
 *   2) Delete old pings
 *   3) Return current pings 
 * @access public
 * @param integer $vclassroom_id
 * @param integer $user_id
 * @return array empty or populated 
 */
 public function handlePings($vclassroom_id, $user_id, $dbkind='PGSQL')
 {
   $conditions = array('Ping.vclassroom_id'=>$vclassroom_id, 'Ping.user_id'=>$user_id);
  
   $ping_id    = $this->field('Ping.id', $conditions);
   $ip         = $_SERVER['REMOTE_ADDR'];
   if ($ping_id):  # the record exist, just update
           $this->id      = $ping_id;
           $this->saveField('last_time', 'NOW()');
           $this->saveField('last_ip', $ip);
   else:          # record does not exist, so create, I'm a fucking genious!
           $this->data['Ping']['user_id']       = $user_id;
           $this->data['Ping']['vclassroom_id'] = $vclassroom_id;
           $this->data['Ping']['last_ip']       = $ip;
           $this->save($this->data);
   endif;
   # now delete users + 10 minutes
   if ( $dbkind=='PGSQL' ):
        $last_time = "Ping.last_time < now() - interval '10 minutes'";
   else:
        $last_time = "Ping.last_time < DATE_SUB(now(), INTERVAL 10 MINUTE)";
   endif;
   $params = array('conditions' => array('Ping.vclassroom_id'=>$vclassroom_id, $last_time),
                   'fields'     => array('Ping.id'));

   $data = $this->find('all', $params);
   
   foreach ($data as $p):
       $this->delete($p['Ping']['id']);
   endforeach;
   #get current users
   $params = array('conditions' => array('Ping.vclassroom_id'=>$vclassroom_id),
                   'fields'     => array('User.username', 'User.avatar', 'User.group_id'),
                   'order'      => 'Ping.id DESC');
   return $this->find('all', $params);
 }

/**
 * getIp
 * @param integer $vclassroom_id
 * @param integer $user_id
 * @return mixed string or bool
 */
 public function getIp($vclassroom_id, $user_id)
 {
   $conditions = array('Ping.vclassroom_id'=>$vclassroom_id, 'Ping.user_id'=>$user_id);
   $last_ip    = $this->field('Ping.last_ip', $conditions);
   return $last_ip;
 }
}
# ? > EOF
