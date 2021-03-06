<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/WikiTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Wiki', 'Model');

class WikiTestCase extends CakeTestCase {
 
 public $fixtures = array('app.quote', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Wiki = ClassRegistry::init('Wiki');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Wiki');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeWikis() 
 {
   $result  = $this->Wiki->threeWikis();
   $expected = array(
                     array('Wiki' => array(
                                      'id'      => 1,
                                      'quote'   => 'Wiki Wiki Wiki ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Wiki' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Wiki' => array(
                                      'id'      => 3,
                                      'quote'   => 'Wiki 333 Wiki 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Wiki');
 }
}

# ? > EOF
