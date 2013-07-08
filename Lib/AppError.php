<?php
/*
 * 
 */
#file: APP/Lib/AppError.php

class AppError {

    public static function handleError($code, $description, $file = Null, $line = Null, $context = Null) 
    {
        echo 'There has been an error!';
    }

/**
 * securityError
 *
 * @return void
 */
  public function securityError() 
  {
        $this->controller->set(array(
            'referer' => $this->controller->referer(),
        ));
        $this->_outputMessage('security');
  }
}

# ? > EOF
