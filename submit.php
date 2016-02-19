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
 case "address_sendmail":address_sendmail();break;
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

/**
 * Address Delete
 */
function address_delete(){
 // check address edit permission
 if(!api_checkPermission("module-template","address_del")){api_die("accessDenied");}
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress']);
 if(!$address->id){exit(header("location: module-template_view.php?alert=addressNotFound&alert_class=alert-error"));}
 // execute queries
 $GLOBALS['db']->execute("DELETE FROM `module-template_addresses` WHERE `id`='".$address->id."'");
 // log event
  $log=api_log(API_LOG_WARNING,"module-template","addressDeleted",
   "{logs_module-template_addressDeleted|".$address->firstname."|".$address->lastname."}",
   $address->id);
 // redirect
 $alert="?alert=addressDeleted&alert_class=alert-warning&idLog=".$log->id;
 exit(header("location: module-template_view.php".$alert));
}

/**
 * Address Sendmail
 */
function address_sendmail(){
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress'],TRUE);
 if(!$address->id){exit(header("location:module-template_view.php?alert=addressNotFound&alert_class=alert-error"));}
 // acquire variables
 $p_receivers=api_cleanString(strtolower($_POST['receivers']),"/[^A-Za-z0-9._@;]/");
 // check and convert
 $v_receivers_array=array_filter(explode(";",$p_receivers));
 // make mail content
 $mail_content=api_text("submit_address_sendmail-message");
 $mail_content.="\n\n".api_text("submit_address_sendmail-name",$address->name);
 $mail_content.="\n\n".api_text("submit_address_sendmail-sex",$address->sexText);
 $mail_content.="\n\n".api_text("submit_address_sendmail-birthday",$address->birthday);
 // cycle receivers
 foreach($v_receivers_array as $receiver){
  api_mailer($receiver,$mail_content,api_text("submit_address_sendmail-subject",$address->name),TRUE,api_getOption("owner_mail"),api_getOption("owner_mail_from"),NULL,NULL,NULL);
 }
 // log event
 $log=api_log(API_LOG_NOTICE,"module-template","addressSendmail",
  "{logs_module-template_addressSendmail|".$address->name."|".implode(", ",$v_receivers_array)."}",
  $address->id,"module-template/module-template_view.php?idAddress=".$address->id);
 // redirect
 $alert="&alert=addressSendmail&alert_class=alert-success&idLog=".$log->id;
 exit(header("location:module-template_view.php?idAddress=".$address->id.$alert));
}
?>