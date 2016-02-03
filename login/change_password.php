<?php

//Include Common Files @1-48BA78DA
define("RelativePath", "..");
define("PathToCurrentPage", "/login/");
define("FileName", "change_password.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-342F66FA
include_once(RelativePath . "/includes/header_changepwd.php");
//End Include Page implementation

//Include Page implementation @5-0CFCC162
include_once(RelativePath . "/setup/change_password.php");
//End Include Page implementation

//Initialize Page @1-2643FD3D
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
$TemplateFileName = "change_password.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-2417A23F
CCSecurityRedirect("1;2;3;4", "../access_denied.php");
//End Authenticate User

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-84E19849
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_changepwd = new clsheader_changepwd("../includes/", "header_changepwd", $MainPage);
$header_changepwd->Initialize();
$change_password1 = new clschange_password("../setup/", "change_password1", $MainPage);
$change_password1->Initialize();
$MainPage->footer = & $footer;
$MainPage->header_changepwd = & $header_changepwd;
$MainPage->change_password1 = & $change_password1;

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

//Execute Components @1-B4C43746
$change_password1->Operations();
$header_changepwd->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-A783A8B2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_changepwd->Class_Terminate();
    unset($header_changepwd);
    $change_password1->Class_Terminate();
    unset($change_password1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-BDEA4F0A
$footer->Show();
$header_changepwd->Show();
$change_password1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-259B7640
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$footer->Class_Terminate();
unset($footer);
$header_changepwd->Class_Terminate();
unset($header_changepwd);
$change_password1->Class_Terminate();
unset($change_password1);
unset($Tpl);
//End Unload Page
?>
