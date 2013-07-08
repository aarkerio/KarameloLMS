<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/EcourseTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Ecourse', 'Model');

class EcourseTestCase extends CakeTestCase {
 
    public $fixtures = array('app.faq', 'app.user', 'app.ecourse');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Ecourse = ClassRegistry::init('Ecourse');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Ecourse');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeEcourses() 
 {
   $this->markTestIncomplete('This is incomplete, I know!!');

   $result  = $this->Ecourse->threeEcourses();
   $expected = array(
                     array('Ecourse' => array(
                                      'id'      => 1,
                                      'quote'   => 'Ecourse Ecourse Ecourse ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Ecourse' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Ecourse' => array(
                                      'id'      => 3,
                                      'quote'   => 'Ecourse 333 Ecourse 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Ecourse');
 }
}

# ? > EOF
