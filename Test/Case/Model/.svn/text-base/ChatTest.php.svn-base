<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/ChatTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Chat', 'Model');

class ChatTestCase extends CakeTestCase {
 
 public $fixtures = array('app.chat', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Chat = ClassRegistry::init('Chat');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Chat');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeChats() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');
   $result  = $this->Chat->threeChats();
   $expected = array(
                     array('Chat' => array(
                                      'id'      => 1,
                                      'quote'   => 'Chat Chat Chat ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Chat' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Chat' => array(
                                      'id'      => 3,
                                      'quote'   => 'Chat 333 Chat 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Chat');
 }
}

# ? > EOF
