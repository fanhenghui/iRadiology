<?php

//Include Common Files @1-7F6FC012
define("RelativePath", "..");
define("PathToCurrentPage", "/doctors/");
define("FileName", "index.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-B81C91C1
include_once(RelativePath . "/includes/header_doctors.php");
//End Include Page implementation

class clsGridstatus_result_occupation { //status_result_occupation class @14-A95A0D4E

//Variables @14-A8316D69

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
    public $Sorter_status;
    public $Sorter_appointment_time;
    public $Sorter_surname;
    public $Sorter_other_names;
    public $Sorter_age;
    public $Sorter_sex;
    public $Sorter_occupation;
//End Variables

//Class_Initialize Event @14-6F20660E
    function clsGridstatus_result_occupation($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "status_result_occupation";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid status_result_occupation";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsstatus_result_occupationDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("status_result_occupationOrder", "");
        $this->SorterDirection = CCGetParam("status_result_occupationDir", "");

        $this->status = new clsControl(ccsLabel, "status", "status", ccsText, "", CCGetRequestParam("status", ccsGet, NULL), $this);
        $this->appointment_time = new clsControl(ccsLabel, "appointment_time", "appointment_time", ccsDate, array("h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("appointment_time", ccsGet, NULL), $this);
        $this->surname = new clsControl(ccsLink, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->surname->Page = "../reception/patient_info.php";
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->age = new clsControl(ccsLabel, "age", "age", ccsInteger, "", CCGetRequestParam("age", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->occupation = new clsControl(ccsLabel, "occupation", "occupation", ccsText, "", CCGetRequestParam("occupation", ccsGet, NULL), $this);
        $this->patient_id = new clsControl(ccsLink, "patient_id", "patient_id", ccsInteger, "", CCGetRequestParam("patient_id", ccsGet, NULL), $this);
        $this->patient_id->Page = "write_report.php";
        $this->status_result_occupation_TotalRecords = new clsControl(ccsLabel, "status_result_occupation_TotalRecords", "status_result_occupation_TotalRecords", ccsText, "", CCGetRequestParam("status_result_occupation_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_status = new clsSorter($this->ComponentName, "Sorter_status", $FileName, $this);
        $this->Sorter_appointment_time = new clsSorter($this->ComponentName, "Sorter_appointment_time", $FileName, $this);
        $this->Sorter_surname = new clsSorter($this->ComponentName, "Sorter_surname", $FileName, $this);
        $this->Sorter_other_names = new clsSorter($this->ComponentName, "Sorter_other_names", $FileName, $this);
        $this->Sorter_age = new clsSorter($this->ComponentName, "Sorter_age", $FileName, $this);
        $this->Sorter_sex = new clsSorter($this->ComponentName, "Sorter_sex", $FileName, $this);
        $this->Sorter_occupation = new clsSorter($this->ComponentName, "Sorter_occupation", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @14-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @14-EC123889
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["expr109"] = ccgetuserid();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["status"] = $this->status->Visible;
            $this->ControlsVisible["appointment_time"] = $this->appointment_time->Visible;
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["age"] = $this->age->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["occupation"] = $this->occupation->Visible;
            $this->ControlsVisible["patient_id"] = $this->patient_id->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->status->SetValue($this->DataSource->status->GetValue());
                $this->appointment_time->SetValue($this->DataSource->appointment_time->GetValue());
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->surname->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->surname->Parameters = CCAddParam($this->surname->Parameters, "patient_id", $this->DataSource->f("patient_id"));
                $this->surname->Parameters = CCAddParam($this->surname->Parameters, "result_id", $this->DataSource->f("result_id"));
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->age->SetValue($this->DataSource->age->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->occupation->SetValue($this->DataSource->occupation->GetValue());
                $this->patient_id->SetValue($this->DataSource->patient_id->GetValue());
                $this->patient_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->patient_id->Parameters = CCAddParam($this->patient_id->Parameters, "patient_id", $this->DataSource->f("patient_id"));
                $this->patient_id->Parameters = CCAddParam($this->patient_id->Parameters, "result_id", $this->DataSource->f("result_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->status->Show();
                $this->appointment_time->Show();
                $this->surname->Show();
                $this->other_names->Show();
                $this->age->Show();
                $this->sex->Show();
                $this->occupation->Show();
                $this->patient_id->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->status_result_occupation_TotalRecords->Show();
        $this->Sorter_status->Show();
        $this->Sorter_appointment_time->Show();
        $this->Sorter_surname->Show();
        $this->Sorter_other_names->Show();
        $this->Sorter_age->Show();
        $this->Sorter_sex->Show();
        $this->Sorter_occupation->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @14-A66A780B
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->appointment_time->Errors->ToString());
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->age->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->occupation->Errors->ToString());
        $errors = ComposeStrings($errors, $this->patient_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End status_result_occupation Class @14-FCB6E20C

class clsstatus_result_occupationDataSource extends clsDBConnection1 {  //status_result_occupationDataSource Class @14-5ABD84D6

//DataSource Variables @14-E54CFBC9
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $status;
    public $appointment_time;
    public $surname;
    public $other_names;
    public $age;
    public $sex;
    public $occupation;
    public $patient_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @14-168B9CC5
    function clsstatus_result_occupationDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid status_result_occupation";
        $this->Initialize();
        $this->status = new clsField("status", ccsText, "");
        
        $this->appointment_time = new clsField("appointment_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->occupation = new clsField("occupation", ccsText, "");
        
        $this->patient_id = new clsField("patient_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @14-94618BD2
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "appointment_time";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_status" => array("status", ""), 
            "Sorter_appointment_time" => array("appointment_time", ""), 
            "Sorter_surname" => array("surname", ""), 
            "Sorter_other_names" => array("other_names", ""), 
            "Sorter_age" => array("age", ""), 
            "Sorter_sex" => array("sex", ""), 
            "Sorter_occupation" => array("occupation", "")));
    }
//End SetOrder Method

//Prepare Method @14-A5171FA4
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr109", ccsInteger, "", "", $this->Parameters["expr109"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "result.user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = "( result.appointment_date=current_date )";
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @14-0C27FBA1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) LEFT JOIN occupation ON\n\n" .
        "patient.occupation_id = occupation.occupation_id) RIGHT JOIN (result LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id) ON\n\n" .
        "patient.patient_id = result.patient_id";
        $this->SQL = "SELECT appointment_time, sex, occupation, patient.*, status, result_id \n\n" .
        "FROM ((patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) LEFT JOIN occupation ON\n\n" .
        "patient.occupation_id = occupation.occupation_id) RIGHT JOIN (result LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id) ON\n\n" .
        "patient.patient_id = result.patient_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @14-139D2EDB
    function SetValues()
    {
        $this->status->SetDBValue($this->f("status"));
        $this->appointment_time->SetDBValue(trim($this->f("appointment_time")));
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->age->SetDBValue(trim($this->f("age")));
        $this->sex->SetDBValue($this->f("sex"));
        $this->occupation->SetDBValue($this->f("occupation"));
        $this->patient_id->SetDBValue(trim($this->f("patient_id")));
    }
//End SetValues Method

} //End status_result_occupationDataSource Class @14-FCB6E20C

//Initialize Page @1-14E8D77F
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
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-2299D106
CCSecurityRedirect("2;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-B7D86394
include_once("./index_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-E1C7A606
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_doctors = new clsheader_doctors("../includes/", "header_doctors", $MainPage);
$header_doctors->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$Label3 = new clsControl(ccsLabel, "Label3", "Label3", ccsText, "", CCGetRequestParam("Label3", ccsGet, NULL), $MainPage);
$status_result_occupation = new clsGridstatus_result_occupation("", $MainPage);
$nop5 = new clsControl(ccsLabel, "nop5", "nop5", ccsInteger, "", CCGetRequestParam("nop5", ccsGet, NULL), $MainPage);
$nop1 = new clsControl(ccsLabel, "nop1", "nop1", ccsInteger, "", CCGetRequestParam("nop1", ccsGet, NULL), $MainPage);
$nop2 = new clsControl(ccsLabel, "nop2", "nop2", ccsInteger, "", CCGetRequestParam("nop2", ccsGet, NULL), $MainPage);
$nop3 = new clsControl(ccsLabel, "nop3", "nop3", ccsInteger, "", CCGetRequestParam("nop3", ccsGet, NULL), $MainPage);
$nop4 = new clsControl(ccsLabel, "nop4", "nop4", ccsInteger, "", CCGetRequestParam("nop4", ccsGet, NULL), $MainPage);
$MainPage->footer = & $footer;
$MainPage->header_doctors = & $header_doctors;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->Label3 = & $Label3;
$MainPage->status_result_occupation = & $status_result_occupation;
$MainPage->nop5 = & $nop5;
$MainPage->nop1 = & $nop1;
$MainPage->nop2 = & $nop2;
$MainPage->nop3 = & $nop3;
$MainPage->nop4 = & $nop4;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());
$status_result_occupation->Initialize();

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

//Execute Components @1-1B2D90BC
$header_doctors->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-1F7E247F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_doctors->Class_Terminate();
    unset($header_doctors);
    unset($status_result_occupation);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B671ECF9
$footer->Show();
$header_doctors->Show();
$status_result_occupation->Show();
$Label1->Show();
$Label2->Show();
$Label3->Show();
$nop5->Show();
$nop1->Show();
$nop2->Show();
$nop3->Show();
$nop4->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-765091D5
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
$header_doctors->Class_Terminate();
unset($header_doctors);
unset($status_result_occupation);
unset($Tpl);
//End Unload Page
?>
