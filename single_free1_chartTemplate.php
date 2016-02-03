<?php
//Include Common Files @1-23F03631
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "single_free1_chartTemplate.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-F99F725C
include_once(RelativePath . "/includes/header.php");
//End Include Page implementation

//Initialize Page @1-56C1539E
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
$TemplateFileName = "single_free1_chartTemplate.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-B4A35E50
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("includes/", "footer", $MainPage);
$footer->Initialize();
$header = new clsheader("includes/", "header", $MainPage);
$header->Initialize();
$m1 = new clsControl(ccsLabel, "m1", "m1", ccsText, "", CCGetRequestParam("m1", ccsGet, NULL), $MainPage);
$m2 = new clsControl(ccsLabel, "m2", "m2", ccsText, "", CCGetRequestParam("m2", ccsGet, NULL), $MainPage);
$m3 = new clsControl(ccsLabel, "m3", "m3", ccsText, "", CCGetRequestParam("m3", ccsGet, NULL), $MainPage);
$m4 = new clsControl(ccsLabel, "m4", "m4", ccsText, "", CCGetRequestParam("m4", ccsGet, NULL), $MainPage);
$m5 = new clsControl(ccsLabel, "m5", "m5", ccsText, "", CCGetRequestParam("m5", ccsGet, NULL), $MainPage);
$f1 = new clsControl(ccsLabel, "f1", "f1", ccsText, "", CCGetRequestParam("f1", ccsGet, NULL), $MainPage);
$f2 = new clsControl(ccsLabel, "f2", "f2", ccsText, "", CCGetRequestParam("f2", ccsGet, NULL), $MainPage);
$f3 = new clsControl(ccsLabel, "f3", "f3", ccsText, "", CCGetRequestParam("f3", ccsGet, NULL), $MainPage);
$f4 = new clsControl(ccsLabel, "f4", "f4", ccsText, "", CCGetRequestParam("f4", ccsGet, NULL), $MainPage);
$f5 = new clsControl(ccsLabel, "f5", "f5", ccsText, "", CCGetRequestParam("f5", ccsGet, NULL), $MainPage);
$av1 = new clsControl(ccsLabel, "av1", "av1", ccsText, "", CCGetRequestParam("av1", ccsGet, NULL), $MainPage);
$av2 = new clsControl(ccsLabel, "av2", "av2", ccsText, "", CCGetRequestParam("av2", ccsGet, NULL), $MainPage);
$av3 = new clsControl(ccsLabel, "av3", "av3", ccsText, "", CCGetRequestParam("av3", ccsGet, NULL), $MainPage);
$av4 = new clsControl(ccsLabel, "av4", "av4", ccsText, "", CCGetRequestParam("av4", ccsGet, NULL), $MainPage);
$av5 = new clsControl(ccsLabel, "av5", "av5", ccsText, "", CCGetRequestParam("av5", ccsGet, NULL), $MainPage);
$MainPage->footer = & $footer;
$MainPage->header = & $header;
$MainPage->m1 = & $m1;
$MainPage->m2 = & $m2;
$MainPage->m3 = & $m3;
$MainPage->m4 = & $m4;
$MainPage->m5 = & $m5;
$MainPage->f1 = & $f1;
$MainPage->f2 = & $f2;
$MainPage->f3 = & $f3;
$MainPage->f4 = & $f4;
$MainPage->f5 = & $f5;
$MainPage->av1 = & $av1;
$MainPage->av2 = & $av2;
$MainPage->av3 = & $av3;
$MainPage->av4 = & $av4;
$MainPage->av5 = & $av5;
if(!is_array($m1->Value) && !strlen($m1->Value) && $m1->Value !== false)
    $m1->SetText(2);
if(!is_array($m2->Value) && !strlen($m2->Value) && $m2->Value !== false)
    $m2->SetText(3);
if(!is_array($m3->Value) && !strlen($m3->Value) && $m3->Value !== false)
    $m3->SetText(2);
if(!is_array($m4->Value) && !strlen($m4->Value) && $m4->Value !== false)
    $m4->SetText(2);
if(!is_array($m5->Value) && !strlen($m5->Value) && $m5->Value !== false)
    $m5->SetText(1);

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-28F2FDD6
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
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-2D944FA9
$header->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-EC93EDF6
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header->Class_Terminate();
    unset($header);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-F7534324
$footer->Show();
$header->Show();
$m1->Show();
$m2->Show();
$m3->Show();
$m4->Show();
$m5->Show();
$f1->Show();
$f2->Show();
$f3->Show();
$f4->Show();
$f5->Show();
$av1->Show();
$av2->Show();
$av3->Show();
$av4->Show();
$av5->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6B39B15C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$footer->Class_Terminate();
unset($footer);
$header->Class_Terminate();
unset($header);
unset($Tpl);
//End Unload Page


?>
