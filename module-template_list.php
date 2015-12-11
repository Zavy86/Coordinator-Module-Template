<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - List ]----------------------------------------------- *|
\* -------------------------------------------------------------------------- */
// script permission
$checkPermission="address_view";
// include module template
include("template.inc.php");
// script content
function content(){
 // acquire variables
 $g_search=$_GET['q'];
 // show filters
 echo $GLOBALS['navigation']->filtersText();
 // build table
 $addresses_table=new str_table(api_text("module-template_list-tr-unvalued"),TRUE,$GLOBALS['navigation']->filtersGet());
 $addresses_table->addHeader("&nbsp;",NULL,"16");
 $addresses_table->addHeader(api_text("module-template_list-th-lastname"),"nowarp",NULL,"`module-template_addresses`.`lastname`");
 $addresses_table->addHeader(api_text("module-template_list-th-firstname"),"nowarp",NULL,"`module-template_addresses`.`firstname`");
 $addresses_table->addHeader(api_text("module-template_list-th-address"),NULL,"100%");
 // get addresses
 $addresses=api_moduleTemplate_addresses($g_search,TRUE);
 foreach($addresses->results as $address){
  // check selected
  if($address->id==$_GET['idAddress']){$tr_class="info";}else{$tr_class=NULL;}
  // build address table row
  $addresses_table->addRow($tr_class);
  // build table fields
  $addresses_table->addField(api_link("module-template_view.php?idAddress=".$address->id,api_icon("icon-search",api_text("module-template_list-td-view"))),"nowarp");
  $addresses_table->addField($address->lastname,"nowarp");
  $addresses_table->addField($address->firstname,"nowarp");
  $addresses_table->addField($address->address);
 }
 // show table
 $addresses_table->render();
 // renderize the pagination
 $addresses->pagination->render();
 // debug
 if($_SESSION["account"]->debug){
  pre_var_dump($addresses->query,"print","query");
  pre_var_dump($addresses->results,"print","addresses");
 }
}
?>