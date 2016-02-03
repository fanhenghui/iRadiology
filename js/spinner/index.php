<?php

//Include Common Files @1-A0BCA682
define("RelativePath", "../..");
define("PathToCurrentPage", "/js/spinner/");
define("FileName", "index.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @14-CA16F42C
include_once(RelativePath . "/includes/header_outofbound.php");
//End Include Page implementation

//Include Page implementation @15-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Initialize Page @1-9EEE34DE
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
$TemplateFileName = "index.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-13ABDB52
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$header_outofbound = new clsheader_outofbound("../../includes/", "header_outofbound", $MainPage);
$header_outofbound->Initialize();
$footer = new clsfooter("../../includes/", "footer", $MainPage);
$footer->Initialize();
$MainPage->header_outofbound = & $header_outofbound;
$MainPage->footer = & $footer;

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-97C0D71D
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
$Attributes->SetValue("pathToRoot", "../../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-03EC4543
$footer->Operations();
$header_outofbound->Operations();
//End Execute Components

//Go to destination page @1-8CB6BDC2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $header_outofbound->Class_Terminate();
    unset($header_outofbound);
    $footer->Class_Terminate();
    unset($footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-65A57857
$header_outofbound->Show();
$footer->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-1F225DEA
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$header_outofbound->Class_Terminate();
unset($header_outofbound);
$footer->Class_Terminate();
unset($footer);
unset($Tpl);
//End Unload Page
?>
