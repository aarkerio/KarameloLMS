<?php
class EntryFixture extends CakeTestFixture {

  #public $import = 'Entry';

  public $fields = array(
                       'id'         => array('type' => 'integer', 'key' => 'primary'),
                       'title'      => array('type' => 'string', 'length' => 255, 'null' => False),
                       'body'       => 'text',
                       'subject_id' => array('type' => 'integer', 'null' => False),
                       'user_id'    => array('type' => 'integer', 'null' => False),
                       'status'     => array('type' => 'integer', 'default' => '0', 'null' => False),
                       'created'    => 'datetime',
                       'order'      =>  array('type' => 'integer')
                           );

    public $records = array(
            array('id'        => 1,
                  'title'     => 'First Article',
                  'body'      => 'First Article Body',
                  'subject_id'=> 1, 
                  'user_id'   => 1,
                  'status'    => 1,
                  'created'   => 'now()', 
                  'order'     => 1
                 ),
            array('id'        => 2,
                  'title'     => 'Second  Article',
                  'body'      => 'Second Article Body',
                  'subject_id'=> 2, 
                  'user_id'   => 2,
                  'status'    => 1,
                  'created'   => 'now()', 
                  'order'     => 1
                 ),
            array('id'        => 3,
                  'title'     => '33333 Article',
                  'body'      => '3333 Article Body',
                  'subject_id'=> 2, 
                  'user_id'   => 1,
                  'status'    => 1,
                  'created'   => 'now()', 
                  'order'     => 1
                 )
              );

}

# ? > EOF
