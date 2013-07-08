<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/AcquaintanceTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Acquaintance', 'Model');

class AcquaintanceTest extends CakeTestCase {
 
 public $fixtures = array('app.acquaintance', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Acquaintance = ClassRegistry::init('Acquaintance');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('app.acquaintance');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeAcquaintances() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');
   $result  = $this->Acquaintance->threeAcquaintances();
   $expected = array(
                     array('Acquaintance' => array(
                                      'id'      => 1,
                                      'quote'   => 'Acquaintance Acquaintance Acquaintance ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Acquaintance' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Acquaintance' => array(
                                      'id'      => 3,
                                      'quote'   => 'Acquaintance 333 Acquaintance 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Acquaintance');
 }
}

# ? > EOF
