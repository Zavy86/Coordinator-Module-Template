<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - Template ]------------------------------------------- *|
\* -------------------------------------------------------------------------- */
// include module information file
include("module.inc.php");
// include core api functions
include("../core/api.inc.php");
// load module api and language
api_loadModule();
// print header
$html->header(api_text("module-title"),$module_name);
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress']);
// build navigation menu
global $navigation;
$navigation=new str_navigation((api_baseName()=="module-template_list.php"?TRUE:FALSE));
// filters
if(api_baseName()=="module-template_list.php"){
 // sex
 $navigation->addFilter("multiselect","sex",api_text("filter-sex"),array("U"=>api_text("filter-undefined"),"M"=>api_text("filter-male"),"F"=>api_text("filter-female")));
 // if not filtered load default filters
 if($_GET['resetFilters']||($_GET['filtered']<>1 && $_SESSION['filters'][api_baseModule()][api_baseName()]['filtered']<>1)){
  //include("filters.inc.php");
 }
}
// list
$navigation->addTab(api_text("module-template-nav-list"),"module-template_list.php");
if(api_baseName()=="module-template_list.php"){
 $navigation->addSubTab(api_text("module-template-nav-export"),"module-template_export.php?q=".$_GET['q'],NULL,NULL,TRUE,"_blank");
}

// operations
if($address->id){
 $navigation->addTab(api_text("module-template-nav-operations"),NULL,NULL,"active");
 $navigation->addSubTab(api_text("module-template-nav-edit"),"module-template_edit.php?idAddress=".$address->id,NULL,NULL,(api_checkPermission($module_name,"address_edit")?TRUE:FALSE));
 $navigation->addSubTab(api_text("module-template-nav-delete"),"submit.php?act=address_delete&idAddress=".$address->id,NULL,NULL,(api_checkPermission($module_name,"address_del")?TRUE:FALSE),"_self",api_text("module-template-nav-delete-confirm"));
 $navigation->addSubTab(api_text("module-template-nav-export"),"module-template_export.php?idAddress=".$address->id);
 $navigation->addSubTab(api_text("module-template-nav-sendmail"),"module-template_sendmail.php?idAddress=".$address->id);
}else{
 // add new, with check permission
 $navigation->addTab(api_text("module-template-nav-add"),"module-template_edit.php",NULL,NULL,(api_checkPermission($module_name,"edit")?TRUE:FALSE));
}
// show navigation menu
$navigation->render();
// check permissions before displaying module
if($checkPermission==NULL){content();}else{if(api_checkPermission($module_name,$checkPermission,TRUE)){content();}}
// print footer
$html->footer();
?>