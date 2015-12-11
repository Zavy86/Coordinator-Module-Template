<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - View ]----------------------------------------------- *|
\* -------------------------------------------------------------------------- */
$checkPermission="address_view";
include("template.inc.php");
function content(){
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress']);
 if(!$address->id){echo api_text("addressNotFound");return FALSE;}
 // build address dynamic list
 $address_dl=new str_dl("br","dl-horizontal");
 $address_dl->addElement(api_text("module-template_view-dt-name"),$address->name);
 $address_dl->addElement(api_text("module-template_view-dt-sex"),$address->sexText);
 $address_dl->addElement(api_text("module-template_view-dt-birthday"),api_timestampFormat($address->birthday,api_text("date")));
 // show address dynamic list
 $address_dl->render();
 // debug
 if($_SESSION["account"]->debug){pre_var_dump($address,"print","address");}
}
?>