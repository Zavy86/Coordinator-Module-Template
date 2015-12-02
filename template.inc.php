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
// build navigation menu
global $navigation;
$navigation=new str_navigation((api_baseName()=="module-template_list.php"?TRUE:FALSE));
// list
$navigation->addTab(api_text("module-template-nav-list"),"module-template_list.php");
// add new, with check permission
$navigation->addTab(api_text("module-template-nav-add"),"module-template_edit.php",NULL,NULL,(api_checkPermission($module_name,"edit")?TRUE:FALSE));

// filters
if(api_baseName()=="module-template_list.php"){
 // sex
 $navigation->addFilter("multiselect","sex",api_text("filter-sex"),array("U"=>api_text("filter-undefined"),"M"=>api_text("filter-male"),"F"=>api_text("filter-female")));
 // if not filtered load default filters
 if($_GET['resetFilters']||($_GET['filtered']<>1 && $_SESSION['filters'][api_baseName()]['filtered']<>1)){
  //include("filters.inc.php");
 }
}

// show navigation menu
$navigation->render();

// check permissions before displaying module
if($checkPermission==NULL){content();}else{if(api_checkPermission($module_name,$checkPermission,TRUE)){content();}}
// print footer
$html->footer();
?>