<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package glossary
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/GlossariesController.php
 
# Import libraries
App::uses('Sanitize', 'Utility');

class GlossariesController extends AppController
{

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers      = array('User', 'Ck');
    
/**
 *  Cake Components
 *  @var array
 *  @access public
 */ 
 public $components   = array('Edublog');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
   parent::beforeFilter();
 }

 /*** ===== ADMIM METHODS ===== ***/
 
 public function admin_new($catglossary_id)
 {
   $this->layout = 'ajax';
   $this->set('catglossary_id', $catglossary_id);
   $this->render('admin_edit', 'ajax');
 }
 
/**
 * Add/Edit Glossary
 * @access public
 * @param mixed integer or Null
 * @return void
 */ 
 public function admin_edit($glossary_id = Null)
 {
   $this->layout = 'admin';
   if (!empty($this->request->data['Glossary'])):
       if (!isset($this->request->data['Glossary']['id'])): # add new row
           $display = $this->Glossary->field('display',array('Glossary.catglossary_id'=>$this->request->data['Glossary']['catglossary_id']),'display DESC');
           if ( !$display ):
               $display = (int) 1;
           else:
               $display = (int) $display + 1;
           endif;
           $this->request->data['Glossary']['display']  = (int) $display;
       endif;
       if ($this->Glossary->save($this->request->data)):
             $msg = __('Data saved');
   	         if ( $this->request->data['Glossary']['end'] == 0  && !isset($this->request->data['Glossary']['id'])):
                 $id  = (int) $this->Glossary->getLastInsertID();
                 $url = (string) '/admin/glossaries/edit/'.$id;
             elseif ( $this->request->data['Glossary']['end'] == 0  && isset($this->request->data['Glossary']['id'])):
                 $url = (string) '/admin/glossaries/edit/'.$this->request->data['Glossary']['id']; 
             else:
                 $url = (string) '/admin/catglossaries/items/'.$this->request->data['Glossary']['catglossary_id'];
             endif;
             $this->msgFlash($msg, $url);
       endif;
   elseif( $glossary_id != null && intval( $glossary_id )):
          $this->request->data = $this->Glossary->findById($glossary_id);
   endif;
 }

/**
 * Update Glossary order
 * Get two rows and change order
 * @access public
 * @param string $sense
 * @param integer $faq_id
 * @param integer $order
 * @param integer $catfaq_id
 * @return void
 */ 
 public function admin_order($sense, $glossary_id, $order, $catglossary_id)
 {
  if ($sense == 'up'):
       $conditions = array('Glossary.display <= ' .$order, 'Glossary.catglossary_id'=>$catglossary_id); # next up
       $display    =  'display DESC';
  else:
       $conditions = array('Glossary.display >= '.$order, 'Glossary.catglossary_id'=>$catglossary_id);  # next down
       $display    =  'display ASC'; 
  endif;  
  $params = array(
             'conditions' => $conditions,
             'order'      => $display,
             'fields'     => array('id', 'display'),
             'limit'      => 2
             );
  $data = $this->Glossary->find('all', $params);
  #die(debug($data));
  for($i=0;$i < 2;$i++):
      if ($i === 0):
         $this->Glossary->id = $data[0]['Glossary']['id'];
         $new_display = $data[1]['Glossary']['display'];
      else:
         $this->Glossary->id = $data[1]['Glossary']['id'];
         $new_display = $data[0]['Glossary']['display'];
      endif;
      $this->Glossary->saveField('display', $new_display);    
  endfor;
  $this->msgFlash(__('Data saved'), '/admin/catglossaries/items/'.$catglossary_id.'#dv'.$glossary_id);
 }

/**
 *  Change status enabled/disabled 
 *  @access public
 *  @param integer $glossary_id
 *  @param integer $catglossary_id
 *  @param integer $status
 *  @return void
 */
 public function admin_change($glossary_id, $catglossary_id, $status)
 { 
   $new_status  = ($status == 0 ) ? 1 : 0;
    
   $this->Glossary->id     = (int) $glossary_id;
      
   if ($this->Glossary->saveField('status', $new_status)):
         $this->msgFlash(__('Status modified'), '/admin/catglossaries/items/'.$catglossary_id);
   endif;
 }
     

/**
 *  Remove Glossary
 *  @access public
 *  @param integer $glossary_id
 *  @param integer $catglossary_id
 *  @return void
 */
 public function admin_delete($glossary_id, $catglossary_id)
 {
   if ( $this->Glossary->delete($glossary_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif;
  $this->msgFlash($msg, '/admin/catglossaries/items/'.$catglossary_id);
 } 
}

# ? > EOF
