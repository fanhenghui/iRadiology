<?php

//Include Common Files @1-B0F006A0
define("RelativePath", "..");
define("PathToCurrentPage", "/doctors/");
define("FileName", "setup.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @13-4F04CCC6
include_once(RelativePath . "/setup/statistical_conclusion.php");
//End Include Page implementation

//Include Page implementation @14-7B1B6F6C
include_once(RelativePath . "/setup/sub_dept.php");
//End Include Page implementation

//Include Page implementation @17-EA76BDBA
include_once(RelativePath . "/includes/header_doctors_setup.php");
//End Include Page implementation

//Initialize Page @1-9160973D
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";
$TemplateSource = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "setup.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-2299D106
CCSecurityRedirect("2;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-1AA75BE0
include_once("./setup_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-6D55D9AA
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$Label3 = new clsControl(ccsLabel, "Label3", "Label3", ccsText, "", CCGetRequestParam("Label3", ccsGet, NULL), $MainPage);
$statistical_conclusion = new clsstatistical_conclusion("../setup/", "statistical_conclusion", $MainPage);
$statistical_conclusion->Initialize();
$sub_dept = new clssub_dept("../setup/", "sub_dept", $MainPage);
$sub_dept->Initialize();
$header_doctors_setup = new clsheader_doctors_setup("../includes/", "header_doctors_setup", $MainPage);
$header_doctors_setup->Initialize();
$MainPage->footer = & $footer;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->Label3 = & $Label3;
$MainPage->statistical_conclusion = & $statistical_conclusion;
$MainPage->sub_dept = & $sub_dept;
$MainPage->header_doctors_setup = & $header_doctors_setup;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-6AE7B07D
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
if (strlen($TemplateSource)) {
    $Tpl->LoadTemplateFromStr($TemplateSource, $BlockToParse, "UTF-8");
} else {
    $Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "UTF-8");
}
$Tpl->SetVar("CCS_PathToRoot", $PathToRoot);
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-8BA0BA74
$header_doctors_setup->Operations();
$sub_dept->Operations();
$statistical_conclusion->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-38F9FC17
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $statistical_conclusion->Class_Terminate();
    unset($statistical_conclusion);
    $sub_dept->Class_Terminate();
    unset($sub_dept);
    $header_doctors_setup->Class_Terminate();
    unset($header_doctors_setup);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-52234089
$footer->Show();
$statistical_conclusion->Show();
$sub_dept->Show();
$header_doctors_setup->Show();
$Label1->Show();
$Label2->Show();
$Label3->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-94C5AD96
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$footer->Class_Terminate();
unset($footer);
$statistical_conclusion->Class_Terminate();
unset($statistical_conclusion);
$sub_dept->Class_Terminate();
unset($sub_dept);
$header_doctors_setup->Class_Terminate();
unset($header_doctors_setup);
unset($Tpl);
//End Unload Page
?>
