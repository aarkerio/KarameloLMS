<?php

class UserHelper extends Helper
{
  public $tab = "  ";
  
  public function show($name, $data)
  {
    list($modelName, $fieldName, $fieldEmail) = explode('/', $name);
    
    $output = $this->list_element($data, $modelName, $fieldName, $fieldEmail, 0);
    
    //return to view
    return $this->output($output);
  }
  
  public function list_element($data, $modelName, $fieldName, $fieldEmail, $level)
  {
    $tabs = "\n" . str_repeat($this->tab, $level * 2);
    
    $li_tabs = $tabs . $this->tab;
    
    $output = $tabs. "<ul>";
    
    
    foreach ($data as $key=>$val)
    {
      $output .= $li_tabs . "<li>".$val[$modelName][$fieldName] . $val[$modelName][$fieldEmail];
      
      if ( isset($val['children'][0]) ) {
        
        $output .= $this->list_element($val['children'], $modelName, $fieldName, $level+1);
        
        $output .= $li_tabs . "</li>";
        
      }  else {
         
        $output .= "</li>";
        
      }
    }
    $output .= $tabs . "</ul>";
    
    return $output;
  }
}
?>