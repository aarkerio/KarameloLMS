<?php
/**
 * Chipotle Software(c) 2012    GPLv3 
 */
class UserFixture extends CakeTestFixture {
    
    /*
     * Optional Importing table information and records
     */
    #public $import = array('Model' => 'User', 'table' => 'users', 'connection' => 'default', 'records' => True);
    
     public $fields = array(
                         'id'           => array('type' => 'integer', 'key' => 'primary'),
                         'username'     => array('type' => 'string', 'length' => 255, 'null' => False),
                         'name'         => array('type' => 'string', 'length' => 255, 'null' => False),
                         'email'        => array('type' => 'string', 'length' => 255, 'null' => False),
                         'pwd'          => array('type' => 'string', 'length' => 255, 'null' => False),
                         'avatar'       => array('type' => 'string', 'length' =>  55, 'null' => False),
                         'group_id'     => array('type' => 'integer', 'null' => False),
                         'active'       => array('type' => 'integer', 'default' => '0', 'null' => False)
                        );

    public $records = array(
               array('id'      => 1,
                     'username'=> 'aarkerio',
                     'name'    => 'Max de la Vega',
                     'email'   => 'max@htmx.com',
                     'pwd'     => 'xxfds55f',
                     'avatar'  => 'avademo.png',
                     'group_id'=> 1,
                     'active'  => 1
                   ),
               array('id'      => 2,
                     'username'=> 'marjori',
                     'name'    => 'Marjorie Stephensson',
                     'email'   => 'marjo@mexicpo.com',
                     'pwd'     => 'ds444sfsdf',
                     'avatar'  => 'avademo.png',
                     'group_id'=> 2,
                     'active'  => 1
                    ),
     
             array(  'id'      => 3,
                     'username'=> 'mlop90',
                     'name'    => 'Manuela López',
                     'email'   => 'manuela@medas.com',
                     'pwd'     => 'ggfds676df',
                     'avatar'  => 'avademo.png',
                     'group_id'=> 3,
                     'active'  => 1
                   )
               );
}

# ? > EOF