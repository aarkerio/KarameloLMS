<?php
/*
 * Chipotle Software(c) 2012
 */
class PcStudentFixture extends CakeTestFixture {
    
    /*
     * Optional Importing table information and records
     */
    public $import = array('Model' => 'PcStudent', 'table' => 'pc_students', 'connection' => 'default', 'records' => True);

    /* Optional. Set this property to load fixtures to a different test datasource 
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
                            array('id' => 1, 'title' => 'First Article','description' => 'First Article Descriptiion', 
                                  'archived' => '1', 'created' => 'NOW()', 'user_id' => 1),
                            array('id' => 2, 'title' => 'Second Article', 'description' => 'Second Article Descriptiion', 'archived' => 1, 
                                   'created' => 'NOW()', 'user_id' => 1),
                            array('id' => 3, 'title' => 'Third Article', 'description' => 'Third Article Descriptiion', 'archived' => 1, 
                                   'created' => 'NOW()', 'user_id' => 2)
                            );
    */
 }

# ? > EOF
