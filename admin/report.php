<?php

//Include Common Files @1-8B6CFECE
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "report.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-EF3FD848
include_once(RelativePath . "/includes/header_admin_report.php");
//End Include Page implementation

//Initialize Page @1-0B56EE73
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
$TemplateFileName = "report.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-0D352854
CCSecurityRedirect("4", "../access_denied.php");
//End Authenticate User

//Include events file @1-3225B425
include_once("./report_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E2CED383
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_admin_report = new clsheader_admin_report("../includes/", "header_admin_report", $MainPage);
$header_admin_report->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$MainPage->footer = & $footer;
$MainPage->header_admin_report = & $header_admin_report;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
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

//Execute Components @1-26BF1397
$header_admin_report->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-B1FA0744
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_admin_report->Class_Terminate();
    unset($header_admin_report);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BDE3D23F
$footer->Show();
$header_admin_report->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-7864127A
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$footer->Class_Terminate();
unset($footer);
$header_admin_report->Class_Terminate();
unset($header_admin_report);
unset($Tpl);
//End Unload Page
?>
