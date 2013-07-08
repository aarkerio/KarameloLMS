<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Fixture/NewsFixture.php
 */

class NewsFixture extends CakeTestFixture {

  #public $import = 'News';

  /* Optional. Set this property to load fixtures to a different test datasource */
  public $useDbConfig = 'test';

  public $fields = array(
                       'id'        => array('type' => 'integer', 'key'    => 'primary'),
                       'title'     => array('type' => 'string',  'length' => 255, 'null' => False),
                       'subject_id'=> array('type' => 'integer', 'null'   => False),
                       'license_id'=> array('type' => 'integer', 'null'   => False),
                       'body'      => array('type' => 'text',    'null'   => False),
                       'created'   => array('type' => 'datetime','null'   => False), 
                       'disc'      => array('type' => 'integer', 'null'   => False),
                       'public'    => array('type' => 'integer', 'null'   => False),
                       'status'    => array('type' => 'integer', 'null'   => False),
                       'user_id'   => array('type' => 'integer', 'null'   => False),
                       'visits'    => array('type' => 'integer', 'null'   => False),
                       'knet'      => array('type' => 'integer', 'null'   => False)
                      );

    public $records = array(
            array('id'        => 1,
                  'title'     => 'Title lesson 111',
                  'subject_id'=> 1,
                  'license_id'=> 1,
                  'body'      => 'Tacubaya is a section of Mexico City located in the west in the Miguel Hidalgo borough. The area has been inhabited since before the Christian era, with its name coming from Nahuatl meaning where water is gathered',
                  'created'   => 'now()', 
                  'disc'      => 0,
                  'public'    => 0,
                  'status'    => 1,
                  'user_id'   => 1,
                  'visits'    => 12,
                  'knet'      => 1
                 ),
            array('id'        => 2,
                  'title'     => 'Title lesson 111',
                  'subject_id'=> 1,
                  'license_id'=> 1,
                  'body'      => 'Tacubaya is a section of Mexico City located in the west in the Miguel Hidalgo borough. The area has been inhabited since before the Christian era, with its name coming from Nahuatl meaning where water is gathered',
                  'created'   => 'now()', 
                  'disc'      => 0,
                  'public'    => 0,
                  'status'    => 1,
                  'user_id'   => 1,
                  'visits'    => 12,
                  'knet'      => 1
                 ),
            array('id'        => 3,
                  'title'     => 'Title lesson 111',
                  'subject_id'=> 1,
                  'license_id'=> 1,
                  'body'      => 'Tacubaya is a section of Mexico City located in the west in the Miguel Hidalgo borough. The area has been inhabited since before the Christian era, with its name coming from Nahuatl meaning where water is gathered',
                  'created'   => 'now()', 
                  'disc'      => 0,
                  'public'    => 0,
                  'status'    => 1,
                  'user_id'   => 1,
                  'visits'    => 12,
                  'knet'      => 1
                 )
              );

}

# ? > EOF
