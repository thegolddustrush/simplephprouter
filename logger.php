<?php

define("LOGFILE","/var/www/html/testrouter/log.txt");
define("DEBUGLVL","DEBUG");




class Logger{

  var $file;

  function openLog(){
    $this->file = fopen(LOGFILE,"a");
  }
  
  function closeLog(){
    fclose($this->file);
    
  }
   
  function writeToLog($msg){
  
    $clientip = $_SERVER['REMOTE_ADDR'];
    $d = date("Y-m-d H:i:s");
    $this->openLog();
    $msg = $d . " IP: " . $clientip . " " . $msg . "\n";
    fwrite($this->file,  $msg);
    $this->closeLog();    
  } 

  function debug( $msg){
    if (DEBUGLVL !=   "DEBUG"){
      return;    
    }
    
    $msg = "DEBUG:" . $msg;  
    $this->writeToLog($msg);  
    
  }
  
  
  function info( $msg){
    if (DEBUGLVL == "NONE"){
      return;
    }
    $msg = "INFO:" . $msg;  
    $this->writeToLog($msg);  
  }
  
  function error($msg){
    if (DEBUGLVL == "NONE"){
      return; 
    }

    $msg = "ERROR:" . $msg;
    $this->writeToLog($msg);  

  }
  
  function warn($msg){
    if (DEBUGLVL == "NONE" || DEBUGLVL == "INFO"){
      return; 
    }

    $msg = "WARN:" . $msg;
    $this->writeToLog($msg);  
  }
}


$logger = new Logger();


?>
