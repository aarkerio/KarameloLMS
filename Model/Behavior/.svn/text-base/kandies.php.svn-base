<?php
/**
 * Kandies Behavior class file.
 *
 * @filesource
 * @link
 * @version 0.1
 * @license	 The GPLv3 License
 * @package app
 * @subpackage app.models.behaviors
 */

class KandiesBehavior extends ModelBehavior
{
 public $__settings = array();
 
 public function setup(&$Model, $settings=array())
 {
   $default = array();
   if (!isset($this->__settings[$Model->alias])):
       if (empty($settings)):
         foreach ($Model->_schema as $fldname=>$fldopts):
                    if ($fldopts['type'] === 'float' || $fldopts['type'] === 'double'):
			            $settings['fields'][] = $fldname;
                    endif;
         endforeach;
     endif;
		     
	$this->__settings[$Model->alias] = $settings;
    endif;  
 }
  
 public function chkDateKandie(&$Model, $model_id)
 {
   $this->recursive = 0;
   
   $field = $Model->field($Model.'id', array('id'=>$model_id, 'CURRENT_DATE <= '.$Model.'.fdate','CURRENT_DATE >=  '.$Model.'.sdate'));
   
   if ( !$field ):   # this kandie is out of date
       return True;
   else:
       return False;
   endif; 
 }
 public function beforeSave(&$Model)
 {	
  $return = parent::beforeSave($Model);
  	
  foreach($this->__settings[$Model->alias]['fields'] as $field):
       if ($Model->hasField($field) && array_key_exists($field, $Model->data[$Model->alias])):
	     $Model->data[$Model->alias][$field] = str_replace(',', '.', $Model->data[$Model->alias][$field]);
       endif;
  endforeach; 
  return $return;
 }

 # change status enabled/disabled actived
 public function admin_change($row_id, $status)
 {  
    $new_status  = ($status == 0 ) ? 1 : 0;
     
    $Model->id     = (int) $row__id;
     
    if ($Model->saveField('status', $new_status)):
        return True;
    else:
        return false;
    endif;
 }
 
 public function admin_delete($row_id)
 {
   if ( $Model->del($row_id) ):
       return True;
   else:
       return False;
   endif;
 }
}
?>