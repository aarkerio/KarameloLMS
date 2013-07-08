<?php 
/**
 * 2006-2011 (c) Chipotle Software GPLv3
 * Social buttons
 */
class NewHelper extends Helper
{

/**
 * @acces public
 */
  public $tab = "  ";

/**
 * @acces public
 */  
  public function show($name, $data)
  {
    list($modelName, $id, $titulo, $cuerpo, $fecha) = explode('/', $name);
    
    $output = $this->list_element($data, $modelName, $id, $titulo, $cuerpo, $fecha);
  
    return $this->output($output);
  }
  
/** 
 * @acces public
 */
  public function list_element($data, $modelName, $id, $titulo, $cuerpo, $fecha)
  {
    
    $output = "";
    
    foreach ($data as $key=>$val)
    {
      $idnew = $val[$modelName][$id];  
      $output .= "<div class=\"new_title\">".$val[$modelName][$titulo] . $val[$modelName][$fecha] . "</div>";
      $output .= "<div class=\"new_body\">".$val[$modelName][$cuerpo] . "<br /><br /><br />" ;
      $output .=  '<a href="/news/single/'.$idnew.'">Link to full new</a> <br /></div>';
    }
    
    return $output;
  }
}

# ? > EOF 
