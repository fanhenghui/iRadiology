<?php

//Include Common Files @1-826E791C
define("RelativePath", "..");
define("PathToCurrentPage", "/reception/");
define("FileName", "patient_info.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridusers_clinic_status_stati { //users_clinic_status_stati class @2-B0F00845

//Variables @2-6E51DF5A

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

//Class_Initialize Event @2-A2258F15
    function clsGridusers_clinic_status_stati($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "users_clinic_status_stati";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid users_clinic_status_stati";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsusers_clinic_status_statiDataSource($this);
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

        $this->result_id = new clsControl(ccsLabel, "result_id", "result_id", ccsInteger, "", CCGetRequestParam("result_id", ccsGet, NULL), $this);
        $this->status = new clsControl(ccsLabel, "status", "status", ccsText, "", CCGetRequestParam("status", ccsGet, NULL), $this);
        $this->department = new clsControl(ccsLabel, "department", "department", ccsText, "", CCGetRequestParam("department", ccsGet, NULL), $this);
        $this->sub_dept = new clsControl(ccsLabel, "sub_dept", "sub_dept", ccsText, "", CCGetRequestParam("sub_dept", ccsGet, NULL), $this);
        $this->surname = new clsControl(ccsLabel, "surname", "surname", ccsText, "", CCGetRequestParam("surname", ccsGet, NULL), $this);
        $this->other_names = new clsControl(ccsLabel, "other_names", "other_names", ccsText, "", CCGetRequestParam("other_names", ccsGet, NULL), $this);
        $this->age = new clsControl(ccsLabel, "age", "age", ccsInteger, "", CCGetRequestParam("age", ccsGet, NULL), $this);
        $this->sex = new clsControl(ccsLabel, "sex", "sex", ccsText, "", CCGetRequestParam("sex", ccsGet, NULL), $this);
        $this->occupation = new clsControl(ccsLabel, "occupation", "occupation", ccsText, "", CCGetRequestParam("occupation", ccsGet, NULL), $this);
        $this->result = new clsControl(ccsLabel, "result", "result", ccsText, "", CCGetRequestParam("result", ccsGet, NULL), $this);
        $this->result->HTML = true;
        $this->conclusion = new clsControl(ccsLabel, "conclusion", "conclusion", ccsText, "", CCGetRequestParam("conclusion", ccsGet, NULL), $this);
        $this->conclusion->HTML = true;
        $this->consultant_i_c = new clsControl(ccsLabel, "consultant_i_c", "consultant_i_c", ccsText, "", CCGetRequestParam("consultant_i_c", ccsGet, NULL), $this);
        $this->amount_to_pay = new clsControl(ccsLabel, "amount_to_pay", "amount_to_pay", ccsFloat, array(False, 2, Null, Null, False, "", "", 1, True, ""), CCGetRequestParam("amount_to_pay", ccsGet, NULL), $this);
        $this->date = new clsControl(ccsLabel, "date", "date", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("date", ccsGet, NULL), $this);
        $this->hospital_no = new clsControl(ccsLabel, "hospital_no", "hospital_no", ccsText, "", CCGetRequestParam("hospital_no", ccsGet, NULL), $this);
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet, NULL), $this);
        $this->appointment_date = new clsControl(ccsLabel, "appointment_date", "appointment_date", ccsDate, array("LongDate"), CCGetRequestParam("appointment_date", ccsGet, NULL), $this);
        $this->appointment_time = new clsControl(ccsLabel, "appointment_time", "appointment_time", ccsDate, array("h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("appointment_time", ccsGet, NULL), $this);
        $this->l_m_p1 = new clsControl(ccsLabel, "l_m_p1", "l_m_p1", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("l_m_p1", ccsGet, NULL), $this);
        $this->primary_diagnosis = new clsControl(ccsLabel, "primary_diagnosis", "primary_diagnosis", ccsText, "", CCGetRequestParam("primary_diagnosis", ccsGet, NULL), $this);
        $this->primary_diagnosis->HTML = true;
        $this->clinical_notes = new clsControl(ccsLabel, "clinical_notes", "clinical_notes", ccsText, "", CCGetRequestParam("clinical_notes", ccsGet, NULL), $this);
        $this->clinical_notes->HTML = true;
        $this->first_name = new clsControl(ccsLabel, "first_name", "first_name", ccsText, "", CCGetRequestParam("first_name", ccsGet, NULL), $this);
        $this->last_name = new clsControl(ccsLabel, "last_name", "last_name", ccsText, "", CCGetRequestParam("last_name", ccsGet, NULL), $this);
        $this->statistical_conclusion = new clsControl(ccsLabel, "statistical_conclusion", "statistical_conclusion", ccsText, "", CCGetRequestParam("statistical_conclusion", ccsGet, NULL), $this);
        $this->clinic = new clsControl(ccsLabel, "clinic", "clinic", ccsText, "", CCGetRequestParam("clinic", ccsGet, NULL), $this);
        $this->patient_patient_id = new clsControl(ccsLabel, "patient_patient_id", "patient_patient_id", ccsInteger, "", CCGetRequestParam("patient_patient_id", ccsGet, NULL), $this);
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "../print_report.php";
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-0A875709
    function Show()
    {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlresult_id"] = CCGetFromGet("result_id", NULL);
        $this->DataSource->Parameters["urlpatient_id"] = CCGetFromGet("patient_id", NULL);

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
            $this->ControlsVisible["status"] = $this->status->Visible;
            $this->ControlsVisible["department"] = $this->department->Visible;
            $this->ControlsVisible["sub_dept"] = $this->sub_dept->Visible;
            $this->ControlsVisible["surname"] = $this->surname->Visible;
            $this->ControlsVisible["other_names"] = $this->other_names->Visible;
            $this->ControlsVisible["age"] = $this->age->Visible;
            $this->ControlsVisible["sex"] = $this->sex->Visible;
            $this->ControlsVisible["occupation"] = $this->occupation->Visible;
            $this->ControlsVisible["result"] = $this->result->Visible;
            $this->ControlsVisible["conclusion"] = $this->conclusion->Visible;
            $this->ControlsVisible["consultant_i_c"] = $this->consultant_i_c->Visible;
            $this->ControlsVisible["amount_to_pay"] = $this->amount_to_pay->Visible;
            $this->ControlsVisible["date"] = $this->date->Visible;
            $this->ControlsVisible["hospital_no"] = $this->hospital_no->Visible;
            $this->ControlsVisible["title"] = $this->title->Visible;
            $this->ControlsVisible["appointment_date"] = $this->appointment_date->Visible;
            $this->ControlsVisible["appointment_time"] = $this->appointment_time->Visible;
            $this->ControlsVisible["l_m_p1"] = $this->l_m_p1->Visible;
            $this->ControlsVisible["primary_diagnosis"] = $this->primary_diagnosis->Visible;
            $this->ControlsVisible["clinical_notes"] = $this->clinical_notes->Visible;
            $this->ControlsVisible["first_name"] = $this->first_name->Visible;
            $this->ControlsVisible["last_name"] = $this->last_name->Visible;
            $this->ControlsVisible["statistical_conclusion"] = $this->statistical_conclusion->Visible;
            $this->ControlsVisible["clinic"] = $this->clinic->Visible;
            $this->ControlsVisible["patient_patient_id"] = $this->patient_patient_id->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->result_id->SetValue($this->DataSource->result_id->GetValue());
                $this->status->SetValue($this->DataSource->status->GetValue());
                $this->department->SetValue($this->DataSource->department->GetValue());
                $this->sub_dept->SetValue($this->DataSource->sub_dept->GetValue());
                $this->surname->SetValue($this->DataSource->surname->GetValue());
                $this->other_names->SetValue($this->DataSource->other_names->GetValue());
                $this->age->SetValue($this->DataSource->age->GetValue());
                $this->sex->SetValue($this->DataSource->sex->GetValue());
                $this->occupation->SetValue($this->DataSource->occupation->GetValue());
                $this->result->SetValue($this->DataSource->result->GetValue());
                $this->conclusion->SetValue($this->DataSource->conclusion->GetValue());
                $this->consultant_i_c->SetValue($this->DataSource->consultant_i_c->GetValue());
                $this->amount_to_pay->SetValue($this->DataSource->amount_to_pay->GetValue());
                $this->date->SetValue($this->DataSource->date->GetValue());
                $this->hospital_no->SetValue($this->DataSource->hospital_no->GetValue());
                $this->title->SetValue($this->DataSource->title->GetValue());
                $this->appointment_date->SetValue($this->DataSource->appointment_date->GetValue());
                $this->appointment_time->SetValue($this->DataSource->appointment_time->GetValue());
                $this->l_m_p1->SetValue($this->DataSource->l_m_p1->GetValue());
                $this->primary_diagnosis->SetValue($this->DataSource->primary_diagnosis->GetValue());
                $this->clinical_notes->SetValue($this->DataSource->clinical_notes->GetValue());
                $this->first_name->SetValue($this->DataSource->first_name->GetValue());
                $this->last_name->SetValue($this->DataSource->last_name->GetValue());
                $this->statistical_conclusion->SetValue($this->DataSource->statistical_conclusion->GetValue());
                $this->clinic->SetValue($this->DataSource->clinic->GetValue());
                $this->patient_patient_id->SetValue($this->DataSource->patient_patient_id->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "result_id", $this->DataSource->f("result_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->result_id->Show();
                $this->status->Show();
                $this->department->Show();
                $this->sub_dept->Show();
                $this->surname->Show();
                $this->other_names->Show();
                $this->age->Show();
                $this->sex->Show();
                $this->occupation->Show();
                $this->result->Show();
                $this->conclusion->Show();
                $this->consultant_i_c->Show();
                $this->amount_to_pay->Show();
                $this->date->Show();
                $this->hospital_no->Show();
                $this->title->Show();
                $this->appointment_date->Show();
                $this->appointment_time->Show();
                $this->l_m_p1->Show();
                $this->primary_diagnosis->Show();
                $this->clinical_notes->Show();
                $this->first_name->Show();
                $this->last_name->Show();
                $this->statistical_conclusion->Show();
                $this->clinic->Show();
                $this->patient_patient_id->Show();
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

//GetErrors Method @2-241AC6E3
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->result_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->department->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sub_dept->Errors->ToString());
        $errors = ComposeStrings($errors, $this->surname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->other_names->Errors->ToString());
        $errors = ComposeStrings($errors, $this->age->Errors->ToString());
        $errors = ComposeStrings($errors, $this->sex->Errors->ToString());
        $errors = ComposeStrings($errors, $this->occupation->Errors->ToString());
        $errors = ComposeStrings($errors, $this->result->Errors->ToString());
        $errors = ComposeStrings($errors, $this->conclusion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->consultant_i_c->Errors->ToString());
        $errors = ComposeStrings($errors, $this->amount_to_pay->Errors->ToString());
        $errors = ComposeStrings($errors, $this->date->Errors->ToString());
        $errors = ComposeStrings($errors, $this->hospital_no->Errors->ToString());
        $errors = ComposeStrings($errors, $this->title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->appointment_date->Errors->ToString());
        $errors = ComposeStrings($errors, $this->appointment_time->Errors->ToString());
        $errors = ComposeStrings($errors, $this->l_m_p1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->primary_diagnosis->Errors->ToString());
        $errors = ComposeStrings($errors, $this->clinical_notes->Errors->ToString());
        $errors = ComposeStrings($errors, $this->first_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->last_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->statistical_conclusion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->clinic->Errors->ToString());
        $errors = ComposeStrings($errors, $this->patient_patient_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End users_clinic_status_stati Class @2-FCB6E20C

class clsusers_clinic_status_statiDataSource extends clsDBConnection1 {  //users_clinic_status_statiDataSource Class @2-CEBFAD73

//DataSource Variables @2-B05D7740
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $result_id;
    public $status;
    public $department;
    public $sub_dept;
    public $surname;
    public $other_names;
    public $age;
    public $sex;
    public $occupation;
    public $result;
    public $conclusion;
    public $consultant_i_c;
    public $amount_to_pay;
    public $date;
    public $hospital_no;
    public $title;
    public $appointment_date;
    public $appointment_time;
    public $l_m_p1;
    public $primary_diagnosis;
    public $clinical_notes;
    public $first_name;
    public $last_name;
    public $statistical_conclusion;
    public $clinic;
    public $patient_patient_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-BF959796
    function clsusers_clinic_status_statiDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid users_clinic_status_stati";
        $this->Initialize();
        $this->result_id = new clsField("result_id", ccsInteger, "");
        
        $this->status = new clsField("status", ccsText, "");
        
        $this->department = new clsField("department", ccsText, "");
        
        $this->sub_dept = new clsField("sub_dept", ccsText, "");
        
        $this->surname = new clsField("surname", ccsText, "");
        
        $this->other_names = new clsField("other_names", ccsText, "");
        
        $this->age = new clsField("age", ccsInteger, "");
        
        $this->sex = new clsField("sex", ccsText, "");
        
        $this->occupation = new clsField("occupation", ccsText, "");
        
        $this->result = new clsField("result", ccsText, "");
        
        $this->conclusion = new clsField("conclusion", ccsText, "");
        
        $this->consultant_i_c = new clsField("consultant_i_c", ccsText, "");
        
        $this->amount_to_pay = new clsField("amount_to_pay", ccsFloat, "");
        
        $this->date = new clsField("date", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->hospital_no = new clsField("hospital_no", ccsText, "");
        
        $this->title = new clsField("title", ccsText, "");
        
        $this->appointment_date = new clsField("appointment_date", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->appointment_time = new clsField("appointment_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        
        $this->l_m_p1 = new clsField("l_m_p1", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->primary_diagnosis = new clsField("primary_diagnosis", ccsText, "");
        
        $this->clinical_notes = new clsField("clinical_notes", ccsText, "");
        
        $this->first_name = new clsField("first_name", ccsText, "");
        
        $this->last_name = new clsField("last_name", ccsText, "");
        
        $this->statistical_conclusion = new clsField("statistical_conclusion", ccsText, "");
        
        $this->clinic = new clsField("clinic", ccsText, "");
        
        $this->patient_patient_id = new clsField("patient_patient_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-CF4E7070
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlresult_id", ccsInteger, "", "", $this->Parameters["urlresult_id"], "", false);
        $this->wp->AddParameter("2", "urlpatient_id", ccsInteger, "", "", $this->Parameters["urlpatient_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "result_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "patient.patient_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @2-7A73B1F5
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM sub_dept RIGHT JOIN ((((((result RIGHT JOIN ((patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) LEFT JOIN occupation ON\n\n" .
        "patient.occupation_id = occupation.occupation_id) ON\n\n" .
        "result.patient_id = patient.patient_id) LEFT JOIN department ON\n\n" .
        "result.department_id = department.department_id) LEFT JOIN statistical_conclusion ON\n\n" .
        "result.statistical_conclusion_id = statistical_conclusion.statistical_conclusion_id) LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id) LEFT JOIN clinic ON\n\n" .
        "result.clinic_id = clinic.clinic_id) LEFT JOIN (users LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "result.user_id = users.user_id) ON\n\n" .
        "sub_dept.sub_dept_id = result.sup_dept_id";
        $this->SQL = "SELECT patient.patient_id AS patient_patient_id, surname, other_names, age, hospital_no, clinic, sex, department, occupation, sub_dept,\n\n" .
        "statistical_conclusion, status, first_name, last_name, result_id, primary_diagnosis, clinical_notes, consultant_i_c, result,\n\n" .
        "amount_to_pay, l_m_p, conclusion, date, appointment_date, appointment_time, title \n\n" .
        "FROM sub_dept RIGHT JOIN ((((((result RIGHT JOIN ((patient LEFT JOIN sex ON\n\n" .
        "patient.sex_id = sex.sex_id) LEFT JOIN occupation ON\n\n" .
        "patient.occupation_id = occupation.occupation_id) ON\n\n" .
        "result.patient_id = patient.patient_id) LEFT JOIN department ON\n\n" .
        "result.department_id = department.department_id) LEFT JOIN statistical_conclusion ON\n\n" .
        "result.statistical_conclusion_id = statistical_conclusion.statistical_conclusion_id) LEFT JOIN status ON\n\n" .
        "result.status_id = status.status_id) LEFT JOIN clinic ON\n\n" .
        "result.clinic_id = clinic.clinic_id) LEFT JOIN (users LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "result.user_id = users.user_id) ON\n\n" .
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

//SetValues Method @2-F8BF2D1E
    function SetValues()
    {
        $this->result_id->SetDBValue(trim($this->f("result_id")));
        $this->status->SetDBValue($this->f("status"));
        $this->department->SetDBValue($this->f("department"));
        $this->sub_dept->SetDBValue($this->f("sub_dept"));
        $this->surname->SetDBValue($this->f("surname"));
        $this->other_names->SetDBValue($this->f("other_names"));
        $this->age->SetDBValue(trim($this->f("age")));
        $this->sex->SetDBValue($this->f("sex"));
        $this->occupation->SetDBValue($this->f("occupation"));
        $this->result->SetDBValue($this->f("result"));
        $this->conclusion->SetDBValue($this->f("conclusion"));
        $this->consultant_i_c->SetDBValue($this->f("consultant_i_c"));
        $this->amount_to_pay->SetDBValue(trim($this->f("amount_to_pay")));
        $this->date->SetDBValue(trim($this->f("date")));
        $this->hospital_no->SetDBValue($this->f("hospital_no"));
        $this->title->SetDBValue($this->f("title"));
        $this->appointment_date->SetDBValue(trim($this->f("appointment_date")));
        $this->appointment_time->SetDBValue(trim($this->f("appointment_time")));
        $this->l_m_p1->SetDBValue(trim($this->f("l_m_p")));
        $this->primary_diagnosis->SetDBValue($this->f("primary_diagnosis"));
        $this->clinical_notes->SetDBValue($this->f("clinical_notes"));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->statistical_conclusion->SetDBValue($this->f("statistical_conclusion"));
        $this->clinic->SetDBValue($this->f("clinic"));
        $this->patient_patient_id->SetDBValue(trim($this->f("patient_patient_id")));
    }
//End SetValues Method

} //End users_clinic_status_statiDataSource Class @2-FCB6E20C

//Initialize Page @1-1E0DB68C
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
$TemplateFileName = "patient_info.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-ACB9DD4F
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$users_clinic_status_stati = new clsGridusers_clinic_status_stati("", $MainPage);
$MainPage->users_clinic_status_stati = & $users_clinic_status_stati;
$users_clinic_status_stati->Initialize();

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

//Go to destination page @1-328857A7
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    unset($users_clinic_status_stati);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E5805AE7
$users_clinic_status_stati->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B4CCB035
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
unset($users_clinic_status_stati);
unset($Tpl);
//End Unload Page
?>
