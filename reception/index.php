<?php

//Include Common Files @1-DA3C55E0
define("RelativePath", "..");
define("PathToCurrentPage", "/reception/");
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

//Include Page implementation @8-222E468A
include_once(RelativePath . "/includes/header_receptionist.php");
//End Include Page implementation

class clsGridsex_occupation_patient { //sex_occupation_patient class @11-FA61DB91

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

//Class_Initialize Event @11-3436E837
    function clsGridsex_occupation_patient($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "sex_occupation_patient";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid sex_occupation_patient";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clssex_occupation_patientDataSource($this);
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

        $this->patient_id = new clsControl(ccsLink, "patient_id", "patient_id", ccsInteger, "", CCGetRequestParam("patient_id", ccsGet, NULL), $this);
        $this->patient_id->Page = "";
        $this->surname = new clsControl(ccsLink, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->surname->Page = "view_patients.php";
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->age = new clsControl(ccsLabel, "age", "age", ccsInteger, "", CCGetRequestParam("age", ccsGet, NULL), $this);
        $this->hospital_no = new clsControl(ccsLabel, "hospital_no", "hospital_no", ccsText, "", CCGetRequestParam("hospital_no", ccsGet, NULL), $this);
        $this->occupation = new clsControl(ccsLabel, "occupation", "occupation", ccsText, "", CCGetRequestParam("occupation", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "schedule_test.php";
        $this->sex_occupation_patient_Insert = new clsControl(ccsLink, "sex_occupation_patient_Insert", "sex_occupation_patient_Insert", ccsText, "", CCGetRequestParam("sex_occupation_patient_Insert", ccsGet, NULL), $this);
        $this->sex_occupation_patient_Insert->Page = "index.php";
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

//Show Method @11-BCEC70AE
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_keyword"] = CCGetFromGet("s_keyword", NULL);

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
            $this->ControlsVisible["patient_id"] = $this->patient_id->Visible;
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["age"] = $this->age->Visible;
            $this->ControlsVisible["hospital_no"] = $this->hospital_no->Visible;
            $this->ControlsVisible["occupation"] = $this->occupation->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->patient_id->SetValue($this->DataSource->patient_id->GetValue());
                $this->patient_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->patient_id->Parameters = CCAddParam($this->patient_id->Parameters, "patient_id", $this->DataSource->f("patient_id"));
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->surname->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->surname->Parameters = CCAddParam($this->surname->Parameters, "patient_id", $this->DataSource->f("patient_id"));
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->age->SetValue($this->DataSource->age->GetValue());
                $this->hospital_no->SetValue($this->DataSource->hospital_no->GetValue());
                $this->occupation->SetValue($this->DataSource->occupation->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->Link1->SetValue($this->DataSource->Link1->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "patient_id", $this->DataSource->f("patient_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->patient_id->Show();
                $this->surname->Show();
                $this->other_names->Show();
                $this->age->Show();
                $this->hospital_no->Show();
                $this->occupation->Show();
                $this->sex->Show();
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
        $this->sex_occupation_patient_Insert->Parameters = CCGetQueryString("QueryString", array("patient_id", "ccsForm"));
        $this->sex_occupation_patient_Insert->Parameters = CCAddParam($this->sex_occupation_patient_Insert->Parameters, "onAdd", 1);
        $this->sex_occupation_patient_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @11-6911FF03
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->patient_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->age->Errors->ToString());
        $errors = ComposeStrings($errors, $this->hospital_no->Errors->ToString());
        $errors = ComposeStrings($errors, $this->occupation->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End sex_occupation_patient Class @11-FCB6E20C

class clssex_occupation_patientDataSource extends clsDBConnection1 {  //sex_occupation_patientDataSource Class @11-F7D84AC8

//DataSource Variables @11-A0EA2BB6
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $patient_id;
    public $surname;
    public $other_names;
    public $age;
    public $hospital_no;
    public $occupation;
    public $sex;
    public $Link1;
//End DataSource Variables

//DataSourceClass_Initialize Event @11-A536A1D1
    function clssex_occupation_patientDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid sex_occupation_patient";
        $this->Initialize();
        $this->patient_id = new clsField("patient_id", ccsInteger, "");
        
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->hospital_no = new clsField("hospital_no", ccsText, "");
        
        $this->occupation = new clsField("occupation", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @11-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @11-1B6381A6
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->AddParameter("2", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->AddParameter("3", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "patient.surname", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "patient.other_names", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "patient.hospital_no", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opOR(
             true, $this->wp->opOR(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @11-9308A798
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (patient LEFT JOIN occupation ON\n\n" .
        "patient.occupation_id = occupation.occupation_id) LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id";
        $this->SQL = "SELECT occupation, sex, patient_id, surname, other_names, age, hospital_no \n\n" .
        "FROM (patient LEFT JOIN occupation ON\n\n" .
        "patient.occupation_id = occupation.occupation_id) LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @11-7D6024A7
    function SetValues()
    {
        $this->patient_id->SetDBValue(trim($this->f("patient_id")));
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->age->SetDBValue(trim($this->f("age")));
        $this->hospital_no->SetDBValue($this->f("hospital_no"));
        $this->occupation->SetDBValue($this->f("occupation"));
        $this->sex->SetDBValue($this->f("sex"));
        $this->Link1->SetDBValue($this->f("patient_id"));
    }
//End SetValues Method

} //End sex_occupation_patientDataSource Class @11-FCB6E20C

class clsRecordsex_occupation_patient1 { //sex_occupation_patient1 Class @39-FA38CC1F

//Variables @39-9E315808

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

//Class_Initialize Event @39-F94F0CDD
    function clsRecordsex_occupation_patient1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record sex_occupation_patient1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "sex_occupation_patient1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_keyword = new clsControl(ccsTextBox, "s_keyword", "Keyword", ccsText, "", CCGetRequestParam("s_keyword", $Method, NULL), $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @39-A144A629
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_keyword->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_keyword->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @39-D6729123
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_keyword->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @39-670B96B7
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

//Show Method @39-0BB4DF41
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
            $Error = ComposeStrings($Error, $this->s_keyword->Errors->ToString());
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

        $this->s_keyword->Show();
        $this->Button_DoSearch->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End sex_occupation_patient1 Class @39-FCB6E20C

class clsRecordpatient { //patient Class @42-61D5C9BF

//Variables @42-9E315808

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

//Class_Initialize Event @42-87DF9557
    function clsRecordpatient($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record patient/Error";
        $this->DataSource = new clspatientDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "patient";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->surname = new clsControl(ccsTextBox, "surname", "Surname", ccsText, "", CCGetRequestParam("surname", $Method, NULL), $this);
            $this->surname->Required = true;
            $this->other_names = new clsControl(ccsTextBox, "other_names", "Other Names", ccsText, "", CCGetRequestParam("other_names", $Method, NULL), $this);
            $this->other_names->Required = true;
            $this->sex_id = new clsControl(ccsListBox, "sex_id", "Sex", ccsInteger, "", CCGetRequestParam("sex_id", $Method, NULL), $this);
            $this->sex_id->DSType = dsTable;
            $this->sex_id->DataSource = new clsDBConnection1();
            $this->sex_id->ds = & $this->sex_id->DataSource;
            $this->sex_id->DataSource->SQL = "SELECT * \n" .
"FROM sex {SQL_Where} {SQL_OrderBy}";
            list($this->sex_id->BoundColumn, $this->sex_id->TextColumn, $this->sex_id->DBFormat) = array("sex_id", "sex", "");
            $this->sex_id->Required = true;
            $this->occupation_id = new clsControl(ccsListBox, "occupation_id", "Occupation", ccsInteger, "", CCGetRequestParam("occupation_id", $Method, NULL), $this);
            $this->occupation_id->DSType = dsTable;
            $this->occupation_id->DataSource = new clsDBConnection1();
            $this->occupation_id->ds = & $this->occupation_id->DataSource;
            $this->occupation_id->DataSource->SQL = "SELECT * \n" .
"FROM occupation {SQL_Where} {SQL_OrderBy}";
            list($this->occupation_id->BoundColumn, $this->occupation_id->TextColumn, $this->occupation_id->DBFormat) = array("occupation_id", "occupation", "");
            $this->occupation_id->Required = true;
            $this->hospital_no = new clsControl(ccsTextBox, "hospital_no", "Hospital No", ccsText, "", CCGetRequestParam("hospital_no", $Method, NULL), $this);
            $this->hospital_no->Required = true;
            $this->age = new clsControl(ccsTextBox, "age", "Age", ccsInteger, "", CCGetRequestParam("age", $Method, NULL), $this);
            $this->age->Required = true;
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", $Method, NULL), $this);
            $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @42-AA9B7A54
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlpatient_id"] = CCGetFromGet("patient_id", NULL);
    }
//End Initialize Method

//Validate Method @42-3D1031F2
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->surname->Validate() && $Validation);
        $Validation = ($this->other_names->Validate() && $Validation);
        $Validation = ($this->sex_id->Validate() && $Validation);
        $Validation = ($this->occupation_id->Validate() && $Validation);
        $Validation = ($this->hospital_no->Validate() && $Validation);
        $Validation = ($this->age->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->surname->Errors->Count() == 0);
        $Validation =  $Validation && ($this->other_names->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sex_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->occupation_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->hospital_no->Errors->Count() == 0);
        $Validation =  $Validation && ($this->age->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @42-8084D89A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->surname->Errors->Count());
        $errors = ($errors || $this->other_names->Errors->Count());
        $errors = ($errors || $this->sex_id->Errors->Count());
        $errors = ($errors || $this->occupation_id->Errors->Count());
        $errors = ($errors || $this->hospital_no->Errors->Count());
        $errors = ($errors || $this->age->Errors->Count());
        $errors = ($errors || $this->Label1->Errors->Count());
        $errors = ($errors || $this->Label2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @42-6F0BA6DE
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            $Redirect = "index.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
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

//InsertRow Method @42-E73E490D
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->surname->SetValue($this->surname->GetValue(true));
        $this->DataSource->other_names->SetValue($this->other_names->GetValue(true));
        $this->DataSource->sex_id->SetValue($this->sex_id->GetValue(true));
        $this->DataSource->occupation_id->SetValue($this->occupation_id->GetValue(true));
        $this->DataSource->hospital_no->SetValue($this->hospital_no->GetValue(true));
        $this->DataSource->age->SetValue($this->age->GetValue(true));
        $this->DataSource->Label1->SetValue($this->Label1->GetValue(true));
        $this->DataSource->Label2->SetValue($this->Label2->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @42-25F2992E
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->surname->SetValue($this->surname->GetValue(true));
        $this->DataSource->other_names->SetValue($this->other_names->GetValue(true));
        $this->DataSource->sex_id->SetValue($this->sex_id->GetValue(true));
        $this->DataSource->occupation_id->SetValue($this->occupation_id->GetValue(true));
        $this->DataSource->hospital_no->SetValue($this->hospital_no->GetValue(true));
        $this->DataSource->age->SetValue($this->age->GetValue(true));
        $this->DataSource->Label1->SetValue($this->Label1->GetValue(true));
        $this->DataSource->Label2->SetValue($this->Label2->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @42-5FD3D9DF
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

        $this->sex_id->Prepare();
        $this->occupation_id->Prepare();

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
                    $this->surname->SetValue($this->DataSource->surname->GetValue());
                    $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                    $this->sex_id->SetValue($this->DataSource->sex_id->GetValue());
                    $this->occupation_id->SetValue($this->DataSource->occupation_id->GetValue());
                    $this->hospital_no->SetValue($this->DataSource->hospital_no->GetValue());
                    $this->age->SetValue($this->DataSource->age->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->surname->Errors->ToString());
            $Error = ComposeStrings($Error, $this->other_names->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sex_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->occupation_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->hospital_no->Errors->ToString());
            $Error = ComposeStrings($Error, $this->age->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label2->Errors->ToString());
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
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->surname->Show();
        $this->other_names->Show();
        $this->sex_id->Show();
        $this->occupation_id->Show();
        $this->hospital_no->Show();
        $this->age->Show();
        $this->Button1->Show();
        $this->Label1->Show();
        $this->Label2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End patient Class @42-FCB6E20C

class clspatientDataSource extends clsDBConnection1 {  //patientDataSource Class @42-A1B529E8

//DataSource Variables @42-C8EE2214
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $surname;
    public $other_names;
    public $sex_id;
    public $occupation_id;
    public $hospital_no;
    public $age;
    public $Label1;
    public $Label2;
//End DataSource Variables

//DataSourceClass_Initialize Event @42-38DDAEB0
    function clspatientDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record patient/Error";
        $this->Initialize();
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->sex_id = new clsField("sex_id", ccsInteger, "");
        
        $this->occupation_id = new clsField("occupation_id", ccsInteger, "");
        
        $this->hospital_no = new clsField("hospital_no", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->Label1 = new clsField("Label1", ccsText, "");
        
        $this->Label2 = new clsField("Label2", ccsText, "");
        

        $this->InsertFields["surname"] = array("Name" => "surname", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["other_names"] = array("Name" => "other_names", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["sex_id"] = array("Name" => "sex_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["occupation_id"] = array("Name" => "occupation_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["hospital_no"] = array("Name" => "hospital_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["age"] = array("Name" => "age", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["surname"] = array("Name" => "surname", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["other_names"] = array("Name" => "other_names", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["sex_id"] = array("Name" => "sex_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["occupation_id"] = array("Name" => "occupation_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["hospital_no"] = array("Name" => "hospital_no", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["age"] = array("Name" => "age", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @42-3D2E3E99
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlpatient_id", ccsInteger, "", "", $this->Parameters["urlpatient_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "patient_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @42-334D3A74
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM patient {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @42-06C63E0D
    function SetValues()
    {
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->sex_id->SetDBValue(trim($this->f("sex_id")));
        $this->occupation_id->SetDBValue(trim($this->f("occupation_id")));
        $this->hospital_no->SetDBValue($this->f("hospital_no"));
        $this->age->SetDBValue(trim($this->f("age")));
    }
//End SetValues Method

//Insert Method @42-A1B78F2E
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["surname"]["Value"] = $this->surname->GetDBValue(true);
        $this->InsertFields["other_names"]["Value"] = $this->other_names->GetDBValue(true);
        $this->InsertFields["sex_id"]["Value"] = $this->sex_id->GetDBValue(true);
        $this->InsertFields["occupation_id"]["Value"] = $this->occupation_id->GetDBValue(true);
        $this->InsertFields["hospital_no"]["Value"] = $this->hospital_no->GetDBValue(true);
        $this->InsertFields["age"]["Value"] = $this->age->GetDBValue(true);
        $this->SQL = CCBuildInsert("patient", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @42-E9DF8322
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["surname"]["Value"] = $this->surname->GetDBValue(true);
        $this->UpdateFields["other_names"]["Value"] = $this->other_names->GetDBValue(true);
        $this->UpdateFields["sex_id"]["Value"] = $this->sex_id->GetDBValue(true);
        $this->UpdateFields["occupation_id"]["Value"] = $this->occupation_id->GetDBValue(true);
        $this->UpdateFields["hospital_no"]["Value"] = $this->hospital_no->GetDBValue(true);
        $this->UpdateFields["age"]["Value"] = $this->age->GetDBValue(true);
        $this->SQL = CCBuildUpdate("patient", $this->UpdateFields, $this);
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

} //End patientDataSource Class @42-FCB6E20C

class clsGridtitle_status_users_result { //title_status_users_result class @84-F82E96D4

//Variables @84-B589444A

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
    public $Sorter_appointment_time;
    public $Sorter_patient_patient_id;
    public $Sorter_surname;
    public $Sorter_sex;
    public $Sorter_first_name;
    public $Sorter_status;
//End Variables

//Class_Initialize Event @84-86FE6547
    function clsGridtitle_status_users_result($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "title_status_users_result";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid title_status_users_result";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstitle_status_users_resultDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("title_status_users_resultOrder", "");
        $this->SorterDirection = CCGetParam("title_status_users_resultDir", "");

        $this->appointment_time = new clsControl(ccsLabel, "appointment_time", "appointment_time", ccsDate, array("h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("appointment_time", ccsGet, NULL), $this);
        $this->patient_patient_id = new clsControl(ccsLink, "patient_patient_id", "patient_patient_id", ccsInteger, "", CCGetRequestParam("patient_patient_id", ccsGet, NULL), $this);
        $this->patient_patient_id->Page = "patient_info.php";
        $this->surname = new clsControl(ccsLabel, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet, NULL), $this);
        $this->status = new clsControl(ccsLabel, "status", "status", ccsText, "", CCGetRequestParam("status", ccsGet, NULL), $this);
        $this->result_id = new clsControl(ccsLabel, "result_id", "result_id", ccsInteger, "", CCGetRequestParam("result_id", ccsGet, NULL), $this);
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->first_name = new clsControl(ccsLabel, "first_name", "first_name", ccsText, "", CCGetRequestParam("first_name", ccsGet, NULL), $this);
        $this->last_name = new clsControl(ccsLabel, "last_name", "last_name", ccsText, "", CCGetRequestParam("last_name", ccsGet, NULL), $this);
        $this->title_status_users_result_TotalRecords = new clsControl(ccsLabel, "title_status_users_result_TotalRecords", "title_status_users_result_TotalRecords", ccsText, "", CCGetRequestParam("title_status_users_result_TotalRecords", ccsGet, NULL), $this);
        $this->Sorter_appointment_time = new clsSorter($this->ComponentName, "Sorter_appointment_time", $FileName, $this);
        $this->Sorter_patient_patient_id = new clsSorter($this->ComponentName, "Sorter_patient_patient_id", $FileName, $this);
        $this->Sorter_surname = new clsSorter($this->ComponentName, "Sorter_surname", $FileName, $this);
        $this->Sorter_sex = new clsSorter($this->ComponentName, "Sorter_sex", $FileName, $this);
        $this->Sorter_first_name = new clsSorter($this->ComponentName, "Sorter_first_name", $FileName, $this);
        $this->Sorter_status = new clsSorter($this->ComponentName, "Sorter_status", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @84-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @84-C68828E5
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_department_id"] = CCGetFromGet("s_department_id", NULL);
        $this->DataSource->Parameters["urls_patient_id"] = CCGetFromGet("s_patient_id", NULL);

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
            $this->ControlsVisible["appointment_time"] = $this->appointment_time->Visible;
            $this->ControlsVisible["patient_patient_id"] = $this->patient_patient_id->Visible;
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["title"] = $this->title->Visible;
            $this->ControlsVisible["status"] = $this->status->Visible;
            $this->ControlsVisible["result_id"] = $this->result_id->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["first_name"] = $this->first_name->Visible;
            $this->ControlsVisible["last_name"] = $this->last_name->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->appointment_time->SetValue($this->DataSource->appointment_time->GetValue());
                $this->patient_patient_id->SetValue($this->DataSource->patient_patient_id->GetValue());
                $this->patient_patient_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->patient_patient_id->Parameters = CCAddParam($this->patient_patient_id->Parameters, "patient_id", $this->DataSource->f("patient_patient_id"));
                $this->patient_patient_id->Parameters = CCAddParam($this->patient_patient_id->Parameters, "result_id", $this->DataSource->f("result_id"));
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->title->SetValue($this->DataSource->title->GetValue());
                $this->status->SetValue($this->DataSource->status->GetValue());
                $this->result_id->SetValue($this->DataSource->result_id->GetValue());
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->first_name->SetValue($this->DataSource->first_name->GetValue());
                $this->last_name->SetValue($this->DataSource->last_name->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->appointment_time->Show();
                $this->patient_patient_id->Show();
                $this->surname->Show();
                $this->sex->Show();
                $this->title->Show();
                $this->status->Show();
                $this->result_id->Show();
                $this->other_names->Show();
                $this->first_name->Show();
                $this->last_name->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if (($this->Navigator->TotalPages <= 1 && $this->Navigator->PageNumber == 1) || $this->Navigator->PageSize == "") {
            $this->Navigator->Visible = false;
        }
        $this->title_status_users_result_TotalRecords->Show();
        $this->Sorter_appointment_time->Show();
        $this->Sorter_patient_patient_id->Show();
        $this->Sorter_surname->Show();
        $this->Sorter_sex->Show();
        $this->Sorter_first_name->Show();
        $this->Sorter_status->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @84-E93B7D82
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->appointment_time->Errors->ToString());
        $errors = ComposeStrings($errors, $this->patient_patient_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->result_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->first_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->last_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End title_status_users_result Class @84-FCB6E20C

class clstitle_status_users_resultDataSource extends clsDBConnection1 {  //title_status_users_resultDataSource Class @84-8A2C1E5D

//DataSource Variables @84-D9950556
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $appointment_time;
    public $patient_patient_id;
    public $surname;
    public $sex;
    public $title;
    public $status;
    public $result_id;
    public $other_names;
    public $first_name;
    public $last_name;
//End DataSource Variables

//DataSourceClass_Initialize Event @84-CC6B2614
    function clstitle_status_users_resultDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid title_status_users_result";
        $this->Initialize();
        $this->appointment_time = new clsField("appointment_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        
        $this->patient_patient_id = new clsField("patient_patient_id", ccsInteger, "");
        
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->title = new clsField("title", ccsText, "");
        
        $this->status = new clsField("status", ccsText, "");
        
        $this->result_id = new clsField("result_id", ccsInteger, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->first_name = new clsField("first_name", ccsText, "");
        
        $this->last_name = new clsField("last_name", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @84-5404B132
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "appointment_time";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_appointment_time" => array("appointment_time", ""), 
            "Sorter_patient_patient_id" => array("patient.patient_id", ""), 
            "Sorter_surname" => array("surname", ""), 
            "Sorter_sex" => array("sex", ""), 
            "Sorter_first_name" => array("first_name", ""), 
            "Sorter_status" => array("status", "")));
    }
//End SetOrder Method

//Prepare Method @84-52BB8CD3
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("3", "urls_department_id", ccsInteger, "", "", $this->Parameters["urls_department_id"], "", false);
        $this->wp->AddParameter("4", "urls_patient_id", ccsInteger, "", "", $this->Parameters["urls_patient_id"], "", false);
        $this->wp->Criterion[1] = "( result.appointment_date=current_date )";
        $this->wp->Criterion[2] = "( result.status_id<3 )";
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "result.department_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "result.patient_id", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @84-1C4C380B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) LEFT JOIN ((result LEFT JOIN (users LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "result.user_id = users.user_id) LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id) ON\n\n" .
        "patient.patient_id = result.patient_id";
        $this->SQL = "SELECT patient.*, first_name, last_name, sex, result.*, status, title, patient.patient_id AS patient_patient_id \n\n" .
        "FROM (patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) LEFT JOIN ((result LEFT JOIN (users LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "result.user_id = users.user_id) LEFT JOIN status ON\n\n" .
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

//SetValues Method @84-A31BEC72
    function SetValues()
    {
        $this->appointment_time->SetDBValue(trim($this->f("appointment_time")));
        $this->patient_patient_id->SetDBValue(trim($this->f("patient_patient_id")));
        $this->surname->SetDBValue($this->f("surname"));
        $this->sex->SetDBValue($this->f("sex"));
        $this->title->SetDBValue($this->f("title"));
        $this->status->SetDBValue($this->f("status"));
        $this->result_id->SetDBValue(trim($this->f("result_id")));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->last_name->SetDBValue($this->f("last_name"));
    }
//End SetValues Method

} //End title_status_users_resultDataSource Class @84-FCB6E20C

class clsRecordtitle_status_users_result1 { //title_status_users_result1 Class @161-13E46009

//Variables @161-9E315808

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

//Class_Initialize Event @161-57CD31C6
    function clsRecordtitle_status_users_result1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record title_status_users_result1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "title_status_users_result1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_department_id = new clsControl(ccsListBox, "s_department_id", "Department Id", ccsInteger, "", CCGetRequestParam("s_department_id", $Method, NULL), $this);
            $this->s_department_id->DSType = dsTable;
            $this->s_department_id->DataSource = new clsDBConnection1();
            $this->s_department_id->ds = & $this->s_department_id->DataSource;
            $this->s_department_id->DataSource->SQL = "SELECT * \n" .
"FROM department {SQL_Where} {SQL_OrderBy}";
            list($this->s_department_id->BoundColumn, $this->s_department_id->TextColumn, $this->s_department_id->DBFormat) = array("department_id", "department", "");
            $this->s_patient_id = new clsControl(ccsTextBox, "s_patient_id", "Patient Id", ccsInteger, "", CCGetRequestParam("s_patient_id", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @161-9989C5BC
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_department_id->Validate() && $Validation);
        $Validation = ($this->s_patient_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_department_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_patient_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @161-9E43A87D
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_department_id->Errors->Count());
        $errors = ($errors || $this->s_patient_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @161-670B96B7
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

//Show Method @161-BD9DF367
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

        $this->s_department_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_department_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_patient_id->Errors->ToString());
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
        $this->s_department_id->Show();
        $this->s_patient_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End title_status_users_result1 Class @161-FCB6E20C

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

//Authenticate User @1-8791BA6A
CCSecurityRedirect("1;4", "../access_denied.php");
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

//Initialize Objects @1-A787266E
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$header_receptionist = new clsheader_receptionist("../includes/", "header_receptionist", $MainPage);
$header_receptionist->Initialize();
$sex_occupation_patient = new clsGridsex_occupation_patient("", $MainPage);
$sex_occupation_patient1 = new clsRecordsex_occupation_patient1("", $MainPage);
$patient = new clsRecordpatient("", $MainPage);
$title_status_users_result = new clsGridtitle_status_users_result("", $MainPage);
$title_status_users_result1 = new clsRecordtitle_status_users_result1("", $MainPage);
$MainPage->footer = & $footer;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->header_receptionist = & $header_receptionist;
$MainPage->sex_occupation_patient = & $sex_occupation_patient;
$MainPage->sex_occupation_patient1 = & $sex_occupation_patient1;
$MainPage->patient = & $patient;
$MainPage->title_status_users_result = & $title_status_users_result;
$MainPage->title_status_users_result1 = & $title_status_users_result1;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());
$sex_occupation_patient->Initialize();
$patient->Initialize();
$title_status_users_result->Initialize();

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

//Execute Components @1-BF8B41E9
$title_status_users_result1->Operation();
$patient->Operation();
$sex_occupation_patient1->Operation();
$header_receptionist->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-14D3FCD2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_receptionist->Class_Terminate();
    unset($header_receptionist);
    unset($sex_occupation_patient);
    unset($sex_occupation_patient1);
    unset($patient);
    unset($title_status_users_result);
    unset($title_status_users_result1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-D9568D33
$footer->Show();
$header_receptionist->Show();
$sex_occupation_patient->Show();
$sex_occupation_patient1->Show();
$patient->Show();
$title_status_users_result->Show();
$title_status_users_result1->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-55F76541
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
$header_receptionist->Class_Terminate();
unset($header_receptionist);
unset($sex_occupation_patient);
unset($sex_occupation_patient1);
unset($patient);
unset($title_status_users_result);
unset($title_status_users_result1);
unset($Tpl);
//End Unload Page
?>
