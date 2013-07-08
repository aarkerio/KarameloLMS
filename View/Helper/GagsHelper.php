<?php 
/*
 * GagsHelper By Chipotle Software(c) 2009-2012.
 * @version 0.7
 * @license GPLv3
 */

/**
 * Import libraries
 */
App::import('Vendor','HTMLPurifier' ,array('file'=>'htmlpurifier'.DS.'library'.DS.'HTMLPurifier.auto.php'));

class GagsHelper extends AppHelper {

/**
 * Holds the content to be cleaned.
 *
 * @access private
 * @var mixed
 */
 public  $tainted         = Null; 
 public  $initialized     = False;
 public  $helpers         = array('Html', 'Js', 'Form');
 protected static $_lines = Null;  # <-- experimental 
 private $__gdataObject   = Null;

/**
 * Default encoding
 * @access private
 * @var string
 */
 private static $_encoding  =  'UTF-8';

/**
 * Colors in tables
 * @access public
 * @var array
 */
 public static $aRow = array('class'=>'altRow','onmouseover'=>"this.className='highlight'",'onmouseout'=>"this.className='altRow'"); 
 public static $eRow = array('class'=>'evenRow','onmouseover'=>"this.className='highlight'",'onmouseout'=>"this.className='evenRow'");

/**
 * Before complete in JsHelper options 
 * @access public
 * @var string
 */
 public function ajaxBefore($div='list', $img='loading',  $effectOut='fadeOut',  $effectIn='fadeIn') 
 {
   $before  = $this->Js->get("#$img")->effect($effectIn,   array('buffer'=>False));
   if ( $div != False):
       $before .= $this->Js->get("#$div")->effect($effectOut, array('buffer' => False));
   endif;
   return $before;
 }

/**
 * Before complete in JsHelper options 
 * @access public
 * @var string
 */
 public function ajaxComplete($div='list', $img='loading', $effectOut='fadeOut',  $effectIn='fadeIn') 
 {
   $complete  = $this->Js->get("#$img")->effect($effectOut,array('buffer'=>False));
   $complete .= $this->Js->get("#$div")->effect($effectIn, array('buffer' => False));
   return $complete;
 }

/**
 * Tip ans UnTip on MouseOver over Title columns
 * @access public
 * @var string
 */
 public function mouseOverOut($div=null, $text=null)
 {
   $mouseOverOut = $this->Js->get("#$div")->event('mouseover', "Tip('".__("$text", True)."')");
   $mouseOverOut .= $this->Js->get("#$div")->event('mouseout', 'UnTip()');
   return $mouseOverOut;
 }

/**
 * Solve issue with initial change status pagination on sort direction
 * @access public
 * @var string
 */
 public function sortDir($sortKeyToken, $sortDir, $key=null)
 {
  if ($sortKeyToken[0] == "$key"):
      $direction = 'desc';
  else:
      $direction = $sortDir;        
  endif;

  return $direction;
 }


/**
 * Solve issue with initial change status pagination on sort key
 * @access public
 * @var string
 */
 public function sortKey($sortKeyToken=Null, $sortKey=Null)
 {
    if(array_key_exists(1, $sortKeyToken)):
       if ($sortKeyToken[1] == 'DESC' || $sortKeyToken[1] == 'ASC'):
         $sortKey = $sortKeyToken[0];            
       endif;
    endif;

    return $sortKey;
 }

/**
 * Delete button with confirmation (DEPRECATED)
 * @access public
 * @return string
 */
 public function confirmDel($id, $model) 
 {
   $msg   = __('Are you sure to want to delete this?');   
   $strB  = $this->Form->create($model, array('action'=>'/delete/'.$id, "onsubmit"=>"return confirm('".$msg."')"));
   $strB .= $this->Form->end(__('Delete'));
        
   return $strB;
 }

 public function sendEdit($id, $model, $action='edit') 
 {      
  $strB  = $this->Form->create($model, array('action'=>'admin_'.$action.'/'.$id));
  $strB .= $this->Form->end(__('Edit'));
        
  return $strB;
 }

/**
 * published or draft
 * @access public
 */
 public function setStatus($s) 
 {
   $status = ( $s == 1 ) ? __('Published', True) : __('Draft', True);          
   return $status;
 }

/***
 * The image manager in small window, for instance /admin/entries/edit
 * @access public
 */
 public function setImages() 
 {
  $img  = '<p style="text-align:right;width:150px;float:right">';
  $img .= $this->Html->link($this->Html->image('admin/myimages.jpg', array('alt'=>__('My Images', True), 'title'=>__('My Images', True), 'onmouseover'=>"Tip('".__('Image manager, insert or upload a new image to your resources', True)."')", 'onmouseout'=>"UnTip()")), '#', 
          array('onclick'=>"window.open('/admin/images/listing/set', '_blank','toolbar=no, scrollbars=yes,width=700,height=500'); return false;",'escape'=>False));
  $img .= '</p>';
  return $img;
 }

/**
 *  Helper in forms
 *  @access public
 *  @return string
 */
 public function helps($txt, $enabled, $div=True)
 {
  if ( !$enabled ):
      return '';
  endif;
  $str = $this->Html->image('admin/help_icon.png',array('alt'=>'help','onmouseover'=>"Tip('".__($txt, True)."')",'onmouseout'=>"UnTip()"));
  if ( $div ):
      $str= $this->Html->div('helpicon', $str);    
  endif;

  return $str;
 }

/**
 *
 * Under construction
 */
  public function construction() 
  {
    return $this->Html->para('center', $this->Html->image('static/construction.jpg', array('alt'=>'Under construction', 'title'=>'Under construction')));
  }

/**
 * I use this shit in wiki section
 * @access public
 */
 public function delTags($code)
 {
    return strip_tags($code, '<p><a><img><h1><span><h2><hr>');
 }

/**
 * Podcast audio player
 * @access public
 * @param string  $file
 * @param integer $id
 * @return string
 */
 public function audioPlayer($file, $id)
 {
  $player  = '<object type="application/x-shockwave-flash" data="/files/flash/audioplayer/player.swf" id="audioplayer1" height="24" width="290">';
  $player .= '<param name="movie" value="/files/flash/audioplayer/player.swf">';
  $player .= '<param name="FlashVars" value="playerID=audioplayer'.$id.'&soundFile=/files/podcasts/'.$file.'">';
  $player .= '<param name="quality" value="high">';
  $player .= '<param name="menu" value="false">';
  $player .= '<param name="wmode" value="transparent">';
  $player .= '</object>';

  return $player;
 }

/**
 *  Max upload size warning
 *  @access public
 *  @return string
 */
 public function maxUploadSize()
 {
   return $this->Html->para(Null, __('Upload max size of file', True). ': ' . ini_get('upload_max_filesize'));
 }

/**
 * the hidden animated gif in ajax stuff, fucking genious ha?
 * @access public
 */
 public function imgLoad($divname='loading')
 {
   echo $this->Html->div(Null,$this->Html->image('static/loading.gif',array('alt'=>'Loading')),array('id'=>$divname,'style'=>'display:none'));
 }

/**
 *  Div close
 *  @access public
 *  @return string
 */
 public function ajaxDiv($id, $class=Null) 
 {
   $options = array('id'=>$id);
   return $this->Html->div($class, Null, $options);
 }

 /**
  * Build a list of HTML attributes.
  *
  * @param  array   $attributes
  * @return string
  */
 public static function attributes($attributes)
 {
   $html = array();

   foreach ($attributes as $key => $value):
       # Assume numeric-keyed attributes to have the same key and value.
       # Example: required="required", autofocus="autofocus", etc.
       if ( is_numeric($key) ): 
           $key = $value; 
       endif;

       if ( !is_null($value) ):         
           $html[] = $key.'="'.static::entities($value).'"';
       endif;
   endforeach;

   return (count($html) > 0) ? ' '.implode(' ', $html) : '';
 }

 /**
  * Convert HTML characters to entities.
  *
  * @param  string  $value
  * @return string
  */
 public static function entities($value)
 {
   return htmlentities($value, ENT_QUOTES, self::$_encoding, False);
 }

 /**
  * Generate an HTML mailto link.
  *
  * @param  string  $email
  * @param  string  $title
  * @param  array   $attributes
  * @return string
  */
 public static function mailto($email, $title = Null, $attributes = array())
 {
   $email = static::email($email);

   if (is_null($title)):
       $title = $email;
   endif;

   return '<a href="&#109;&#097;&#105;&#b108;&#116;&#111;&#058;'.$email.'"'.static::attributes($attributes).'>'.static::entities($title).'</a>';
 }

 /**
  * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
  *
  * @param  string  $email
  * @return string
  */
 public static function email($email)
 {
   return str_replace('@', '&#64;', static::obfuscate($email));
 }

 /**
  * Obfuscate a string to prevent spam-bots from sniffing it.
  *
  * @param  string  $value
  * @return string
  */
 public static function obfuscate($value)
 {
   $safe = '';
   foreach (str_split($value) as $letter):
       switch (rand(1, 3)):
              # Convert the letter to its entity representation.
              case 1:
                     $safe .= '&#'.ord($letter).';';
                     break;

              # Convert the letter to a Hex character code.
              case 2:
                     $safe .= '&#x'.dechex(ord($letter)).';';
                     break;

              # No encoding.
              case 3:
                     $safe .= $letter;
       endswitch;
  endforeach;
  return $safe;
 }
 /**
  *  Div close
  *  @access public
  *  @return string
  */
 public function divEnd($divId) 
 {
   return "</div><!-- $divId ends -->";
 }

 /**
  * Clreaner XSS experimental 
  */
 public function purifier($dirty_html, $html = FALSE) 
 {
  $encoded = HTMLPurifier_Encoder::cleanUTF8($dirty_html);
  $config  = HTMLPurifier_Config::createDefault();

  if ($html === FALSE):
      $clean = htmlspecialchars($encoded, ENT_COMPAT, 'UTF-8'); 
  else:
      //the next few lines allow the config settings to be cached
      $config->set('HTML', 'DefinitionID', 'made by debugged interactive designs');
      $config->set('HTML', 'DefinitionRev', 1);
      //levels describe how aggressive the Tidy module should be when cleaning up html
      //four levels: none, light, medium, heavy
      $config->set('HTML', 'TidyLevel', 'heavy');
      //check the top of your html file for the next two
      //$config->set('HTML', 'Doctype', 'XHTML 1.0 Transitional');
      $config->set('Core', 'Encoding', 'UTF-8');
  endif;

  $HTMLpurifier = new HTMLPurifier($config); 
  $clean = $HTMLpurifier->purify($dirty_html);    
   
  return $clean; 
 }

/**
 * avoid XSS
 * @access public
 */  
 public function clean($input)
 {
  if (get_magic_quotes_gpc()):
      $input = stripslashes($input);
  endif;
  
  $input = str_replace(array("&amp;", "&lt;", "&gt;"), array("&amp;amp;", "&amp;lt;", "&amp;gt;"),$input);
  $input = preg_replace('#(&\#*\w+)[\x00-\x20]+;#u', "$1;",$input);
  $input = preg_replace('#(&\#x*)([0-9A-F]+);*#iu', "$1$2;",$input);
  $input = html_entity_decode($input, ENT_COMPAT, "UTF-8");
  $input = preg_replace('#(<[^>]+[\x00-\x20\"\'\/])(on|xmlns)[^>]*>#iUu', "$1>",$input);
  $input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*)[\\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2nojavascript...',$input);
  $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'\"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iUu', '$1=$2novbscript...',$input);
 $input = preg_replace('#([a-z]*)[\x00-\x20]*=*([\'\"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#iUu','$1=$2nomozbinding...',$input);
 $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'\"]*)[\x00-\x20]*data[\x00-\x20]*:#Uu', '$1=$2nodata...',$input);
 $input = preg_replace('#(<[^>]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*expression[\x00-\x20]*\([^>]*>#iU', "$1>",$input);
 $input = preg_replace('#(<[^>]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*behaviour[\x00-\x20]*\([^>]*>#iU', "$1>",$input);
 $input = preg_replace('#(<[^>]+)style[\x00-\x20]*=[\x00-\x20]*([\`\'\"]*).*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*>#iUu', "$1>",$input);
 $input = preg_replace('#</*\w+:\w[^>]*>#i', "",$input);
 do 
 {
  $oldstring =$input;
  $input = preg_replace('#</*(applet|meta|xml|blink|link|style|script|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "",$input);
 } while ($oldstring != $input);
 $input = str_replace(array("&amp;", "&lt;", "&gt;"), array("&amp;amp;", "&amp;lt;", "&amp;gt;"),$input);
 return $input;
 }
} 

# ? > EOF
