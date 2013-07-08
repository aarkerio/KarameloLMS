<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package wikis
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/Controller/WikisController.php

/**
*  Include files
*/
App::uses('Sanitize', 'Utility');

class WikisController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */  
 public $helpers       = array('Ck');

/**
 *  Cake components
 *  @var array
 *  @access public
 */ 
 public $components    = array('Edublog');

/**
 *  Cake Paginate wikiw
 *  @var array
 *  @access public
 */ 
 public $paginate      = array('limit' => 20, 'page' => 1);
 
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 { 
   $permissions = array('view', 'display', 'history', 'revision');
   parent::beforeFilter();
   if ( $this->Auth->user()):
       array_push($permissions, 'edit', 'preview');
   endif;
   $this->Auth->allow($permissions);
 }

/**
 *  View in eduBLog
 *  @access public
 *  @param string $username
 *  @param string $slug
 *  @return void 
 */
 public function view($username, $slug)
 {
  $this->Edublog->setUserId($username);
  # $this->__visits($slug);  # sum 1 to visits


  $owner = $this->Auth->user() && $this->Auth->user('id') ==  $this->Edublog->userId ? True : False;
  
  $data   = $this->Wiki->render($slug, $owner);

  if ( !$data ):
      $this->flash(__('Sorry this is a restricted element'), '/blog/'.$username, 4);
      return False;
  endif;
  $this->set('data', $data);
  $user_id         = (int) $data['Wiki']['user_id'];
  $vclassroom_id   = (int) $data['Wiki']['vclassroom_id'];

  # student belongs to this class?
  $this->set('belongs', $this->Wiki->User->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id));

 }

/**
 *  Check Wiki revision
 *  @access public
 *  @return void 
 */ 
 public function revision($username, $slug, $revision_id)
 {
  # $this->__visits($slug); # sum 1 to visits
  $data = $this->Wiki->diff($slug, $revision_id);
  $this->set('data', $data);
  $user_id         = (int) $data['Wiki']['user_id'];
  $vclassroom_id   = (int) $data['Wiki']['vclassroom_id'];
  $this->Edublog->setUserId($username); # blogger elements
  # student belongs to this class?
  $this->set('belongs', $this->Wiki->User->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id));

 }

/**
 *  Wiki page history
 *  @access public
 *  @return void 
 */
 public function history($username, $slug)
 {
  $user_id         = (int) $this->Wiki->User->field('User.id', array('User.username'=>$username));
  # $this->__visits($lesson_id);   # sum 1 to visits
  $this->set('data', $this->Wiki->getRevisions($slug));
  $this->Edublog->setUserId($username); # blogger elements  
  # student belongs to this class?
  #$this->set('belongs', $this->Wiki->Vclassroom->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id));
 }

/**
 *  Display blogger wiki pages
 *  @access public
 *  @return void 
 */
 public function display($username) 
 { 
   $this->Edublog->setUserId($username);   # blogger elements
   $conditions = array('Wiki.status'=>1, 'Wiki.user_id'=>$this->Edublog->userId);
   if ( !$this->Auth->user('username') ): # user is not logged
       $conditions['Wiki.public'] = 1; 
   endif;
   $this->paginate['conditions']  = $conditions;
   $this->paginate['fields']      = array('Wiki.id', 'Wiki.title', 'Wiki.slug');
   $this->paginate['order']       = array('Wiki.title');

   $data = $this->paginate('Wiki');
   $this->set(compact('data'));
 }

/**
 *  Preview before save 
 *  @access public
 *  @return void 
 */
 public function preview() 
 {
  $this->layout = 'ajax';
  #die(debug($this->request->data));
  $data = $this->Wiki->wikify($this->request->data['Revision'][0]['content']);
  $this->set('data', $data);
  $this->render('preview', 'ajax');
 }

/**
 *  Edit WikiPage
 *  @access public
 *  @return void 
 */
 public function edit($username=Null, $slug=Null)
 {
   #die(debug($this->request->data));
   if ( !empty($this->request->data['Wiki']) ):
        if ( !$this->Wiki->User->UserVclassroom->belongs($this->Auth->user('id'), $this->request->data['Inner']['vclassroom_id']) ):
            exit('You do not belong to this classroom');
        endif;
        #$this->request->data['Revision'][0]['content'] = $this->request->data['Revision'][0]['content'];
        $this->request->data['Revision']['ip']          = $_SERVER['REMOTE_ADDR']; 
        $this->request->data['Revision']['user_id']     = (int) $this->Auth->user('id');
        $this->request->data['Revision']['content']     = $this->request->data['Revision'][0]['content'];
        $this->request->data['Revision']['wiki_id']     = $this->request->data['Wiki']['id'];
        $this->request->data['Revision']['revision']    = (int) ($this->request->data['Revision'][0]['revision'] + 1);
        #die(debug($this->request->data));
        $lines = $this->__fiveLines();
        if ( $lines ):
            $this->Wiki->Revision->save($this->request->data);
            $this->set('msg', $lines);
        else:
            $this->set('msg', $lines);
        endif;
        $this->render('saved');
   elseif($slug != Null):
        $this->Edublog->setUserId($username);    # blogger elements
        $wiki_id    = (int) $this->Wiki->field('Wiki.id', array('Wiki.slug'=>$slug));
        $this->request->data = $this->Wiki->read(Null, $wiki_id);
        #die(debug($this->request->data));
        # student belongs to this class?
        $this->set('belongs', $this->Wiki->User->UserVclassroom->belongs($this->Auth->user('id'), $this->request->data['Wiki']['vclassroom_id']));
   endif;
 }

/**
 *  Check if at least some lines were edited
 *  @access public
 *  @return boolean
 */
 private function __fiveLines()
 {
   $content = $this->Wiki->Revision->field('content', array('wiki_id'=> $this->request->data['Wiki']['id']), 'id DESC');
   $check = explode("\n", $content);
   $lines = count($check);
   $check2 = explode("\n", $this->request->data['Revision'][0]['content']);
   $lines2 = count($check2);
   $l = $lines2 - $lines;
   if ($l > 3):
       return True;
   else:
       return False;
   endif;
 }
 /** ====  ADMIN SECTION ====*/

/**
 *  Points toi students
 *  @params int
 *  @params int
 *  @access public
 *  @return void 
 */
 public function admin_points($revision_id, $sense)
 {
   $points = (int) $this->Wiki->Revision->field('points', array('Revision.id'=>$revision_id));
   $points = ($sense == 'up' ) ? ($points + 1) : ($points - 1);
   $this->Wiki->Revision->id   = (int) $revision_id;

   if ($this->Wiki->Revision->saveField('points', $points)):
          $this->set('points', $points);
	  $this->render('admin_points', 'ajax');
   endif;
 }

/**
 *  Edit Wiki
 *  @access public
 *  @params int
 *  @return void 
 */
 public function admin_edit($wiki_id=null)
 {
   $this->layout    = 'admin';
   $this->set('subjects', Set::combine($this->Wiki->Subject->find('all', array('order' => 'title')), "{n}.Subject.id","{n}.Subject.title"));
   $vclassrooms = $this->Wiki->User->getVclassrooms($this->Auth->user('id'));
   #die(debug($vclassrooms));
   $this->set('vclassrooms',$vclassrooms);

   if ( !empty($this->request->data['Wiki']) ):
	
		$this->request->data['Revision'][0]['content'] = $this->request->data['Revision'][0]['content'];
		$this->request->data['Revision']['ip']         = $_SERVER['REMOTE_ADDR']; 
		$this->request->data['Revision']['user_id']    = (int) $this->Auth->user('id');
		$this->request->data['Revision']['content']    = $this->request->data['Revision'][0]['content'];
		if (!isset($this->request->data['Wiki']['id'])):  #new WikiPage
		    $this->request->data['Wiki']['title'] = $this->request->data['Wiki']['title']; # ??
		    $this->request->data['Revision']['revision'] = (int) 1;
		    $this->request->data['Wiki']['slug']     = (string) $this->Wiki->makeSlug($this->request->data['Wiki']['title']);
		    $this->request->data['Wiki']['user_id']  = (int) $this->Auth->user('id');
		    $this->Wiki->id = null;
		    # Something wrong with validation! I don't know how, but it works! 
		    if (strlen($this->request->data['Wiki']['title'])>=4):
		   	    $this->Wiki->save($this->request->data);
			    $this->request->data['Revision']['wiki_id']  = $this->Wiki->id;
		        $this->Wiki->Revision->save($this->request->data);
			    $dataSaved=true;
		    else:
			    $this->Wiki->validates();
		    endif;
		else:
		    $this->request->data['Revision']['wiki_id']  = $this->request->data['Wiki']['id'];
		    $this->request->data['Revision']['revision'] = (int) ($this->request->data['Revision'][0]['revision'] + 1);
		    #die(debug($this->request->data));
		    if ($this->Wiki->validates()):
			    $this->Wiki->save($this->request->data);
			    $this->Wiki->Revision->save($this->request->data);
			    $dataSaved = True;
		    endif;
		endif;

	    if ( isset($dataSaved) ): 
			if ($this->request->data['Wiki']['end'] == 0 ):
		     		$id = (int) $this->request->data['Revision']['wiki_id'];
		     		$return = '/admin/wikis/edit/'.$id;
			else:
			     $return = '/admin/wikis/listing';
			endif;
				$this->msgFlash(__('Data saved', true),$return);
		endif; 
		
   elseif ($wiki_id != null && intval($wiki_id)):
       $this->request->data = $this->Wiki->read(null, $wiki_id);
   endif;
 }
  
/**
 *  List in admin
 *  @access public
 *  @return void 
 */
 public function admin_listing() 
 {
  $this->layout = 'admin';
  $params = array('conditions'   => array('Wiki.user_id'=>$this->Auth->user('id')),
                  'fields'       => array('Wiki.id', 'Wiki.title', 'Wiki.public', 'Wiki.status', 'Wiki.slug'),
                  'order'        => 'Wiki.title',
                  'limit'        => 20);
  $this->set('data', $this->Wiki->find('all', $params));
 }
 
/**
 *  Change status enabled/disabled actived
 *  @params int
 *  @params string
 *  @access public
 *  @return void 
 */
 public function admin_change($wiki_id, $status)
 {  
    $new_status     = ($status == 0 ) ? 1 : 0; 
    $this->Wiki->id = (int) $wiki_id;
    if ($this->Wiki->saveField('status',$new_status)):
	    $this->msgFlash(__('Status modified'), '/admin/wikis/listing');
    endif;
 }

/**
 *  Change status  public/no public 
 *  @params int
 *  @params string
 *  @access public
 *  @return void 
 */
 public function admin_public($wiki_id, $public)
 {  
    $new_public     = ($public == 0 ) ? 1 : 0; 
    $this->Wiki->id = (int) $wiki_id;
    if ($this->Wiki->saveField('public',$new_public)):
	    $this->msgFlash(__('Status modified'), '/admin/wikis/listing');
    endif;
 }

/**
 *  Drop WikiPage
 *  @params int $wiki_id
 *  @access public
 *  @return void 
 */
 public function admin_delete($wiki_id)
 {
  if ($this->Wiki->delete($wiki_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/wikis/listing');
 }
}

# ? > EOF
