<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/TreasureTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Treasure', 'Model');

class TreasureTestCase extends CakeTestCase {
 
 public $fixtures = array('app.acquaintance', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Treasure = ClassRegistry::init('Treasure');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Treasure');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeTreasures() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');
   $result  = $this->Treasure->threeTreasures();
   $expected = array(
                     array('Treasure' => array(
                                      'id'      => 1,
                                      'quote'   => 'Treasure Treasure Treasure ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Treasure' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Treasure' => array(
                                      'id'      => 3,
                                      'quote'   => 'Treasure 333 Treasure 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Treasure');
 }
}

# ? > EOF
