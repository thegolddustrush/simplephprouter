<?php
    ini_set('session.gc_maxlifetime', 604800);

session_start();
define("ROOTDOMAIN","localhost");
if (trim(getenv('HTTP_HOST')) != ROOTDOMAIN){
  $urlpath = "";
  if (isset($_SERVER['REQUEST_URI'])){
    $urlpath = $_SERVER['REQUEST_URI'];
  }

  header ("Location: http://".ROOTDOMAIN.$urlpath);
//echo "Location: http://".ROOTDOMAIN.$urlpath;
}

define("SESSUSERNAME","user_name");
define("SESSPROFILEID","profile_id");
define("SESSEMAILCODE","email_code");
define("SESSISINSTRUCTOR","is_instructor");


class SessionManager{
 

  //equivalent of logging in  
  function CreateSession($user_name,$profile_id){  

    //session_destroy();
    $_SESSION[SESSUSERNAME] = $user_name;        
    $_SESSION[SESSPROFILEID] = $profile_id;        
    //RbRecordLogin($user_name,$profile_id);


    //$profile = GetProfile($profile_id);
   // if ($profile){
   //   $_SESSION['SESSUSEEMAILAUTHENTICATION'] = $profile->UseEmailAuthentication;
   // }  
  }

  function DestroySession(){
    session_destroy();
  }

  function IsAuthenticated(){
    if (! isset($_SESSION[SESSUSERNAME]) || ! isset($_SESSION[SESSPROFILEID])){
      echo "unauthorized";
      exit;
    }else{
      //RbRecordPageLog($_SESSION[SESSPROFILEID]);
    }
  }
  function IsAuthenticatedNoHalt(){
    if (! isset($_SESSION[SESSUSERNAME]) || ! isset($_SESSION[SESSPROFILEID])){
      //echo "unauthorized";
      return false;
    }else{
      //RbRecordPageLog($_SESSION[SESSPROFILEID]);
      return true;
    }
  }


  function GetProfileId(){
    if (!isset($_SESSION[SESSPROFILEID])) return false;
    return $_SESSION[SESSPROFILEID];
  }

  function GetUserName(){
    if (!isset($_SESSION[SESSUSERNAME])) return false;
    return $_SESSION[SESSUSERNAME];
  }

  function IsSuperUser(){
     if (isset($_SESSION[SESSPROFILEID]) && $_SESSION[SESSPROFILEID] == 1) {
       return true;
      }else{
      return false;
    }

  }

}

?>
