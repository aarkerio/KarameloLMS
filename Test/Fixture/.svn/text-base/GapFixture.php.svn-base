<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Fixture/GapFixture.php
 */
class GapFixture extends CakeTestFixture {
    
 /*
  * Optional Importing table information and records
  */
   #public $import = array('Model' => array('Gap'), 'connection' => 'default');

    /* Optional. Set this property to load fixtures to a different test datasource */
    public $useDbConfig = 'test';

    public $fields = array(
                       'id'           => array('type' => 'integer',   'key'    => 'primary'),
                       'title'        => array('type' => 'string',    'length' => 255, 'null' => False),
                       'instructions' => array('type' => 'text',      'length' => 255, 'null' => False),
                       'gaps'         => array('type' => 'text',      'length' => 255, 'null' => False),
                       'license_id'   => array('type' => 'integer',   'null'   => False),
                       'created'      => array('type' => 'timestamp', 'null'   => False),
                       'updated'      => array('type' => 'timestamp', 'null'   => False),
                       'user_id'      => array('type' => 'integer',   'null'   => False),
                       'status'       => array('type' => 'integer',   'null'   => False),
                       'archived'     => array('type' => 'integer',   'null'   => False),
                       'points'       => array('type' => 'integer',   'null'   => False),
                       'knet'         => array('type' => 'integer',   'null'   => False)
                       );

    public $records = array(
                         array('id'          => 1, 
                               'user_id'     => 1,
                               'title'        => 'Title ññ one!', 
                               'instructions' => 'Instructioins sadsald ajdsajdjashdkjashóló sadsa í',
                               'gaps'         => 'dasdasdsadasd **asdsad**  sadsadsa  *sadsad*',
                               'license_id'   => 1,
                               'created'      => 'now()',
                               'updated'      => 'now()',
                               'status'       => 1,
                               'archived'     => 0,
                               'points'       => 4,
                               'knet'         => 1
                              ),
                         array('id'          => 2, 
                               'user_id'     => 1,
                               'title'        => 'Title ññ o two!', 
                               'instructions' => 'Instructioins  two sadsald ajdsajdjashdkjashóló sadsa í',
                               'gaps'         => 'dasdasdsadasd  two two two two **asdsad** sad   twosadsa  *sadsad*',
                               'license_id'   => 1,
                               'created'      => 'now()',
                               'updated'      => 'now()',
                               'status'       => 1,
                               'archived'     => 0,
                               'points'       => 7,
                               'knet'         => 1
                                  ),
                         array('id'          => 3, 
                               'user_id'     => 1,
                               'title'        => 'Title ññ three !', 
                               'instructions' => 'Instructioins  three sadsald ajdsa  threejdjashdkjashóló sadsa í',
                               'gaps'         => 'dasdasdsadasd **asdsad**  sadsadsa three  *sadsad*  three',
                               'license_id'   => 1,
                               'created'      => 'now()',
                               'updated'      => 'now()',
                               'status'       => 1,
                               'archived'     => 0,
                               'points'       => 7,
                               'knet'         => 0
                                  )
                             );
 }

# ? > EOF
