<?php

if ( $api == '2' ):
    echo $this->element('scorm_api_12', array('initVals' => $initVals)); # load Scorm 1.2 and pass $data array with initialized values
else:   
    echo $this->element('scorm_api_14', array('initVals' => $initVals)); # load Scorm 1.4 and pass $data array with initialized values
endif;

# ? > EOF
