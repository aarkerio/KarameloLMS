<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package wiki
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Wiki.php

#PEAR http://pear.reversefold.com/dokuwiki/text_wiki:samplepage
App::import('Vendor', 'Text_Wiki',  array('file' => 'PEAR/Text/Wiki.php'));

class Wiki extends AppModel {
 
/**
 *  Used searching users
 *  @access public 
 *  @var array
 */ 
  public $hasMany = array('Revision' =>
                           array('className'  => 'Revision',
                                 'conditions' => '',
                                 'order'      => 'id DESC',
                                 'foreignKey' => 'wiki_id'
                           )
			  );


/**
 * CakePHP belongsTo
 * @access public
 * @var array
 */
 public $belongsTo = array('User' =>
                           array('className'  => 'User',
                                 'conditions' => '',
                                 'order'      => '',
                                 'foreignKey' => 'user_id',
                                 'fields'     =>'id, username, avatar'
                           ),
                           'Subject' =>
                           array('className'  => 'Subject',
                                 'conditions' => '',
                                 'order'      => Null,
                                 'foreignKey' => 'subject_id',
                                 'fields'     => 'id, title'
                            ),
                           'Vclassroom' =>
                               array('className'  => 'Vclassroom',
                                     'conditions' => '',
                                     'order'      => Null,
                                     'foreignKey' => 'vclassroom_id',
                                     'fields'     => 'id, name'
                           )
                  );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */ 
 public $validate = array(
    'title' => array(
                    array(
	                  'rule' => 'isUnique',
                          'message' => 'There is already a WikiPage with this title',
                          'on'         => 'create', # but not on update
			             ),
                    array(
                          'rule'       => array('minLength', 4),
                          'message'    => 'Title must be at least four characters long',
		                  'allowEmpty' => False,
                          'required'   => True,
                          'on'         => 'create', # but not on update
		                )
                     ),
    'slug' => array(
                    array(
	                  'rule' => 'isUnique',
                          'message' => 'There is already a WikiPage with this slug',
                          'on'         => 'create', # but not on update
			             ),
                    array(
                          'rule'       => array('minLength', 4),
                          'message'    => 'Slug must be at least four characters long',
		                  'allowEmpty' => False,
                          'required'   => True,
                          'on'         => 'create', # but not on update
		                )
                     )
   );

/**
 * render just get the row and version id
 * @access public
 * @param string $slug
 * @param boolean $owner
 * @return array
 */  
 public function render($slug, $owner=False)
 {
  if ( $owner ):
      $conditions   = array('Wiki.slug'=>$slug);
  else:
      $conditions   = array('Wiki.slug'=>$slug, 'Wiki.status'=>1,  'Wiki.public'=>1);
  endif;
  
  $this->User->contain(False);
  
  $params = array('conditions'=>$conditions);
  $wiki = $this->find('first', $params);
  if ( !$wiki ):
      return False;
  endif;
  #die(debug($wiki));
  $content = $this->wikify($wiki['Revision'][0]['content']);
   
  $wiki['Revision'][0]['content'] = $content;
 
  return $wiki;
 }

/**
 *  Wikify:  PEAR does the magic 
 * @access public
 * @param string $raw
 * @uses Text_Wiki
 * @return string
 */
 public function wikify($raw)
 {
   # PEAR Does the magic
   $wiki = new Text_Wiki;
   $wiki->setFormatConf('Xhtml', array('translate'=>2,
				       'quotes'=>'ENT_COMPAT', 'charset'=>'UTF-8'));

   # transform the wiki text.
   $content = $wiki->transform($raw, 'Xhtml');
 
   return $content;
 }

/**
 * makeSlug
 * @access public
 * @param string $title
 * @return string
 */
 public function makeSlug($title) 
 {
    # Turn names such as "It's wrinkled!" into slugs such as "its-wrinkled"
    $slug = strtolower($title); # Make the string lowercase
    $slug = str_replace('\'', '', $slug); // Take out apostraphes. CakePHP takes care of escaping strings before putting them into SQL queries. This is purely for aesthetic purposes - changing "that-s-cool" into "thats-cool"
    $slug = ereg_replace('[^[:alnum:]]+', '_', $slug); // Turn any group of non-alphanumerics into a single hyphen
    $slug = trim($slug, '_'); # Remove unnecessary hyphens from beginning and end

    if (strlen($slug) > 80):
        $slug = substr($slug, 0, 79);
    endif;
    
    return $slug;
 }

/**
 * getRevisions
 * @access public
 * @param string $slug
 * @return string
 */
 public function getRevisions($slug)
 {
   $this->Revision->bindModel(array('belongsTo' => array('User' =>
                           array('className'  => 'User',
                                 'fields' => 'id, username, avatar',
                                 'foreignKey' => 'user_id'
                           )
		        )
		      )
               );

   $this->bindModel(array('hasMany' => array('Revision' =>
                           array('className'  => 'Revision',
                                 'fields' => 'id, user_id, modified, revision, points',
                                 'order'      => 'id DESC',
                                 'foreignKey' => 'wiki_id'
                           )
		        )
		      )
               );

   $params = array('conditions' => array('Wiki.slug'=>$slug),  
                   'contain'    => False);
   return $this->find('first', $params);
 }

/**
 * diff  Diferences (changes) between two versions 
 * @access public
 * @param string $slug
 * @param integer $revision_id
 * @return string
 */
 public function diff($slug, $revision_id)
 {
  $content = (string) '';

  $this->bindModel(array('hasMany' => array('Revision' =>
                           array('className'  => 'Revision',
                                 'fields' => 'id, user_id, content, modified, revision',
                                 'order'      => 'id DESC',
                                 'foreignKey' => 'wiki_id',
                                 'limit'      => 2,
                                 'conditions' => array('Revision.id <='=>$revision_id)
                           )
		        )
		      )
            );
   
  $params = array('conditions' => array('Wiki.slug'=>$slug),  
                  'contain'    => False);
  $data = $this->find('first', $params);
  
   if ( count($data['Revision']) == 1):
       return $data;
   endif;

   $cnt_1 = explode("\n", $data['Revision'][0]['content']);
   $cnt_2 = explode("\n", $data['Revision'][1]['content']); 
   
   foreach ($cnt_1 as $k => $line):
       if ( !in_array($line, $cnt_2) ):
	       $content .= '<span style="color:red">'.$line."</span>\n";
       else:
           $content .= '<span style="color:black">'.$line."</span>\n";
       endif;
   endforeach;
   #die(debug($content));
   #die(debug($data));
   $data['last_content'] = $content;
   return $data;
 }
}

# ? > EOF
