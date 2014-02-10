<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package collection
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/models/collection.php

class Collection extends AppModel {

/**
 *  CakePHP Model class name Its always good practice to include this variable.
 *  @access public    
 *  @var string
 */
 public $name        = 'Collection';

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs   = array('Containable');

/**
 *  CakePHP hasMany relationship
 *  @access public    
 *  @var array
 */   
 public $hasMany = array('Lending' =>
                          array('className'  => 'Lending',
                                'conditions' => '',
                                'order'      => '',
                                'foreignKey' => 'collection_id'
                                )
                          );


/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
 public $belongsTo = array('Type' =>
                          array('className'  => 'Type',
                                'conditions' => '',
                                'order'      => '',
                                'foreignKey' => 'type_id'
                                ),
                          'Clasification'=>
                          array('className'  => 'Clasification',
                                'conditions' => '',
                                'order'      => '',
                                'foreignKey' => 'clasification_id'
                             )
                            );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
                       'title' => array(
                                   'rule'       => array('minLength', 4),
                                   'message'    => 'Title must be at least four characters long',
                                   'allowEmpty' => False,
                                   'required'   => True 
                                  ),
                        'author' => array(
                                   'rule'       => array('minLength', 8),
                                   'message'    => 'Author must be at least 8 characters long',
                                   'allowEmpty' => False,
                                   'required'   => True 
                                   ),
                        'type_id' => array(
                                   'rule'       => 'numeric',
                                   'allowEmpty' => False,
                                   'on'         => 'create',  # but not on update
                                   'required'   => True 
                                   ),
                        'clasification_id' => array(
                                   'rule'       => 'numeric',
                                   'allowEmpty' => False,
                                   'on'         => 'create',  # but not on update
                                   'required'   => True 
                                 )
                         );

/** 
 * Search for media
 * @access public 
 * @param string $keyword 
 * @param string $lang
 * @return mixed array or Null
 */
 public function search($keywords)
 {
  $this->Keywords = explode(' ', $keywords); # convert array to strings in order to make loop
  #die(debug($this->Keywords));
  $u = '';
  foreach($this->Keywords as $k=>$t):
     if ($k != 0):
         $u .=' or ';
     endif;
     $u .='"Collection"."title" ILIKE \'%'.$t.'%\' or "Collection"."author" ILIKE \'%'.$t.'%\' or "Collection"."tags" ILIKE \'%'.$t.'%\'';
  endforeach;
  #die(debug($t));
  $q  = 'SELECT DISTINCT "Collection"."id" AS "Collection__id", "Collection"."author" AS "Collection__author","Collection"."title" AS "Collection__title", "Collection"."taxonomy" AS "Collection__taxonomy", ';
  $q .= '"Collection"."copies" AS "Collection__copies", "Collection"."clasification_id" AS "Collection__clasification_id","Collection"."created" AS "Collection__created", ';
  $q .= '"Clasification"."name" AS "Clasification__name"  FROM "collections" AS "Collection", "clasifications" AS "Clasification"  WHERE ';
  $q .= '('.$u.')';
  $q .= ' and ("Collection"."clasification_id" = "Clasification"."id")';
  #debug($q);
  $data = $this->query($q);
  return $data;
 }
}

# ? > EOF
