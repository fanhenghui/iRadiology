<?php

//Include Common Files @1-8C46DBD2
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "setup.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-074E1FC9
include_once(RelativePath . "/includes/header_admin_setup.php");
//End Include Page implementation

//Include Page implementation @10-197FCD04
include_once(RelativePath . "/setup/department.php");
//End Include Page implementation

//Include Page implementation @11-736F12D7
include_once(RelativePath . "/setup/ward_clinic.php");
//End Include Page implementation

//Include Page implementation @12-7B1B6F6C
include_once(RelativePath . "/setup/sub_dept.php");
//End Include Page implementation

//Include Page implementation @13-58B44708
include_once(RelativePath . "/setup/title.php");
//End Include Page implementation

//Include Page implementation @14-1405FA7C
include_once(RelativePath . "/setup/occupation.php");
//End Include Page implementation

//Include Page implementation @15-4F04CCC6
include_once(RelativePath . "/setup/statistical_conclusion.php");
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

//Include events file @1-1AA75BE0
include_once("./setup_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-003D70F1
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_admin_setup = new clsheader_admin_setup("../includes/", "header_admin_setup", $MainPage);
$header_admin_setup->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$department = new clsdepartment("../setup/", "department", $MainPage);
$department->Initialize();
$ward_clinic = new clsward_clinic("../setup/", "ward_clinic", $MainPage);
$ward_clinic->Initialize();
$sub_dept = new clssub_dept("../setup/", "sub_dept", $MainPage);
$sub_dept->Initialize();
$title = new clstitle("../setup/", "title", $MainPage);
$title->Initialize();
$occupation = new clsoccupation("../setup/", "occupation", $MainPage);
$occupation->Initialize();
$statistical_conclusion = new clsstatistical_conclusion("../setup/", "statistical_conclusion", $MainPage);
$statistical_conclusion->Initialize();
$MainPage->footer = & $footer;
$MainPage->header_admin_setup = & $header_admin_setup;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->department = & $department;
$MainPage->ward_clinic = & $ward_clinic;
$MainPage->sub_dept = & $sub_dept;
$MainPage->title = & $title;
$MainPage->occupation = & $occupation;
$MainPage->statistical_conclusion = & $statistical_conclusion;
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

//Execute Components @1-9285CE95
$statistical_conclusion->Operations();
$occupation->Operations();
$title->Operations();
$sub_dept->Operations();
$ward_clinic->Operations();
$department->Operations();
$header_admin_setup->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-D965EDAB
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_admin_setup->Class_Terminate();
    unset($header_admin_setup);
    $department->Class_Terminate();
    unset($department);
    $ward_clinic->Class_Terminate();
    unset($ward_clinic);
    $sub_dept->Class_Terminate();
    unset($sub_dept);
    $title->Class_Terminate();
    unset($title);
    $occupation->Class_Terminate();
    unset($occupation);
    $statistical_conclusion->Class_Terminate();
    unset($statistical_conclusion);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-3A192FEC
$footer->Show();
$header_admin_setup->Show();
$department->Show();
$ward_clinic->Show();
$sub_dept->Show();
$title->Show();
$occupation->Show();
$statistical_conclusion->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6935081B
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$footer->Class_Terminate();
unset($footer);
$header_admin_setup->Class_Terminate();
unset($header_admin_setup);
$department->Class_Terminate();
unset($department);
$ward_clinic->Class_Terminate();
unset($ward_clinic);
$sub_dept->Class_Terminate();
unset($sub_dept);
$title->Class_Terminate();
unset($title);
$occupation->Class_Terminate();
unset($occupation);
$statistical_conclusion->Class_Terminate();
unset($statistical_conclusion);
unset($Tpl);
//End Unload Page
?>
