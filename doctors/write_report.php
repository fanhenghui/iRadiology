<?php

//Include Common Files @1-EB54B557
define("RelativePath", "..");
define("PathToCurrentPage", "/doctors/");
define("FileName", "write_report.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

class clsGridstatus_result_occupation { //status_result_occupation class @13-A95A0D4E

//Variables @13-6E51DF5A

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

//Class_Initialize Event @13-995725EE
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
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->patient_id = new clsControl(ccsLabel, "patient_id", "patient_id", ccsInteger, "", CCGetRequestParam("patient_id", ccsGet, NULL), $this);
        $this->surname = new clsControl(ccsLabel, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->age = new clsControl(ccsLabel, "age", "age", ccsInteger, "", CCGetRequestParam("age", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->occupation = new clsControl(ccsLabel, "occupation", "occupation", ccsText, "", CCGetRequestParam("occupation", ccsGet, NULL), $this);
        $this->appointment_time = new clsControl(ccsLabel, "appointment_time", "appointment_time", ccsDate, array("h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("appointment_time", ccsGet, NULL), $this);
        $this->status = new clsControl(ccsLabel, "status", "status", ccsText, "", CCGetRequestParam("status", ccsGet, NULL), $this);
        $this->result_id = new clsControl(ccsLabel, "result_id", "result_id", ccsInteger, "", CCGetRequestParam("result_id", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @13-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @13-98B43FFB
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["expr23"] = ccgetuserid();
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
            $this->ControlsVisible["patient_id"] = $this->patient_id->Visible;
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["age"] = $this->age->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["occupation"] = $this->occupation->Visible;
            $this->ControlsVisible["appointment_time"] = $this->appointment_time->Visible;
            $this->ControlsVisible["status"] = $this->status->Visible;
            $this->ControlsVisible["result_id"] = $this->result_id->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->patient_id->SetValue($this->DataSource->patient_id->GetValue());
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->age->SetValue($this->DataSource->age->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->occupation->SetValue($this->DataSource->occupation->GetValue());
                $this->appointment_time->SetValue($this->DataSource->appointment_time->GetValue());
                $this->status->SetValue($this->DataSource->status->GetValue());
                $this->result_id->SetValue($this->DataSource->result_id->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->patient_id->Show();
                $this->surname->Show();
                $this->other_names->Show();
                $this->age->Show();
                $this->sex->Show();
                $this->occupation->Show();
                $this->appointment_time->Show();
                $this->status->Show();
                $this->result_id->Show();
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

//GetErrors Method @13-82146DA4
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->patient_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->age->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->occupation->Errors->ToString());
        $errors = ComposeStrings($errors, $this->appointment_time->Errors->ToString());
        $errors = ComposeStrings($errors, $this->status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->result_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End status_result_occupation Class @13-FCB6E20C

class clsstatus_result_occupationDataSource extends clsDBConnection1 {  //status_result_occupationDataSource Class @13-5ABD84D6

//DataSource Variables @13-D83D061C
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
    public $sex;
    public $occupation;
    public $appointment_time;
    public $status;
    public $result_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @13-82A55A65
    function clsstatus_result_occupationDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid status_result_occupation";
        $this->Initialize();
        $this->patient_id = new clsField("patient_id", ccsInteger, "");
        
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->occupation = new clsField("occupation", ccsText, "");
        
        $this->appointment_time = new clsField("appointment_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        
        $this->status = new clsField("status", ccsText, "");
        
        $this->result_id = new clsField("result_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @13-D15F59F1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "appointment_time";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @13-CC9424FB
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr23", ccsInteger, "", "", $this->Parameters["expr23"], "", false);
        $this->wp->AddParameter("3", "urlresult_id", ccsInteger, "", "", $this->Parameters["urlresult_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "result.user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = "( result.appointment_date=current_date )";
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "result_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @13-0C27FBA1
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

//SetValues Method @13-579510C4
    function SetValues()
    {
        $this->patient_id->SetDBValue(trim($this->f("patient_id")));
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->age->SetDBValue(trim($this->f("age")));
        $this->sex->SetDBValue($this->f("sex"));
        $this->occupation->SetDBValue($this->f("occupation"));
        $this->appointment_time->SetDBValue(trim($this->f("appointment_time")));
        $this->status->SetDBValue($this->f("status"));
        $this->result_id->SetDBValue(trim($this->f("result_id")));
    }
//End SetValues Method

} //End status_result_occupationDataSource Class @13-FCB6E20C

class clsRecordresult { //result Class @48-3AFEA74E

//Variables @48-9E315808

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

//Class_Initialize Event @48-7D253708
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->clinic_id = new clsControl(ccsHidden, "clinic_id", "Clinic Id", ccsInteger, "", CCGetRequestParam("clinic_id", $Method, NULL), $this);
            $this->primary_diagnosis = new clsControl(ccsLabel, "primary_diagnosis", "primary_diagnosis", ccsText, "", CCGetRequestParam("primary_diagnosis", $Method, NULL), $this);
            $this->clinical_notes = new clsControl(ccsLabel, "clinical_notes", "clinical_notes", ccsText, "", CCGetRequestParam("clinical_notes", $Method, NULL), $this);
            $this->result1 = new clsControl(ccsTextArea, "result1", "Result", ccsText, "", CCGetRequestParam("result1", $Method, NULL), $this);
            $this->result1->Required = true;
            $this->conclusion = new clsControl(ccsTextArea, "conclusion", "Conclusion", ccsText, "", CCGetRequestParam("conclusion", $Method, NULL), $this);
            $this->conclusion->Required = true;
            $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", $Method, NULL), $this);
            $this->sup_dept_id = new clsControl(ccsHidden, "sup_dept_id", "Sup Dept Id", ccsInteger, "", CCGetRequestParam("sup_dept_id", $Method, NULL), $this);
            $this->Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", $Method, NULL), $this);
            $this->stat_conclusion = new clsControl(ccsListBox, "stat_conclusion", "Statistical Conclusion", ccsInteger, "", CCGetRequestParam("stat_conclusion", $Method, NULL), $this);
            $this->stat_conclusion->DSType = dsTable;
            $this->stat_conclusion->DataSource = new clsDBConnection1();
            $this->stat_conclusion->ds = & $this->stat_conclusion->DataSource;
            $this->stat_conclusion->DataSource->SQL = "SELECT * \n" .
"FROM statistical_conclusion {SQL_Where} {SQL_OrderBy}";
            list($this->stat_conclusion->BoundColumn, $this->stat_conclusion->TextColumn, $this->stat_conclusion->DBFormat) = array("statistical_conclusion_id", "statistical_conclusion", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @48-576B2713
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlresult_id"] = CCGetFromGet("result_id", NULL);
    }
//End Initialize Method

//Validate Method @48-6D7BE872
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->clinic_id->Validate() && $Validation);
        $Validation = ($this->result1->Validate() && $Validation);
        $Validation = ($this->conclusion->Validate() && $Validation);
        $Validation = ($this->sup_dept_id->Validate() && $Validation);
        $Validation = ($this->stat_conclusion->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->clinic_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->result1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->conclusion->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_dept_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->stat_conclusion->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @48-CFADFFAD
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->clinic_id->Errors->Count());
        $errors = ($errors || $this->primary_diagnosis->Errors->Count());
        $errors = ($errors || $this->clinical_notes->Errors->Count());
        $errors = ($errors || $this->result1->Errors->Count());
        $errors = ($errors || $this->conclusion->Errors->Count());
        $errors = ($errors || $this->Label1->Errors->Count());
        $errors = ($errors || $this->sup_dept_id->Errors->Count());
        $errors = ($errors || $this->Label2->Errors->Count());
        $errors = ($errors || $this->stat_conclusion->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @48-5B06BA55
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
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

//UpdateRow Method @48-8016CDC0
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->clinic_id->SetValue($this->clinic_id->GetValue(true));
        $this->DataSource->primary_diagnosis->SetValue($this->primary_diagnosis->GetValue(true));
        $this->DataSource->clinical_notes->SetValue($this->clinical_notes->GetValue(true));
        $this->DataSource->result1->SetValue($this->result1->GetValue(true));
        $this->DataSource->conclusion->SetValue($this->conclusion->GetValue(true));
        $this->DataSource->Label1->SetValue($this->Label1->GetValue(true));
        $this->DataSource->sup_dept_id->SetValue($this->sup_dept_id->GetValue(true));
        $this->DataSource->Label2->SetValue($this->Label2->GetValue(true));
        $this->DataSource->stat_conclusion->SetValue($this->stat_conclusion->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @48-28DEE76F
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

        $this->stat_conclusion->Prepare();

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
                $this->primary_diagnosis->SetValue($this->DataSource->primary_diagnosis->GetValue());
                $this->clinical_notes->SetValue($this->DataSource->clinical_notes->GetValue());
                if(!$this->FormSubmitted){
                    $this->clinic_id->SetValue($this->DataSource->clinic_id->GetValue());
                    $this->result1->SetValue($this->DataSource->result1->GetValue());
                    $this->conclusion->SetValue($this->DataSource->conclusion->GetValue());
                    $this->sup_dept_id->SetValue($this->DataSource->sup_dept_id->GetValue());
                    $this->stat_conclusion->SetValue($this->DataSource->stat_conclusion->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->clinic_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->primary_diagnosis->Errors->ToString());
            $Error = ComposeStrings($Error, $this->clinical_notes->Errors->ToString());
            $Error = ComposeStrings($Error, $this->result1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->conclusion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_dept_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Label2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->stat_conclusion->Errors->ToString());
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
        $this->Button_Cancel->Show();
        $this->clinic_id->Show();
        $this->primary_diagnosis->Show();
        $this->clinical_notes->Show();
        $this->result1->Show();
        $this->conclusion->Show();
        $this->Label1->Show();
        $this->sup_dept_id->Show();
        $this->Label2->Show();
        $this->stat_conclusion->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End result Class @48-FCB6E20C

class clsresultDataSource extends clsDBConnection1 {  //resultDataSource Class @48-E277B187

//DataSource Variables @48-170309BA
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
    public $clinic_id;
    public $primary_diagnosis;
    public $clinical_notes;
    public $result1;
    public $conclusion;
    public $Label1;
    public $sup_dept_id;
    public $Label2;
    public $stat_conclusion;
//End DataSource Variables

//DataSourceClass_Initialize Event @48-D5E7BF8B
    function clsresultDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record result/Error";
        $this->Initialize();
        $this->clinic_id = new clsField("clinic_id", ccsInteger, "");
        
        $this->primary_diagnosis = new clsField("primary_diagnosis", ccsText, "");
        
        $this->clinical_notes = new clsField("clinical_notes", ccsText, "");
        
        $this->result1 = new clsField("result1", ccsText, "");
        
        $this->conclusion = new clsField("conclusion", ccsText, "");
        
        $this->Label1 = new clsField("Label1", ccsText, "");
        
        $this->sup_dept_id = new clsField("sup_dept_id", ccsInteger, "");
        
        $this->Label2 = new clsField("Label2", ccsText, "");
        
        $this->stat_conclusion = new clsField("stat_conclusion", ccsInteger, "");
        

        $this->UpdateFields["clinic_id"] = array("Name" => "clinic_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["result"] = array("Name" => "result", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["conclusion"] = array("Name" => "conclusion", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["sup_dept_id"] = array("Name" => "sup_dept_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["statistical_conclusion_id"] = array("Name" => "statistical_conclusion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @48-7EA7128F
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

//Open Method @48-FDA34939
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM result {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @48-3D3A98AB
    function SetValues()
    {
        $this->clinic_id->SetDBValue(trim($this->f("clinic_id")));
        $this->primary_diagnosis->SetDBValue($this->f("primary_diagnosis"));
        $this->clinical_notes->SetDBValue($this->f("clinical_notes"));
        $this->result1->SetDBValue($this->f("result"));
        $this->conclusion->SetDBValue($this->f("conclusion"));
        $this->sup_dept_id->SetDBValue(trim($this->f("sup_dept_id")));
        $this->stat_conclusion->SetDBValue(trim($this->f("statistical_conclusion_id")));
    }
//End SetValues Method

//Update Method @48-4FE524C7
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["clinic_id"]["Value"] = $this->clinic_id->GetDBValue(true);
        $this->UpdateFields["result"]["Value"] = $this->result1->GetDBValue(true);
        $this->UpdateFields["conclusion"]["Value"] = $this->conclusion->GetDBValue(true);
        $this->UpdateFields["sup_dept_id"]["Value"] = $this->sup_dept_id->GetDBValue(true);
        $this->UpdateFields["statistical_conclusion_id"]["Value"] = $this->stat_conclusion->GetDBValue(true);
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

} //End resultDataSource Class @48-FCB6E20C

//Include Page implementation @65-B75B411B
include_once(RelativePath . "/includes/header_doctors_wrpt.php");
//End Include Page implementation

//Initialize Page @1-6C7CD38E
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
$TemplateFileName = "write_report.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-2299D106
CCSecurityRedirect("2;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-303E4956
include_once("./write_report_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-B365DBC2
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
$Label3 = new clsControl(ccsLabel, "Label3", "Label3", ccsText, "", CCGetRequestParam("Label3", ccsGet, NULL), $MainPage);
$status_result_occupation = new clsGridstatus_result_occupation("", $MainPage);
$result = new clsRecordresult("", $MainPage);
$header_doctors_wrpt = new clsheader_doctors_wrpt("../includes/", "header_doctors_wrpt", $MainPage);
$header_doctors_wrpt->Initialize();
$MainPage->footer = & $footer;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->Label3 = & $Label3;
$MainPage->status_result_occupation = & $status_result_occupation;
$MainPage->result = & $result;
$MainPage->header_doctors_wrpt = & $header_doctors_wrpt;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());
$status_result_occupation->Initialize();
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

//Execute Components @1-2C61EF57
$header_doctors_wrpt->Operations();
$result->Operation();
$footer->Operations();
//End Execute Components

//Go to destination page @1-CF9BD2E0
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    unset($status_result_occupation);
    unset($result);
    $header_doctors_wrpt->Class_Terminate();
    unset($header_doctors_wrpt);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-A4BB62C6
$footer->Show();
$status_result_occupation->Show();
$result->Show();
$header_doctors_wrpt->Show();
$Label1->Show();
$Label2->Show();
$Label3->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-3045CB43
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
unset($status_result_occupation);
unset($result);
$header_doctors_wrpt->Class_Terminate();
unset($header_doctors_wrpt);
unset($Tpl);
//End Unload Page
?>
