<?php
/**
 * Wizard helper by jaredhoyt.
 * Creates links, outputs step numbers for views, and creates dynamic progress menu as the wizard is completed.
 * PHP version 5
 *
 * Comments and bug reports welcome at jaredhoyt AT gmail DOT com
 *
 * Licensed under The MIT License
 *
 * @writtenby		jaredhoyt
 * @lastmodified	Date: March 11, 2009
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */ 
class WizardHelper extends AppHelper {

  public $helpers = array('Session','Html');

  public $output = Null;

/**
 * undocumented function
 *
 * @param string $key optional key to retrieve the existing value
 * @return mixed data at config key (if key is passed)
 */
 public function config($key = null) 
 {
	if ($key == null) 
    {
			return $this->Session->read('Wizard.config');
	} else {
			$wizardData = $this->Session->read('Wizard.config.'.$key);
			if (!empty($wizardData)):
				return $wizardData;
            else:
				return Null;
            endif;
   }
 }
/**
 * undocumented function
 *
 * @param string $title 
 * @param string $step 
 * @param string $htmlAttributes 
 * @param string $confirmMessage 
 * @param string $escapeTitle 
 * @return string link to a specific step
 */
 public function link($title, $step = Null, $htmlAttributes = array(), $confirmMessage = False, $escapeTitle = True) 
 {
   if ($step == null):
			$step = $title;
   endif;
   $wizardAction = $this->config('wizardAction');
		
   return $this->Html->link($title, $wizardAction.$step, $htmlAttributes, $confirmMessage, $escapeTitle);
 }
/**
 * Retrieve the step number of the specified step name, or the active step
 *
 * @param string $step optional name of step
 * @param string $shiftIndex optional offset of returned array index. Default 1
 * @return string step number. Returns false if not found
 */
 public function stepNumber($step = null, $shiftIndex = 1) {
		if ($step == null) {
			$step = $this->config('activeStep');
		}
		
		$steps = $this->config('steps');
		
		if (in_array($step, $steps)) {
			return array_search($step, $steps) + $shiftIndex;
		} else {
			return false;
		}
	}
/**
 * Returns a set of html elements containing links for each step in the wizard. 
 *
 * @param string $titles 
 * @param string $attributes pass a value for 'wrap' to change the default tag used
 * @param string $htmlAttributes 
 * @param string $confirmMessage 
 * @param string $escapeTitle 
 * @return string
 */
  public function progressMenu($titles = array(), $attributes = array(), $htmlAttributes = array(), $confirmMessage = False, $escapeTitle = True) 
  {
	 $wizardConfig = $this->config();
	 extract($wizardConfig);	
		
		$attributes = array_merge(array('wrap' => 'div'), $attributes);
		extract($attributes);
		
		$incomplete = null;

		foreach ($steps as $title => $step) {
			$title = empty($titles[$step]) ? $step : $titles[$step];
			
			if (!$incomplete) {
				if ($step == $expectedStep) {
					$incomplete = true;
					$class = 'expected';
				} else {
					$class = 'complete';
				}
				if ($step == $activeStep) {
					$class .= ' active';
				}
				$this->output .= "<$wrap class='$class'>" . $this->Html->link($title, array('action' => $wizardAction, $step), $htmlAttributes, $confirmMessage, $escapeTitle) . "</$wrap>";
			} else {
				$this->output .= "<$wrap class='incomplete'>" . $title . "</$wrap>";
			}
		}
		
		return $this->output;
	}
}

# ? > EOF

