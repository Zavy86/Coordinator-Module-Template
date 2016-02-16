<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-template - Export List ]---------------------------------------- *|
\* -------------------------------------------------------------------------- */
require_once("../core/api.inc.php");
api_loadModule();
// include the TCPDF library
require_once('../core/tcpdf/tcpdf.php');
// definitions
// acquire variables
$g_search=$_GET['q'];
// build navigation filters
global $navigation;
$navigation=new str_navigation();
// sex
$navigation->addFilter("multiselect","sex",api_text("filter-sex"),array("M"=>api_text("filter-male"),"F"=>api_text("filter-female"),"U"=>api_text("filter-undefined")));
// load session filters if exist
if(isset($_SESSION['filters']["module-template_list.php"])){$_GET=array_merge($_SESSION['filters']["module-template_list.php"],$_GET);}
// if not filtered load default filters
if($_GET['resetFilters']||($_GET['filtered']<>1 && $_SESSION['filters']["module-template_list.php"]['filtered']<>1)){
 //include("filters.inc.php");
}
// extend the TCPDF class to create custom header and footer
class MYPDF extends TCPDF {
 // header
 public function Header(){
  $company=api_company();  // <<<----- eventualmente per il multi-società sostituire con società emittente
  $name=stripslashes($company->fiscal_name);
  $address=stripslashes($company->address_address)." - ".stripslashes($company->address_zip)." ".stripslashes($company->address_city)." (".stripslashes($company->address_district).") ".stripslashes($company->address_country);
  if($company->phone_office){$contacts="Tel: ".stripslashes($company->phone_office);}
  $fiscalData="P.IVA: ".stripslashes($company->fiscal_vat);
  if($company->fiscal_code){$fiscalData.=" - C.F: ".stripslashes($company->fiscal_code);}
  if($company->fiscal_rea){$fiscalData.=" - R.E.A: ".stripslashes($company->fiscal_rea);}
  // logo
  if(file_exists("../uploads/uploads/core/logo.png")){
   $logo_size=getimagesize("../uploads/uploads/core/logo.png");
   $logo_x=$logo_size[0];
   $logo_y=$logo_size[1];
   $x_padding=round($logo_x*12/$logo_y)+13;
   $this->Image("../uploads/uploads/core/logo.png",10,10,'',12,'PNG',api_getOption('owner_url'),'T',false,300,'',false,false,0,false,false,false);
  }else{
   $x_padding=10;
  }
  // header style
  $this->SetTextColor(0);
  $this->SetFillColor(0,255,0);
  $fill=FALSE;
  $border='';
  // build header
  $this->SetFont('freesans','B',15);
  $this->MultiCell(160,0,$name,$border,'L',false,0,$x_padding,9);
  $this->MultiCell(75,0,"Coordinator",$border,'R',false,0,112,9);
  $this->Image("../core/images/logos/logo.png",188,10,'',12,'PNG',"http://www.coordinator.it",'T',false,300,'',false,false,0,false,false,false);
  $this->SetFont('freesans','',9);
  $this->MultiCell(160,0,$address." - ".$contacts,$border,'L',false,0,$x_padding,15);
  $this->SetFont('freesans','B',9);
  $this->MultiCell(75,0,api_text("module-title"),$border,'R',false,0,112,15);
  $this->SetFont('freesans','',7);
  $this->MultiCell(160,0,$fiscalData,$border,'L',false,0,$x_padding,19);
  $this->MultiCell(75,0,api_text("module-template_export-title"),$border,'R',false,0,112,19);
 }
 // footer
 public function Footer(){
  $this->setY(-12);
  $this->SetFont('freesans','',6,'',true);
  $this->Cell(0,3,mb_strtoupper(api_text("module-template_export-page"),'UTF-8')." ".$this->getAliasNumPage()." ".mb_strtoupper(api_text("module-template_export-pageOf"),'UTF-8')." ".$this->getAliasNbPages(),0,0,'L',0);
  $this->Cell(0,3,mb_strtoupper(api_text("module-template_export-footer",api_timestampFormat(api_now(),api_text("datetime"))),'UTF-8'),0,0,'R',0);
 }
}
// create new pdf document
$pdf=new MYPDF('P','mm','A4',true,'UTF-8',false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(api_account()->name);
$pdf->SetTitle("Module template");
$pdf->SetSubject("Module template Export");
// header and footer
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
// set margins
$pdf->SetMargins(10,28,10);
$pdf->SetHeaderMargin(25);
$pdf->SetFooterMargin(10);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE,14);
// set font and fill
$pdf->SetFont('freesans','',10,'',true);
$pdf->SetTextColor(0);
$pdf->SetFillColor(245);
$fill=FALSE;
// set borders
$border='';
// add a page
$pdf->AddPage();
// build header
$pdf->SetFont('freesans','B',7);
$pdf->Cell(80,5,mb_strtoupper(api_text("module-template_export-nominative"),"UTF-8"),$border,0,"L",$fill);
$pdf->Cell(45,5,mb_strtoupper(api_text("module-template_export-sex"),"UTF-8"),$border,0,"L",$fill);
$pdf->Cell(65,5,mb_strtoupper(api_text("module-template_export-birthday"),"UTF-8"),$border,0,"L",$fill);
$pdf->ln();
// build table
$pdf->SetFont('freesans','',9,'',true);
// get addresses
$addresses=api_moduleTemplate_addresses($g_search);
// cycle all cards
foreach($addresses->results as $address){
 if($fill){$fill=FALSE;}else{$fill=TRUE;}
 // print address
 $pdf->Cell(80,6,$address->lastname." ".$address->firstname,$border,0,"L",$fill,null,1,false);
 $pdf->Cell(45,6,$address->sexText,$border,0,"L",$fill,null,1,false);
 $pdf->Cell(65,6,$address->birthday,$border,0,"L",$fill,null,1,false);
 $pdf->Ln(6);
}
// close and output pdf document
$pdf->Output("module-template_export_".date("YmdHis").".pdf",'I');
?>