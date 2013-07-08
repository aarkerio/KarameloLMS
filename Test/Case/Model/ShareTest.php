<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/ShareTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Share', 'Model');

class ShareTestCase extends CakeTestCase {
 
 public $fixtures = array('app.share', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Share = ClassRegistry::init('Share');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Share');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeShares() 
 {
   $this->markTestIncomplete('This is incomplete, I know!!');

   $result  = $this->Share->threeShares();
   $expected = array(
                     array('Share' => array(
                                      'id'      => 1,
                                      'quote'   => 'Share Share Share ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Share' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Share' => array(
                                      'id'      => 3,
                                      'quote'   => 'Share 333 Share 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Share');
 }
}

# ? > EOF
