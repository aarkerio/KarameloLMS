<?php
/**
 *  Chipotle Software(c) 2012
 *  File: APP/Test/Fixture/AroFixture.php
 */
class AroFixture extends CakeTestFixture {

    public $name = 'Aro';

    public $fields = array(
                           'id'              => array('type'    => 'integer', 'Null' => False, 'default' => Null, 'length' => 10, 'key' => 'primary'),
                           'parent_id'       => array('type'    => 'integer', 'Null' => True,  'default' => Null, 'length' => 10),
                           'model'           => array('type'    => 'string',  'Null' => True),
                           'foreign_key'     => array('type'    => 'integer', 'Null' => True,  'default' => Null, 'length' => 10),
                           'alias'           => array('type'    => 'string',  'Null' => True),
                           'lft'             => array('type'    => 'integer', 'Null' => True,  'default' => Null, 'length' => 10),
                           'rght'            => array('type'    => 'integer', 'Null' => True,  'default' => Null, 'length' => 10),
                           'indexes'         => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
                           'tableParameters' => array('charset' => 'utf8')
                           );

    public $records = array(
                            array(
                                  'id'          => 1,
                                  'parent_id'   => Null,
                                  'model'       => 'Group',
                                  'foreign_key' => 1,
                                  'alias'       => 'Admin',
                                  'lft'         => 1,
                                  'rght'        => 4
                                  ),
                            array(
                                  'id'          => 2,
                                  'parent_id'   => Null,
                                  'model'       => 'Group',
                                  'foreign_key' => 2,
                                  'alias'       => 'Teachers',
                                  'lft'         => 5,
                                  'rght'        => 6
                                  ),
                            array(
                                  'id'          => 3,
                                  'parent_id'   => Null,
                                  'model'       => 'Group',
                                  'foreign_key' => 3,
                                  'alias'       => 'Students',
                                  'lft'         => 7,
                                  'rght'        => 8
                                  ),
                            array(
                                  'id'          => 4,
                                  'parent_id'   => Null,
                                  'model'       => 'Group',
                                  'foreign_key' => 4,
                                  'alias'       => 'Parents',
                                  'lft'         => 9,
                                  'rght'        => 10
                                  ),
                             array(
                                  'id'          => 5,
                                  'parent_id'   => Null,
                                  'model'       => 'User',
                                  'foreign_key' => 1,
                                  'alias'       => 'Admin User',
                                  'lft'         => 12,
                                  'rght'        => 13
                                  ),
                              array(
                                  'id'          => 6,
                                  'parent_id'   => Null,
                                  'model'       => 'User',
                                  'foreign_key' => 2,
                                  'alias'       => 'Student User',
                                  'lft'         => 14,
                                  'rght'        => 15
                                  )
                            );
}

# ? > EOF
