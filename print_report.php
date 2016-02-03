<?php

//Include Common Files @1-F8D333AA
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "print_report.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A6DCBE64
include_once(RelativePath . "/includes/header_print_report.php");
//End Include Page implementation

class clsGridtitle_users_sub_dept_sex { //title_users_sub_dept_sex class @3-203B2483

//Variables @3-6E51DF5A

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
//End Variables

//Class_Initialize Event @3-ABD8912C
    function clsGridtitle_users_sub_dept_sex($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "title_users_sub_dept_sex";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid title_users_sub_dept_sex";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstitle_users_sub_dept_sexDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->surname = new clsControl(ccsLabel, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->age = new clsControl(ccsLabel, "age", "age", ccsInteger, "", CCGetRequestParam("age", ccsGet, NULL), $this);
        $this->hospital_no = new clsControl(ccsLabel, "hospital_no", "hospital_no", ccsText, "", CCGetRequestParam("hospital_no", ccsGet, NULL), $this);
        $this->conclusion = new clsControl(ccsLabel, "conclusion", "conclusion", ccsText, "", CCGetRequestParam("conclusion", ccsGet, NULL), $this);
        $this->conclusion->HTML = true;
        $this->first_name = new clsControl(ccsLabel, "first_name", "first_name", ccsText, "", CCGetRequestParam("first_name", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->clinic = new clsControl(ccsLabel, "clinic", "clinic", ccsText, "", CCGetRequestParam("clinic", ccsGet, NULL), $this);
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet, NULL), $this);
        $this->last_name = new clsControl(ccsLabel, "last_name", "last_name", ccsText, "", CCGetRequestParam("last_name", ccsGet, NULL), $this);
        $this->sub_dept = new clsControl(ccsLabel, "sub_dept", "sub_dept", ccsText, "", CCGetRequestParam("sub_dept", ccsGet, NULL), $this);
        $this->todaysDate = new clsControl(ccsLabel, "todaysDate", "todaysDate", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("todaysDate", ccsGet, NULL), $this);
        $this->result = new clsControl(ccsLabel, "result", "result", ccsText, "", CCGetRequestParam("result", ccsGet, NULL), $this);
        $this->result->HTML = true;
    }
//End Class_Initialize Event

//Initialize Method @3-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @3-8DC2CDB9
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlresult_id"] = CCGetFromGet("result_id", NULL);

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
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["age"] = $this->age->Visible;
            $this->ControlsVisible["hospital_no"] = $this->hospital_no->Visible;
            $this->ControlsVisible["conclusion"] = $this->conclusion->Visible;
            $this->ControlsVisible["first_name"] = $this->first_name->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["clinic"] = $this->clinic->Visible;
            $this->ControlsVisible["title"] = $this->title->Visible;
            $this->ControlsVisible["last_name"] = $this->last_name->Visible;
            $this->ControlsVisible["sub_dept"] = $this->sub_dept->Visible;
            $this->ControlsVisible["todaysDate"] = $this->todaysDate->Visible;
            $this->ControlsVisible["result"] = $this->result->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                if(!is_array($this->todaysDate->Value) && !strlen($this->todaysDate->Value) && $this->todaysDate->Value !== false)
                    $this->todaysDate->SetValue(time());
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->age->SetValue($this->DataSource->age->GetValue());
                $this->hospital_no->SetValue($this->DataSource->hospital_no->GetValue());
                $this->conclusion->SetValue($this->DataSource->conclusion->GetValue());
                $this->first_name->SetValue($this->DataSource->first_name->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->clinic->SetValue($this->DataSource->clinic->GetValue());
                $this->title->SetValue($this->DataSource->title->GetValue());
                $this->last_name->SetValue($this->DataSource->last_name->GetValue());
                $this->sub_dept->SetValue($this->DataSource->sub_dept->GetValue());
                $this->result->SetValue($this->DataSource->result->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->surname->Show();
                $this->other_names->Show();
                $this->age->Show();
                $this->hospital_no->Show();
                $this->conclusion->Show();
                $this->first_name->Show();
                $this->sex->Show();
                $this->clinic->Show();
                $this->title->Show();
                $this->last_name->Show();
                $this->sub_dept->Show();
                $this->todaysDate->Show();
                $this->result->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-ED5826BD
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->age->Errors->ToString());
        $errors = ComposeStrings($errors, $this->hospital_no->Errors->ToString());
        $errors = ComposeStrings($errors, $this->conclusion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->first_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->clinic->Errors->ToString());
        $errors = ComposeStrings($errors, $this->title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->last_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sub_dept->Errors->ToString());
        $errors = ComposeStrings($errors, $this->todaysDate->Errors->ToString());
        $errors = ComposeStrings($errors, $this->result->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End title_users_sub_dept_sex Class @3-FCB6E20C

class clstitle_users_sub_dept_sexDataSource extends clsDBConnection1 {  //title_users_sub_dept_sexDataSource Class @3-69D9E76A

//DataSource Variables @3-77168D36
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $surname;
    public $other_names;
    public $age;
    public $hospital_no;
    public $conclusion;
    public $first_name;
    public $sex;
    public $clinic;
    public $title;
    public $last_name;
    public $sub_dept;
    public $result;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-A0370ACA
    function clstitle_users_sub_dept_sexDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid title_users_sub_dept_sex";
        $this->Initialize();
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->hospital_no = new clsField("hospital_no", ccsText, "");
        
        $this->conclusion = new clsField("conclusion", ccsText, "");
        
        $this->first_name = new clsField("first_name", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->clinic = new clsField("clinic", ccsText, "");
        
        $this->title = new clsField("title", ccsText, "");
        
        $this->last_name = new clsField("last_name", ccsText, "");
        
        $this->sub_dept = new clsField("sub_dept", ccsText, "");
        
        $this->result = new clsField("result", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-535311AB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlresult_id", ccsInteger, "", "", $this->Parameters["urlresult_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "result_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-ADEC7EC5
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM sub_dept INNER JOIN ((patient INNER JOIN ((result LEFT JOIN (users LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "result.user_id = users.user_id) LEFT JOIN clinic ON\n\n" .
        "result.clinic_id = clinic.clinic_id) ON\n\n" .
        "patient.patient_id = result.patient_id) LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) ON\n\n" .
        "sub_dept.sub_dept_id = result.sup_dept_id";
        $this->SQL = "SELECT surname, other_names, age, sex, hospital_no, sub_dept, conclusion, result, title, first_name, last_name, clinic \n\n" .
        "FROM sub_dept INNER JOIN ((patient INNER JOIN ((result LEFT JOIN (users LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "result.user_id = users.user_id) LEFT JOIN clinic ON\n\n" .
        "result.clinic_id = clinic.clinic_id) ON\n\n" .
        "patient.patient_id = result.patient_id) LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) ON\n\n" .
        "sub_dept.sub_dept_id = result.sup_dept_id {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @3-06B37323
    function SetValues()
    {
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->age->SetDBValue(trim($this->f("age")));
        $this->hospital_no->SetDBValue($this->f("hospital_no"));
        $this->conclusion->SetDBValue($this->f("conclusion"));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->sex->SetDBValue($this->f("sex"));
        $this->clinic->SetDBValue($this->f("clinic"));
        $this->title->SetDBValue($this->f("title"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->sub_dept->SetDBValue($this->f("sub_dept"));
        $this->result->SetDBValue($this->f("result"));
    }
//End SetValues Method

} //End title_users_sub_dept_sexDataSource Class @3-FCB6E20C

//Initialize Page @1-53F14ECF
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
$TemplateFileName = "print_report.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-B9498920
CCSecurityRedirect("1;2;3;4", "access_denied.php");
//End Authenticate User

//Include events file @1-BA7F0A72
include_once("./print_report_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-BEBAAE57
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$header_print_report = new clsheader_print_report("includes/", "header_print_report", $MainPage);
$header_print_report->Initialize();
$title_users_sub_dept_sex = new clsGridtitle_users_sub_dept_sex("", $MainPage);
$patID = new clsControl(ccsLabel, "patID", "patID", ccsText, "", CCGetRequestParam("patID", ccsGet, NULL), $MainPage);
$resultID = new clsControl(ccsLabel, "resultID", "resultID", ccsText, "", CCGetRequestParam("resultID", ccsGet, NULL), $MainPage);
$startDate = new clsControl(ccsLabel, "startDate", "startDate", ccsText, "", CCGetRequestParam("startDate", ccsGet, NULL), $MainPage);
$deptShort = new clsControl(ccsLabel, "deptShort", "deptShort", ccsText, "", CCGetRequestParam("deptShort", ccsGet, NULL), $MainPage);
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$MainPage->header_print_report = & $header_print_report;
$MainPage->title_users_sub_dept_sex = & $title_users_sub_dept_sex;
$MainPage->patID = & $patID;
$MainPage->resultID = & $resultID;
$MainPage->startDate = & $startDate;
$MainPage->deptShort = & $deptShort;
$MainPage->Label1 = & $Label1;
if(!is_array($resultID->Value) && !strlen($resultID->Value) && $resultID->Value !== false)
    $resultID->SetText(ccgetparam('result_id',''));
if(!is_array($Label1->Value) && !strlen($Label1->Value) && $Label1->Value !== false)
    $Label1->SetText(getUsername());
$title_users_sub_dept_sex->Initialize();

BindEvents();

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

//Execute Components @1-0037A4DF
$header_print_report->Operations();
//End Execute Components

//Go to destination page @1-8AFCC774
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $header_print_report->Class_Terminate();
    unset($header_print_report);
    unset($title_users_sub_dept_sex);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-651C8111
$header_print_report->Show();
$title_users_sub_dept_sex->Show();
$patID->Show();
$resultID->Show();
$startDate->Show();
$deptShort->Show();
$Label1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-1BF1F63E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$header_print_report->Class_Terminate();
unset($header_print_report);
unset($title_users_sub_dept_sex);
unset($Tpl);
//End Unload Page
?>
