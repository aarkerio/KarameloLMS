<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/RecoverTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Recover', 'Model');

class RecoverTestCase extends CakeTestCase {
 
 public $fixtures = array('app.quote', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Recover = ClassRegistry::init('Recover');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Recover');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeRecovers() 
 {
   $result  = $this->Recover->threeRecovers();
   $expected = array(
                     array('Recover' => array(
                                      'id'      => 1,
                                      'quote'   => 'Recover Recover Recover ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Recover' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Recover' => array(
                                      'id'      => 3,
                                      'quote'   => 'Recover 333 Recover 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Recover');
 }
}

# ? > EOF
