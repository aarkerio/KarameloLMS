<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Fixture/CommentFixture.php
 */
class CommentFixture extends CakeTestFixture {
    
 /*
  * Optional Importing table information and records
  */
   #public $import = array('Model' => array('Comment'), 'connection' => 'default');

    /* Optional. Set this property to load fixtures to a different test datasource */
    public $useDbConfig = 'test';

    public $fields = array(
                       'id'        => array('type' => 'integer', 'key' => 'primary'),
                       'comment'   => array('type' => 'text',    'null' => False),
                       'status'    => array('type' => 'integer', 'null' => False),
                       'user_id'   =>  array('type' => 'integer','null' => False),
                       'entry_id'  =>  array('type' => 'integer','null' => False),
                       'blogger_id'=>  array('type' => 'integer','null' => False)
                       );

    public $records = array(
                            array('id'         => 1, 
                                  'comment'    => 'New Comment 11111 Comment New Comment ',
                                  'status'     => 1,
                                  'user_id'    => 2,
                                  'entry_id'   => 6,
                                  'blogger_id' => 1
                                  ),
                            array('id'         => 2, 
                                  'comment'    => 'New Comment 22222 Comment New Comment ',
                                  'status'     => 1,
                                  'user_id'    => 2,
                                  'entry_id'   => 7,
                                  'blogger_id' => 1
                                  ),
                            array('id'         => 3, 
                                  'comment'    => 'New Comment 33333 Comment New Comment ',
                                  'status'     => 0,
                                  'user_id'    => 2,
                                  'entry_id'   => 6,
                                  'blogger_id' => 1
                                  )
                            );
 }

# ? > EOF
