<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/LessonTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Lesson', 'Model');

class LessonTestCase extends CakeTestCase {
 
 public $fixtures = array('app.quote', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Lesson = ClassRegistry::init('Lesson');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Lesson');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeLessons() 
 {
   $result  = $this->Lesson->threeLessons();
   $expected = array(
                     array('Lesson' => array(
                                      'id'      => 1,
                                      'quote'   => 'Lesson Lesson Lesson ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Lesson' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Lesson' => array(
                                      'id'      => 3,
                                      'quote'   => 'Lesson 333 Lesson 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Lesson');
 }
}

# ? > EOF
