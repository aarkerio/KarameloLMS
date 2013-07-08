<?php 
/*
 *  @author: Suhail Doshi
 *  @see http://bakery.cakephp.org/articles/view/tagcloud-helper
 */
    
class TagcloudHelper extends Helper {
	
/**
 *  @param array $dataSet Example: array('name' => 100, 'name2' => 200)
 *   
 *  returns associative array.
 */
 public function formulateTagCloud($dataSet) 
 {
    asort($dataSet); // Sort array accordingly.
            
    # Retrieve extreme score values for normalization
    $minimumScore = intval(current($dataSet));
    $maximumScore = intval(end($dataSet));

     # Populate new data array, with score value and size.
    foreach ($dataSet as $tagName => $score) 
    {
         $size = $this->__getPercentSize($maximumScore, $minimumScore, $score);
         $data[$tagName] = array('score'=>$score, 'size'=>$size);
            }
            
            return $data;
 }
        
/**
  *  @access private
  *  @param int $maxValue Maximum score value in array.
  *  @param int $minValue Minimum score value in array.
  *  @param int $currentValue Current score value for given item.
  *  @param int [$minSize] Minimum font-size.
  *  @param int [$maxSize] Maximum font-size.
  *
  *  returns int percentage for current tag.
  */
 private function __getPercentSize($maximumScore, $minimumScore, $currentValue, $minSize = 90, $maxSize = 200) 
 {
   if ($minimumScore < 1): 
       $minimumScore = 1;
   endif;
   $spread = $maximumScore - $minimumScore;
   if ($spread == 0): 
       $spread = 1;
   endif;
   # determine the font-size increment, this is the increase per tag quantity (times used)
   $step = ($maxSize - $minSize) / $spread;
   # Determine size based on current value and step-size.
   $size = $minSize + (($currentValue - $minimumScore) * $step);
   return $size;
  }
	
/**
  *  @param array $tags An array of tags (takes an associative array)
  *  @access public  
  *  returns shuffled array of tags for randomness.
  */
 public function shuffleTags ($tags) 
 {
   while (count($tags) > 0) 
   {
	 $val = array_rand($tags);
	  $new_arr[$val] = $tags[$val];
	  unset($tags[$val]);
   }
   if (isset($new_arr)):
  	   return $new_arr;
   endif;
  }
 }
?>