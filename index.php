<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
#if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
#    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    #header('HTTP/1.1 301 Moved Permanently');
#    header('Location: ' . $location);
#    exit;
#}
define("ROOTDIR","/var/www/html/testrouter");
require_once("class.SessionManager.php");
require_once("logger.php");
require_once(ROOTDIR."/sys/class.ControllerLoader.php");

$sess = new SessionManager();
$isAuthenticated = $sess->IsAuthenticatedNoHalt();

$url = $_SERVER['REQUEST_URI'];
$urlParts = explode("?",$url);
$queryString = array();

//process logout
if (count($urlParts) == 2 && $urlParts[1]=="logout"){
  $sess->DestroySession();
  header("Location: ".WEBROOT."login");
}else if (count($urlParts) == 2){ // get the query string
  $queryStringParts = explode("&",$urlParts[1]);
  foreach ($queryStringParts as $queryStringPart){
    $varParts = explode("=",$queryStringPart);
    
    if (count($varParts)==2){
      $queryString[$varParts[0]]=$varParts[1];
      #print_r($queryString);
    }
  }
}




//the router for routes requiring authentication
$router = array( 
	"/testrouter/test"=>array("url"=>"","title"=>"test","controller"=>"TestController","action"=>"Test","actionpost"=>"TestPost","json"=>"1"),
);

// the router for routes requiring no authentication
$routerNotLoggedIn = array( 
	"/testrouter/test"=>array("url"=>"","title"=>"test","controller"=>"TestController","action"=>"Test","actionpost"=>"TestPost","json"=>"1"),
	"/testrouter/view"=>array("url"=>"","title"=>"test","controller"=>"TestController","action"=>"View","actionpost"=>""),



);




$toInclude = ROOTDIR."/shared/error.php";
$title = "";
$controllerName="";
$actionResult="";
$controllerLoader = null;
$layout = ROOTDIR."/shared/layout.php";


if ($isAuthenticated){ //only route if logged in

if (count($urlParts)>0 && array_key_exists($urlParts[0],$router)){
  $controllerLoader = new ControllerLoader($router[$urlParts[0]]);
  $toInclude = ROOTDIR.$router[$urlParts[0]]["url"];
  $title = $router[$urlParts[0]]["title"];
  if (array_key_exists("controller",$router[$urlParts[0]])){ //is for controller?

    $controllerName = $router[$urlParts[0]]["controller"];
    // load the controller
    $newController = new $controllerName();
    if (array_key_exists("action",$router[$urlParts[0]])){ // is action specified?
      $toInclude="";
      $actionName = $router[$urlParts[0]]["action"];
      $data= $newController->$actionName();
    }
    
  }
}else{


}

}else{ // not authenticated
#echo $urlParts[0];
  $controllerLoader = new ControllerLoader($routerNotLoggedIn[$urlParts[0]]);  
  if ($controllerLoader->IsControllerAction() && !$controllerLoader->IsJsonAction()){
    $data = $controllerLoader->ExecuteAction($queryString,$_POST);
    $toInclude = $controllerLoader->GetViewPath();
  }
  else if ($controllerLoader->IsJsonAction()){
    $data = $controllerLoader->ExecuteAction($queryString,$_POST);
    $toInclude="";
    $layout="";
    echo $data;
  }
  else{
    $toInclude =  ROOTDIR."/shared/not_authorized.php";
  }


}

if ($layout != ""){
  include($layout);  
}


?>
