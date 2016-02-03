<?php

//Include Common Files @1-0F3E6646
define("RelativePath", "..");
define("PathToCurrentPage", "/reception/");
define("FileName", "setup.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-1E9AE950
include_once(RelativePath . "/includes/header_receptionist_setup.php");
//End Include Page implementation

//Include Page implementation @5-1405FA7C
include_once(RelativePath . "/setup/occupation.php");
//End Include Page implementation

//Include Page implementation @11-7B1B6F6C
include_once(RelativePath . "/setup/sub_dept.php");
//End Include Page implementation

//Include Page implementation @12-736F12D7
include_once(RelativePath . "/setup/ward_clinic.php");
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

//Authenticate User @1-8791BA6A
CCSecurityRedirect("1;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-1AA75BE0
include_once("./setup_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C7DA706B
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_receptionist_setup = new clsheader_receptionist_setup("../includes/", "header_receptionist_setup", $MainPage);
$header_receptionist_setup->Initialize();
$occupation = new clsoccupation("../setup/", "occupation", $MainPage);
$occupation->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$sub_dept = new clssub_dept("../setup/", "sub_dept", $MainPage);
$sub_dept->Initialize();
$ward_clinic = new clsward_clinic("../setup/", "ward_clinic", $MainPage);
$ward_clinic->Initialize();
$MainPage->footer = & $footer;
$MainPage->header_receptionist_setup = & $header_receptionist_setup;
$MainPage->occupation = & $occupation;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->sub_dept = & $sub_dept;
$MainPage->ward_clinic = & $ward_clinic;
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

//Execute Components @1-1FD31C27
$ward_clinic->Operations();
$sub_dept->Operations();
$occupation->Operations();
$header_receptionist_setup->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-0BD45ED1
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_receptionist_setup->Class_Terminate();
    unset($header_receptionist_setup);
    $occupation->Class_Terminate();
    unset($occupation);
    $sub_dept->Class_Terminate();
    unset($sub_dept);
    $ward_clinic->Class_Terminate();
    unset($ward_clinic);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-AE8B46C8
$footer->Show();
$header_receptionist_setup->Show();
$occupation->Show();
$sub_dept->Show();
$ward_clinic->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9C48CA5C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$footer->Class_Terminate();
unset($footer);
$header_receptionist_setup->Class_Terminate();
unset($header_receptionist_setup);
$occupation->Class_Terminate();
unset($occupation);
$sub_dept->Class_Terminate();
unset($sub_dept);
$ward_clinic->Class_Terminate();
unset($ward_clinic);
unset($Tpl);
//End Unload Page
?>
