<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/GapTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Gap', 'Model');

class GapTestCase extends CakeTestCase {
 
 public $fixtures = array('app.acquaintance', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Gap = ClassRegistry::init('Gap');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Gap');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeGaps() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');
   $result  = $this->Gap->threeGaps();
   $expected = array(
                     array('Gap' => array(
                                      'id'      => 1,
                                      'quote'   => 'Gap Gap Gap ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Gap' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Gap' => array(
                                      'id'      => 3,
                                      'quote'   => 'Gap 333 Gap 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Gap');
 }
}

# ? > EOF
