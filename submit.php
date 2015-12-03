<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - Submit ]--------------------------------------------- *|
\* -------------------------------------------------------------------------- */
// include core api functions
include("../core/api.inc.php");
// load module api and language
api_loadModule();
// get action
$act=$_GET['act'];
// switch actions
switch($act){
 // address
 case "address_save":address_save();break;
 case "address_delete":address_delete();break;
 // default
 default:
  $alert="?alert=submitFunctionNotFound&alert_class=alert-warning&act=".$act;
  header("location: index.php".$alert);
}


/**
 * Address Save
 */
function address_save(){
 // check address edit permission
 if(!api_checkPermission("module-template","address_edit")){api_die("accessDenied");}
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress']);
 // acquire variables
 $p_firstname=addslashes($_POST['firstname']);
 $p_lastname=addslashes($_POST['lastname']);
 $p_sex=$_POST['sex'];
 $p_birthday=$_POST['birthday'];
 // build request query
 if($address->id){
  $query="UPDATE `module-template_addresses` SET
   `firstname`='".$p_firstname."',
   `lastname`='".$p_lastname."',
   `sex`='".$p_sex."',
   `birthday`='".$p_birthday."',
   `updDate`='".api_now()."',
   `updIdAccount`='".api_account()->id."'
   WHERE `id`='".$address->id."'";
  // execute query
  $GLOBALS['db']->execute($query);
  // log event
  $log=api_log(API_LOG_NOTICE,"module-template","addressUpdated",
   "{logs_module-template_addressUpdated|".$p_firstname."|".$p_lastname."}",
   $address->id,"module-template/module-template_view.php?idAddress=".$address->id);
  // alert
  $alert="&alert=addressUpdated&alert_class=alert-success&idLog=".$log->id;
 }else{
  $query="INSERT INTO `module-template_addresses`
   (`firstname`,`lastname`,`sex`,`birthday`,`addDate`,`addIdAccount`) VALUES
   ('".$p_firstname."','".$p_lastname."','".$p_sex."','".$p_birthday."',
    '".api_now()."','".api_account()->id."')";
  // execute query
  $GLOBALS['db']->execute($query);
  // build from last inserted id
  $address=api_moduleTemplate_address($GLOBALS['db']->lastInsertedId());
  // log event
  $log=api_log(API_LOG_NOTICE,"module-template","addressCreated",
   "{logs_module-template_addressCreated|".$p_firstname."|".$p_lastname."}",
   $address->id,"casting-reassignments/requests_view.php?idRequest=".$address->id);
  // alert
  $alert="&alert=addressCreated&alert_class=alert-success&idLog=".$log->id;
 }
 // redirect
 exit(header("location: module-template_view.php?idAddress=".$address->id.$alert));
}

?>