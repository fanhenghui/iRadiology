<?php

//Include Common Files @1-1F2F1996
define("RelativePath", "..");
define("PathToCurrentPage", "/typist/");
define("FileName", "index.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/Services.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-5E6D5002
include_once(RelativePath . "/includes/header_typist.php");
//End Include Page implementation

class clsGridsex_department_patient_re { //sex_department_patient_re class @11-B4070DE9

//Variables @11-6E51DF5A

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

//Class_Initialize Event @11-7B7903CC
    function clsGridsex_department_patient_re($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "sex_department_patient_re";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid sex_department_patient_re";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clssex_department_patient_reDataSource($this);
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

        $this->result_id = new clsControl(ccsLabel, "result_id", "result_id", ccsInteger, "", CCGetRequestParam("result_id", ccsGet, NULL), $this);
        $this->surname = new clsControl(ccsLabel, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->age = new clsControl(ccsLabel, "age", "age", ccsInteger, "", CCGetRequestParam("age", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->hospital_no = new clsControl(ccsLabel, "hospital_no", "hospital_no", ccsText, "", CCGetRequestParam("hospital_no", ccsGet, NULL), $this);
        $this->department = new clsControl(ccsLabel, "department", "department", ccsText, "", CCGetRequestParam("department", ccsGet, NULL), $this);
        $this->patient_patient_id = new clsControl(ccsLabel, "patient_patient_id", "patient_patient_id", ccsInteger, "", CCGetRequestParam("patient_patient_id", ccsGet, NULL), $this);
        $this->status = new clsControl(ccsLabel, "status", "status", ccsText, "", CCGetRequestParam("status", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "index.php";
    }
//End Class_Initialize Event

//Initialize Method @11-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @11-3D734AA7
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_surname"] = CCGetFromGet("s_surname", NULL);
        $this->DataSource->Parameters["urls_other_names"] = CCGetFromGet("s_other_names", NULL);
        $this->DataSource->Parameters["urls_hospital_no"] = CCGetFromGet("s_hospital_no", NULL);
        $this->DataSource->Parameters["urls_patient_id"] = CCGetFromGet("s_patient_id", NULL);
        $this->DataSource->Parameters["urls_result_id"] = CCGetFromGet("s_result_id", NULL);

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
            $this->ControlsVisible["result_id"] = $this->result_id->Visible;
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["age"] = $this->age->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["hospital_no"] = $this->hospital_no->Visible;
            $this->ControlsVisible["department"] = $this->department->Visible;
            $this->ControlsVisible["patient_patient_id"] = $this->patient_patient_id->Visible;
            $this->ControlsVisible["status"] = $this->status->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->result_id->SetValue($this->DataSource->result_id->GetValue());
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->age->SetValue($this->DataSource->age->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->hospital_no->SetValue($this->DataSource->hospital_no->GetValue());
                $this->department->SetValue($this->DataSource->department->GetValue());
                $this->patient_patient_id->SetValue($this->DataSource->patient_patient_id->GetValue());
                $this->status->SetValue($this->DataSource->status->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "result_id", $this->DataSource->f("result_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->result_id->Show();
                $this->surname->Show();
                $this->other_names->Show();
                $this->age->Show();
                $this->sex->Show();
                $this->hospital_no->Show();
                $this->department->Show();
                $this->patient_patient_id->Show();
                $this->status->Show();
                $this->Link1->Show();
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

//GetErrors Method @11-8CD0DEBA
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->result_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->age->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->hospital_no->Errors->ToString());
        $errors = ComposeStrings($errors, $this->department->Errors->ToString());
        $errors = ComposeStrings($errors, $this->patient_patient_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End sex_department_patient_re Class @11-FCB6E20C

class clssex_department_patient_reDataSource extends clsDBConnection1 {  //sex_department_patient_reDataSource Class @11-C824BD36

//DataSource Variables @11-73945EF9
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $result_id;
    public $surname;
    public $other_names;
    public $age;
    public $sex;
    public $hospital_no;
    public $department;
    public $patient_patient_id;
    public $status;
//End DataSource Variables

//DataSourceClass_Initialize Event @11-94D6BE82
    function clssex_department_patient_reDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid sex_department_patient_re";
        $this->Initialize();
        $this->result_id = new clsField("result_id", ccsInteger, "");
        
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->hospital_no = new clsField("hospital_no", ccsText, "");
        
        $this->department = new clsField("department", ccsText, "");
        
        $this->patient_patient_id = new clsField("patient_patient_id", ccsInteger, "");
        
        $this->status = new clsField("status", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @11-E6814099
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @11-BC7788C8
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_surname", ccsText, "", "", $this->Parameters["urls_surname"], "", false);
        $this->wp->AddParameter("2", "urls_other_names", ccsText, "", "", $this->Parameters["urls_other_names"], "", false);
        $this->wp->AddParameter("3", "urls_hospital_no", ccsText, "", "", $this->Parameters["urls_hospital_no"], "", false);
        $this->wp->AddParameter("4", "urls_patient_id", ccsInteger, "", "", $this->Parameters["urls_patient_id"], "", false);
        $this->wp->AddParameter("5", "urls_result_id", ccsInteger, "", "", $this->Parameters["urls_result_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "patient.surname", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "patient.other_names", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "patient.hospital_no", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "result.patient_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "result.result_id", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]);
    }
//End Prepare Method

//Open Method @11-1800A2B6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((result INNER JOIN (patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) ON\n\n" .
        "result.patient_id = patient.patient_id) LEFT JOIN department ON\n\n" .
        "result.department_id = department.department_id) LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id";
        $this->SQL = "SELECT result.*, department, sex, patient.patient_id, surname, other_names, age, hospital_no, status \n\n" .
        "FROM ((result INNER JOIN (patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) ON\n\n" .
        "result.patient_id = patient.patient_id) LEFT JOIN department ON\n\n" .
        "result.department_id = department.department_id) LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @11-6D8A7578
    function SetValues()
    {
        $this->result_id->SetDBValue(trim($this->f("result_id")));
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->age->SetDBValue(trim($this->f("age")));
        $this->sex->SetDBValue($this->f("sex"));
        $this->hospital_no->SetDBValue($this->f("hospital_no"));
        $this->department->SetDBValue($this->f("department"));
        $this->patient_patient_id->SetDBValue(trim($this->f("patient_id")));
        $this->status->SetDBValue($this->f("status"));
    }
//End SetValues Method

} //End sex_department_patient_reDataSource Class @11-FCB6E20C

class clsRecordsex_department_patient_re1 { //sex_department_patient_re1 Class @44-4BC00583

//Variables @44-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @44-51D795AB
    function clsRecordsex_department_patient_re1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record sex_department_patient_re1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "sex_department_patient_re1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_surname = new clsControl(ccsTextBox, "s_surname", "Surname", ccsText, "", CCGetRequestParam("s_surname", $Method, NULL), $this);
            $this->s_other_names = new clsControl(ccsTextBox, "s_other_names", "Other Names", ccsText, "", CCGetRequestParam("s_other_names", $Method, NULL), $this);
            $this->s_hospital_no = new clsControl(ccsTextBox, "s_hospital_no", "Hospital No", ccsText, "", CCGetRequestParam("s_hospital_no", $Method, NULL), $this);
            $this->s_patient_id = new clsControl(ccsTextBox, "s_patient_id", "Patient Id", ccsInteger, "", CCGetRequestParam("s_patient_id", $Method, NULL), $this);
            $this->s_result_id = new clsControl(ccsTextBox, "s_result_id", "Result Id", ccsInteger, "", CCGetRequestParam("s_result_id", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @44-30806684
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_surname->Validate() && $Validation);
        $Validation = ($this->s_other_names->Validate() && $Validation);
        $Validation = ($this->s_hospital_no->Validate() && $Validation);
        $Validation = ($this->s_patient_id->Validate() && $Validation);
        $Validation = ($this->s_result_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_surname->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_other_names->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_hospital_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_patient_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_result_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @44-B5EFB805
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_surname->Errors->Count());
        $errors = ($errors || $this->s_other_names->Errors->Count());
        $errors = ($errors || $this->s_hospital_no->Errors->Count());
        $errors = ($errors || $this->s_patient_id->Errors->Count());
        $errors = ($errors || $this->s_result_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @44-670B96B7
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "index.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "index.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @44-BB063C9B
    function Show()
    {
        global $CCSUseAmp;
        $Tpl = & CCGetTemplate($this);
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_surname->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_other_names->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_hospital_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_patient_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_result_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_surname->Show();
        $this->s_other_names->Show();
        $this->s_hospital_no->Show();
        $this->s_patient_id->Show();
        $this->s_result_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End sex_department_patient_re1 Class @44-FCB6E20C

class clsRecordresult { //result Class @51-3AFEA74E

//Variables @51-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @51-9C7FC4EE
    function clsRecordresult($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record result/Error";
        $this->DataSource = new clsresultDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "result";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->result1 = new clsControl(ccsTextArea, "result1", "Result", ccsText, "", CCGetRequestParam("result1", $Method, NULL), $this);
            $this->conclusion = new clsControl(ccsTextArea, "conclusion", "Conclusion", ccsText, "", CCGetRequestParam("conclusion", $Method, NULL), $this);
            $this->statistical_conclusion_id = new clsControl(ccsListBox, "statistical_conclusion_id", "Statistical Conclusion Id", ccsInteger, "", CCGetRequestParam("statistical_conclusion_id", $Method, NULL), $this);
            $this->statistical_conclusion_id->DSType = dsTable;
            $this->statistical_conclusion_id->DataSource = new clsDBConnection1();
            $this->statistical_conclusion_id->ds = & $this->statistical_conclusion_id->DataSource;
            $this->statistical_conclusion_id->DataSource->SQL = "SELECT * \n" .
"FROM statistical_conclusion {SQL_Where} {SQL_OrderBy}";
            list($this->statistical_conclusion_id->BoundColumn, $this->statistical_conclusion_id->TextColumn, $this->statistical_conclusion_id->DBFormat) = array("statistical_conclusion_id", "statistical_conclusion", "");
            $this->patName = new clsControl(ccsLabel, "patName", "patName", ccsText, "", CCGetRequestParam("patName", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @51-576B2713
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlresult_id"] = CCGetFromGet("result_id", NULL);
    }
//End Initialize Method

//Validate Method @51-C60C269E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->result1->Validate() && $Validation);
        $Validation = ($this->conclusion->Validate() && $Validation);
        $Validation = ($this->statistical_conclusion_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->result1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->conclusion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->statistical_conclusion_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @51-7EED2599
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->result1->Errors->Count());
        $errors = ($errors || $this->conclusion->Errors->Count());
        $errors = ($errors || $this->statistical_conclusion_id->Errors->Count());
        $errors = ($errors || $this->patName->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @51-517B5C36
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateRow Method @51-6E9BCD0C
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->result1->SetValue($this->result1->GetValue(true));
        $this->DataSource->conclusion->SetValue($this->conclusion->GetValue(true));
        $this->DataSource->statistical_conclusion_id->SetValue($this->statistical_conclusion_id->GetValue(true));
        $this->DataSource->patName->SetValue($this->patName->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @51-D7983250
    function Show()
    {
        global $CCSUseAmp;
        $Tpl = & CCGetTemplate($this);
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->statistical_conclusion_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->result1->SetValue($this->DataSource->result1->GetValue());
                    $this->conclusion->SetValue($this->DataSource->conclusion->GetValue());
                    $this->statistical_conclusion_id->SetValue($this->DataSource->statistical_conclusion_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->result1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->conclusion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->statistical_conclusion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->patName->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->result1->Show();
        $this->conclusion->Show();
        $this->statistical_conclusion_id->Show();
        $this->patName->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End result Class @51-FCB6E20C

class clsresultDataSource extends clsDBConnection1 {  //resultDataSource Class @51-E277B187

//DataSource Variables @51-4CBA308A
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $result1;
    public $conclusion;
    public $statistical_conclusion_id;
    public $patName;
//End DataSource Variables

//DataSourceClass_Initialize Event @51-FE2112E8
    function clsresultDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record result/Error";
        $this->Initialize();
        $this->result1 = new clsField("result1", ccsText, "");
        
        $this->conclusion = new clsField("conclusion", ccsText, "");
        
        $this->statistical_conclusion_id = new clsField("statistical_conclusion_id", ccsInteger, "");
        
        $this->patName = new clsField("patName", ccsText, "");
        

        $this->UpdateFields["result"] = array("Name" => "result", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["conclusion"] = array("Name" => "conclusion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["statistical_conclusion_id"] = array("Name" => "statistical_conclusion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @51-7EA7128F
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlresult_id", ccsInteger, "", "", $this->Parameters["urlresult_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "result_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @51-47A5D8E4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, result_id \n\n" .
        "FROM result {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @51-082AC305
    function SetValues()
    {
        $this->result1->SetDBValue($this->f("result"));
        $this->conclusion->SetDBValue($this->f("conclusion"));
        $this->statistical_conclusion_id->SetDBValue(trim($this->f("statistical_conclusion_id")));
    }
//End SetValues Method

//Update Method @51-00A57262
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["result"]["Value"] = $this->result1->GetDBValue(true);
        $this->UpdateFields["conclusion"]["Value"] = $this->conclusion->GetDBValue(true);
        $this->UpdateFields["statistical_conclusion_id"]["Value"] = $this->statistical_conclusion_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("result", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End resultDataSource Class @51-FCB6E20C

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

//Authenticate User @1-419E0822
CCSecurityRedirect("3;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-B7D86394
include_once("./index_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-FAA80588
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_typist = new clsheader_typist("../includes/", "header_typist", $MainPage);
$header_typist->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$sex_department_patient_re = new clsGridsex_department_patient_re("", $MainPage);
$sex_department_patient_re1 = new clsRecordsex_department_patient_re1("", $MainPage);
$result = new clsRecordresult("", $MainPage);
$MainPage->footer = & $footer;
$MainPage->header_typist = & $header_typist;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->sex_department_patient_re = & $sex_department_patient_re;
$MainPage->sex_department_patient_re1 = & $sex_department_patient_re1;
$MainPage->result = & $result;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUsername());
$sex_department_patient_re->Initialize();
$result->Initialize();

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

//Execute Components @1-EE79238E
$result->Operation();
$sex_department_patient_re1->Operation();
$header_typist->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-B504013C
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_typist->Class_Terminate();
    unset($header_typist);
    unset($sex_department_patient_re);
    unset($sex_department_patient_re1);
    unset($result);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B950D7A8
$footer->Show();
$header_typist->Show();
$sex_department_patient_re->Show();
$sex_department_patient_re1->Show();
$result->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-749F6236
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
$header_typist->Class_Terminate();
unset($header_typist);
unset($sex_department_patient_re);
unset($sex_department_patient_re1);
unset($result);
unset($Tpl);
//End Unload Page
?>
