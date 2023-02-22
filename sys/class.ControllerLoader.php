<?php

require_once(dirname(__FILE__)."/../logger.php");

$dir = new DirectoryIterator(ROOTDIR."/controllers");

foreach ($dir as $fileinfo) { // load all the controllers
    if (!$fileinfo->isDot()) {
        //var_dump($fileinfo->getFilename());
        include(ROOTDIR."/controllers/".$fileinfo->getFilename());
    }
}


class ControllerLoader{

  var $controllerAction;
  var $view="";
  var $isPost = false;

  public function __construct($controllerAction) {
    $this->controllerAction = $controllerAction;
    if (!empty($_POST)){
      $this->isPost = true;
    }
  }


  public function IsControllerAction(){
    return $this->GetAction() != null && $this->GetController() !=null;
  }

  public function IsJsonAction(){
    if (!is_null($this->controllerAction) && array_key_exists("json",$this->controllerAction)) // is action specified?
      return $this->controllerAction["json"];
    else 
      return null;

  }

  public function IsPost(){
    return $this->isPost;
  }

  public function GetAction(){
    if (!is_null($this->controllerAction) && array_key_exists("action",$this->controllerAction)){ // is action specified?
      return $this->controllerAction["action"];
      
    }else{
      return null;
    }
  }
  public function GetPostAction(){
    if (array_key_exists("actionpost",$this->controllerAction)){ // is action specified?
      return $this->controllerAction["actionpost"];
      
    }else{
      return null;
    }
  }

  public function GetController(){
    if (array_key_exists("controller",$this->controllerAction)){ // is controller specified?
      return $this->controllerAction["controller"];
      
    }else{
      return null;
    }
  }

  public function GetViewFolder(){
    if (array_key_exists("controller",$this->controllerAction)){ // is controller specified?
      return str_replace("controller","",strtolower($this->controllerAction["controller"]));      
    }else{
      return null;
    }
  }

  public function GetViewPath(){
    if ($this->view != "" && $this->view != NULL){
       return ROOTDIR."/views/".$this->GetViewFolder()."/".$this->view.".php";
    }
    else if (array_key_exists("controller",$this->controllerAction)){ // is controller specified?
      return ROOTDIR."/views/".$this->GetViewFolder()."/".strtolower($this->GetAction()).".php";
    }else{
      return null;
    }
  }

  public function ExecuteAction($vars,$postVars){
    global $logger;
    if (!$this->isPost)
      $action = $this->GetAction();
    else
      $action = $this->GetPostAction();

    $controller = $this->GetController();
    $logger->debug("ControllerLoader...ExecuteAction...executing action $action from controller $controller");
    $logger->debug("ControllerLoader...ExecuteAction...is post = ".$this->isPost);
    if ($action && $controller){
      $newController = new $controller();
      if (!$this->isPost)
        $actionResult = $newController->$action($vars);
      else
        $actionResult = $newController->$action($postVars);
      if (is_array($actionResult)&&array_key_exists("view",$actionResult)){
        $this->view = $actionResult["view"];
      }
      return $actionResult;
    }
  }

}

?>
