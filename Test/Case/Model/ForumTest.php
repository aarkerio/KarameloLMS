<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/ForumTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Forum', 'Model');

class ForumTestCase extends CakeTestCase {
 
 public $fixtures = array('app.forum', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Forum = ClassRegistry::init('Forum');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Forum');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeForums() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');
   $result  = $this->Forum->threeForums();
   $expected = array(
                     array('Forum' => array(
                                      'id'      => 1,
                                      'quote'   => 'Forum Forum Forum ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Forum' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Forum' => array(
                                      'id'      => 3,
                                      'quote'   => 'Forum 333 Forum 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Forum');
 }
}

# ? > EOF
