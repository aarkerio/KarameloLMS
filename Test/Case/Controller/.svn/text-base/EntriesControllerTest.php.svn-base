<?php
/**
 *   Chipotle Software(c) 2012   GPLv3
 *   File: APP/Test/Case/Controller/QuoteControllerTest.php
 */

App::uses('QuotesController', 'Controller');
App::uses('Quote', 'Model');
App::uses('Controller', 'Controller');
App::uses('Model', 'Model');
App::uses('View', 'View');
App::uses('AclComponent', 'Controller/Component');


class EntriesControllerTest extends ControllerTestCase {

 public function testPushAndPop()
 {
   $stack = array();
   $this->assertEquals(0, count($stack));
 
   array_push($stack, 'foo');
   $this->assertEquals('foo', $stack[count($stack)-1]);
   $this->assertEquals(1, count($stack));
 
   $this->assertEquals('foo', array_pop($stack));
   $this->assertEquals(0, count($stack));
  }

  public function testIndex() 
  {
    $result = $this->testAction('/entries/display/aarkerio');
    debug($result);
  }

  public function testIndexShort() 
  {
    $result = $this->testAction('/entries/display/aarkerio/short');
    debug($result);
  }

  public function testIndexShortGetRenderedHtml() 
  {
   $result = $this->testAction(
                               '/entries/lastEntries/short',
                                array('return' => 'render')
                                );
    debug($result);
  }

  public function testIndexShortGetViewVars() 
  {
    $result = $this->testAction(
                                    '/entries/lastEntries/short',
                                    array('return' => 'vars')
                                    );
    debug($result);
  }

  public function testIndexPostData() 
  {
    $data = array(
                  'Entry' => array(
                                   'user_id'   => 1,
                                   'published' => 1,
                                   'slug'      => 'new-article',
                                   'title'     => 'New entry',
                                   'body'      => 'New Body'
                                         )
                      );
    $result = $this->testAction(
                                    '/entries/lastEntries',
                                    array('data' => $data, 'method' => 'post')
                                    );
    debug($result);
   }
 }

# ? > EOF
