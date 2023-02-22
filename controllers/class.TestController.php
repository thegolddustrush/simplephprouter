<?php

require_once(dirname(__FILE__)."/../logger.php");
require_once(dirname(__FILE__)."/class.Controller.php");
require_once(dirname(__FILE__)."/../class.SessionManager.php");

class TestController extends Controller{

  function Test($vars){
	  global $logger;
	  return "{'test':'test'}";
  }
  function TestPost($vars){
	  global $logger;
	  return "{'test':'test'}";
  }
  function View($vars){
	global $logger;
	return array("test"=>"test");
  }

}
