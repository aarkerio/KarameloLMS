<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Fixture/FaqFixture.php
 */

class FaqFixture extends CakeTestFixture {

  #public $import = 'Faq';

  /* Optional. Set this property to load fixtures to a different test datasource */
  public $useDbConfig = 'test';

  public $fields = array(
                       'id'        => array('type' => 'integer', 'key' => 'primary'),
                       'question'  => array('type' => 'string', 'length' => 255, 'null' => False),
                       'answer'    => 'text',
                       'catfaq_id' => array('type' => 'integer', 'null' => False),
                       'user_id'   => array('type' => 'integer', 'null' => False),
                       'display'   =>  array('type' => 'integer'),
                       'status'    => array('type' => 'integer', 'default' => '0', 'null' => False),
                      );

    public $records = array(
            array('id'       => 1,
                  'question' => 'Question',
                  'answer'   => 'Answer Answr 1111 answre 1111 answre 1111',
                  'catfaq_id'=> 2, 
                  'user_id'  => 2,
                  'display'  => 1,
                  'status'   => 1
                 ),
            array('id'       => 2,
                  'question' => 'Question',
                  'answer'   => 'Answer Answr 222 answre 1111 answre 1111',
                  'catfaq_id'=> 2, 
                  'user_id'  => 2,
                  'display'  => 1,
                  'status'   => 1
                 ),
            array('id'       => 3,
                  'question' => 'Question',
                  'answer'   => 'Answer Answr 333 answre 1111 answre 1111',
                  'catfaq_id'=> 2, 
                  'user_id'  => 2,
                  'display'  => 1,
                  'status'   => 1
                 )
              );

}

# ? > EOF
