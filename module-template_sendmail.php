<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-template - Studies Sendmail ]--------------------------------- *|
\* -------------------------------------------------------------------------- */
$checkPermission="address_view";
include("template.inc.php");
function content(){
 // get objects
 $address=api_moduleTemplate_address($_GET['idAddress']);
 if(!$address->id){echo api_text("addressNotFound");return FALSE;}
 // build form
 $form=new str_form("submit.php?act=address_sendmail&idAddress=".$address->id,"post","address_sendmail");
 // receivers
 $form->addField("text","receivers",api_text("module-template_sendmail-receivers"),NULL,"input-xxlarge",api_text("module-template_sendmail-receivers-placeholder"));
 // controls
 $form->addControl("submit",api_text("module-template_sendmail-submit"));
 $form->addControl("button",api_text("module-template_sendmail-cancel"),NULL,"module-template_view.php?idAddress=".$address->id);
 // show import form
 $form->render();
 // debug
 if($_SESSION["account"]->debug){pre_var_dump($address,"print","study");}
?>
<script type="text/javascript">
 $(document).ready(function(){
  // validation
  $("form[name='address_sendmail']").validate({
   rules:{
    receivers:{required:true}
   },
   submitHandler:function(form){form.submit();}
  });
 });
</script>
<?php } ?>