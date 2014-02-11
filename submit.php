<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - Submit ]--------------------------------------------- *|
\* -------------------------------------------------------------------------- */
// include core api functions
include("../core/api.inc.php");
// if exist include module api functions
if(file_exists("api.inc.php")){include("api.inc.php");}
// get action
$act=$_GET['act'];
// choise action
switch($act){
 // action-category
 case "action-key":action_function();break;
 // default
 default:
  $alert="?alert=submitFunctionNotFound&alert_class=alert-warning&act=".$act;
  header("location: index.php".$alert);
}
?>