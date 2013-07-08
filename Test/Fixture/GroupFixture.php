<?php
/*
 * Chipotle Software(c) 2012
 */
class GroupFixture extends CakeTestFixture {
    
    /*
     * Optional Importing table information and records
     */
    #public $import = array('Model' => 'Group', 'table' => 'users', 'connection' => 'default', 'records' => True);
    
     public $fields = array(
                         'id'        => array('type' => 'integer', 'key' => 'primary'),
                         'name'  => array('type' => 'string', 'length' => 255, 'null' => False),
                         'active'    => array('type' => 'integer'),
                         'created'   => array('type' => 'datetime')
                        );

    public $datetime = Null;

    public $records = array(
               array('id'      => 1,
                     'name'    => 'Admins',
                     'active'  => 1,
                     'created' => Null
                    ),
               array('id'      => 2,
                     'name'    => 'Teachers',
                     'active'  => 1,
                     'created' => Null
                     ),
               array('id'      => 3,
                     'name'    => 'Students',
                     'active'  => 1,
                     'created' => Null
                      ),
               array('id'      => 4,
                     'name'    => 'Parents',
                     'active'  => 1,
                     'created' => Null
                    )
               );

 
}

# ? > EOF