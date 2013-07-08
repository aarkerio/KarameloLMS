<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Fixture/AcquaintanceFixture.php
 */

class AcquaintanceFixture extends CakeTestFixture {

  #public $import = 'Acquaintance';

  /* Optional. Set this property to load fixtures to a different test datasource */
  public $useDbConfig = 'test';

  public $fields = array(
                       'id'          => array('type' => 'integer', 'key'    => 'primary'),
                       'name'        => array('type' => 'string',  'length' => 255, 'null' => False),
                       'url'         =>  array('type' => 'string', 'length' => 255, 'null' => False), 
                       'description' => array('type' => 'text',    'null'   => False),
                       'user_id'     => array('type' => 'integer', 'null'   => False)
                      );

    public $records = array(
            array('id'          => 1,
                  'name'        => 'Acquaintance name 1111',
                  'url'         => 'http://trac.chipotle-software.com/karamelo/browser/trunk/app?order=name#Model',
                  'description' => 'Acquaintance description 1111', 
                  'user_id'     => 1
                 ),
            array('id'          => 2,
                  'name'        => 'Acquaintance name 222',
                  'url'         => 'http://trac.chipotle-software.com/karamelo/browser/trunk/app?order=name#Model',
                  'description' => 'Acquaintance descriptio n222', 
                  'user_id'     => 1
                 ),
            array('id'          => 3,
                  'name'        => 'Acquaintance name 3333',
                  'url'         => 'http://trac.chipotle-software.com/karamelo/browser/trunk/app?order=name#Model',
                  'description' => 'Acquaintance description 333', 
                  'user_id'     => 1
                 )
              );

}

# ? > EOF
