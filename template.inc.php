<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - Template ]------------------------------------------- *|
\* -------------------------------------------------------------------------- */
$module="module-template";
// include core api functions
include("../core/api.inc.php");
// if exist include module api functions
if(file_exists("api.inc.php")){include("api.inc.php");}
// print header
$html->header(api_text("module-template-title"),$module);
// build navigation tab
$nt_array=array();
$nt_array[]=api_navigationTab(api_text("module-template-list"),"module-template_list.php");
$nt_array[]=api_navigationTab(api_text("module-template-edit"),"module-template_edit.php");
// print navigation tab
api_navigation($nt_array);
// check permissions before displaying module
if($checkPermission==NULL){content();}else{if(api_checkPermission($module,$checkPermission,TRUE)){content();}}
// print footer
$html->footer();
?>