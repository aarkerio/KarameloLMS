<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Fixture/PermanentClassFixture.php
 */
class PermanentClassFixture extends CakeTestFixture {
    
    /*
     * Optional Importing table information and records
     */
    #public $import = array('Model' => array('PermanentClass'), 'connection' => 'default');

    /* Optional. Set this property to load fixtures to a different test datasource */
    public $useDbConfig = 'test';

    public $fields = array(
                       'id'          => array('type' => 'integer', 'key' => 'primary'),
                       'title'       => array('type' => 'string', 'length' => 255, 'null' => False),
                       'description' => 'text',
                       'user_id'     => 'integer',
                       'archived'    => array('type' => 'integer', 'default' => '0', 'null' => False),
                       'created'     => 'datetime'
                       );

    public $records = array(
                            array('id'          => 1, 
                                  'title'       => 'First Students List',
                                  'description' => 'First Permanent stundents list', 
                                  'user_id'     => 1,
                                  'archived'    => 1, 
                                  #'created'     => 'current_timestamp'
                                  ),
                            array('id'          => 2, 
                                  'title'       => 'Second  Students List', 
                                  'description' => 'Second  Permanent stundents list', 
                                  'archived'    => 0, 
                                  #'created'     => 'current_timestamp', 
                                  'user_id'     => 1),
                            array('id'          => 3, 
                                  'title'       => 'Third  Students List', 
                                  'description' => 'Third  Permanent stundents list', 
                                  'archived'    => 1, 
                                  #'created'     => 'current_timestamp', 
                                  'user_id'     => 1)
                            );
 }

# ? > EOF
