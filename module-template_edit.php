<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - Edit ]----------------------------------------------- *|
\* -------------------------------------------------------------------------- */
$checkPermission="module-template_edit";
include("template.inc.php");
function content(){
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress']);
 // build address form
 $address_form=new str_form("submit.php?act=address_save&idAddress=".$address->id,"post","address_edit");
 $address_form->addField("text","firstname",api_text("module-template_edit-ff-firstname"),$address->firstname,"input-medium",api_text("module-template_edit-ff-firstname-placeholder"));
 $address_form->addField("text","lastname",api_text("module-template_edit-ff-lastname"),$address->lastname,"input-medium",api_text("module-template_edit-ff-lastname-placeholder"));
 $address_form->addField("radio","sex",api_text("module-template_edit-ff-sex"),NULL,"inline");
  $address_form->addFieldOption("U",api_text("module-template_edit-fo-sex-undefined"),(!$address->id||"U"==$address->sex?TRUE:FALSE));
  $address_form->addFieldOption("M",api_text("module-template_edit-fo-sex-male"),("M"==$address->sex?TRUE:FALSE));
  $address_form->addFieldOption("F",api_text("module-template_edit-fo-sex-female"),("F"==$address->sex?TRUE:FALSE));
 $address_form->addField("date","birthday",api_text("module-template_edit-ff-birthday"),$address->birthday,"input-small");
 // controls
 $address_form->addControl("submit",api_text("module-template_edit-fc-submit"));
 if($address->id){$address_form->addControl("button",api_text("module-template_edit-fc-cancel"),NULL,"module-template_view.php?idAddress=".$address->id);}
 else{$address_form->addControl("button",api_text("module-template_edit-fc-cancel"),NULL,"module-template_list.php");}
 // show address form
 $address_form->render();
 // debug
 if($_SESSION["account"]->debug){pre_var_dump($address,"print","address");}
?>
<script type="text/javascript">
 $(document).ready(function(){
  // validation
  $("form[name='address_edit']").validate({
   rules:{
    firstname:{required:true,minlength:3},
    lastname:{required:true,minlength:3}
   },
   submitHandler:function(form){form.submit();}
  });
 });
</script>
<?php } ?>