<?php

//Include Common Files @1-1E52E873
define("RelativePath", "..");
define("PathToCurrentPage", "/reception/");
define("FileName", "schedule_test.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

class clsRecordresult { //result Class @10-3AFEA74E

//Variables @10-9E315808

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

//Class_Initialize Event @10-A9CFDD41
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
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
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
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->consultant_i_c = new clsControl(ccsTextBox, "consultant_i_c", "Consultant I C", ccsText, "", CCGetRequestParam("consultant_i_c", $Method, NULL), $this);
            $this->l_m_p = new clsControl(ccsTextBox, "l_m_p", "L M P", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("l_m_p", $Method, NULL), $this);
            $this->l_m_p->Required = true;
            $this->clinic_id = new clsControl(ccsListBox, "clinic_id", "Clinic", ccsInteger, "", CCGetRequestParam("clinic_id", $Method, NULL), $this);
            $this->clinic_id->DSType = dsTable;
            $this->clinic_id->DataSource = new clsDBConnection1();
            $this->clinic_id->ds = & $this->clinic_id->DataSource;
            $this->clinic_id->DataSource->SQL = "SELECT * \n" .
"FROM clinic {SQL_Where} {SQL_OrderBy}";
            list($this->clinic_id->BoundColumn, $this->clinic_id->TextColumn, $this->clinic_id->DBFormat) = array("clinic_id", "clinic", "");
            $this->clinic_id->Required = true;
            $this->primary_diagnosis = new clsControl(ccsTextArea, "primary_diagnosis", "Primary Diagnosis", ccsText, "", CCGetRequestParam("primary_diagnosis", $Method, NULL), $this);
            $this->primary_diagnosis->Required = true;
            $this->clinical_notes = new clsControl(ccsTextArea, "clinical_notes", "Clinical Notes", ccsText, "", CCGetRequestParam("clinical_notes", $Method, NULL), $this);
            $this->clinical_notes->Required = true;
            $this->date = new clsControl(ccsTextBox, "date", "Date", ccsDate, array("dd", "/", "mm", "/", "yyyy"), CCGetRequestParam("date", $Method, NULL), $this);
            $this->sup_dept_id = new clsControl(ccsListBox, "sup_dept_id", "Sup Dept", ccsInteger, "", CCGetRequestParam("sup_dept_id", $Method, NULL), $this);
            $this->sup_dept_id->DSType = dsTable;
            $this->sup_dept_id->DataSource = new clsDBConnection1();
            $this->sup_dept_id->ds = & $this->sup_dept_id->DataSource;
            $this->sup_dept_id->DataSource->SQL = "SELECT * \n" .
"FROM sub_dept {SQL_Where} {SQL_OrderBy}";
            list($this->sup_dept_id->BoundColumn, $this->sup_dept_id->TextColumn, $this->sup_dept_id->DBFormat) = array("sub_dept_id", "sub_dept", "");
            $this->amount_to_pay = new clsControl(ccsTextBox, "amount_to_pay", "Amount To Pay", ccsFloat, "", CCGetRequestParam("amount_to_pay", $Method, NULL), $this);
            $this->department_id = new clsControl(ccsListBox, "department_id", "Department", ccsInteger, "", CCGetRequestParam("department_id", $Method, NULL), $this);
            $this->department_id->DSType = dsTable;
            $this->department_id->DataSource = new clsDBConnection1();
            $this->department_id->ds = & $this->department_id->DataSource;
            $this->department_id->DataSource->SQL = "SELECT * \n" .
"FROM department {SQL_Where} {SQL_OrderBy}";
            list($this->department_id->BoundColumn, $this->department_id->TextColumn, $this->department_id->DBFormat) = array("department_id", "department", "");
            $this->department_id->Required = true;
            $this->patient_id = new clsControl(ccsHidden, "patient_id", "Patient Id", ccsInteger, "", CCGetRequestParam("patient_id", $Method, NULL), $this);
            $this->status_id = new clsControl(ccsHidden, "status_id", "status_id", ccsInteger, "", CCGetRequestParam("status_id", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->status_id->Value) && !strlen($this->status_id->Value) && $this->status_id->Value !== false)
                    $this->status_id->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @10-576B2713
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlresult_id"] = CCGetFromGet("result_id", NULL);
    }
//End Initialize Method

//Validate Method @10-91CEE40E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->consultant_i_c->Validate() && $Validation);
        $Validation = ($this->l_m_p->Validate() && $Validation);
        $Validation = ($this->clinic_id->Validate() && $Validation);
        $Validation = ($this->primary_diagnosis->Validate() && $Validation);
        $Validation = ($this->clinical_notes->Validate() && $Validation);
        $Validation = ($this->date->Validate() && $Validation);
        $Validation = ($this->sup_dept_id->Validate() && $Validation);
        $Validation = ($this->amount_to_pay->Validate() && $Validation);
        $Validation = ($this->department_id->Validate() && $Validation);
        $Validation = ($this->patient_id->Validate() && $Validation);
        $Validation = ($this->status_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->consultant_i_c->Errors->Count() == 0);
        $Validation =  $Validation && ($this->l_m_p->Errors->Count() == 0);
        $Validation =  $Validation && ($this->clinic_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->primary_diagnosis->Errors->Count() == 0);
        $Validation =  $Validation && ($this->clinical_notes->Errors->Count() == 0);
        $Validation =  $Validation && ($this->date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sup_dept_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->amount_to_pay->Errors->Count() == 0);
        $Validation =  $Validation && ($this->department_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->patient_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->status_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @10-96504450
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->consultant_i_c->Errors->Count());
        $errors = ($errors || $this->l_m_p->Errors->Count());
        $errors = ($errors || $this->clinic_id->Errors->Count());
        $errors = ($errors || $this->primary_diagnosis->Errors->Count());
        $errors = ($errors || $this->clinical_notes->Errors->Count());
        $errors = ($errors || $this->date->Errors->Count());
        $errors = ($errors || $this->sup_dept_id->Errors->Count());
        $errors = ($errors || $this->amount_to_pay->Errors->Count());
        $errors = ($errors || $this->department_id->Errors->Count());
        $errors = ($errors || $this->patient_id->Errors->Count());
        $errors = ($errors || $this->status_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @10-288F0419
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
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
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

//InsertRow Method @10-F75039E7
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->consultant_i_c->SetValue($this->consultant_i_c->GetValue(true));
        $this->DataSource->l_m_p->SetValue($this->l_m_p->GetValue(true));
        $this->DataSource->clinic_id->SetValue($this->clinic_id->GetValue(true));
        $this->DataSource->primary_diagnosis->SetValue($this->primary_diagnosis->GetValue(true));
        $this->DataSource->clinical_notes->SetValue($this->clinical_notes->GetValue(true));
        $this->DataSource->date->SetValue($this->date->GetValue(true));
        $this->DataSource->sup_dept_id->SetValue($this->sup_dept_id->GetValue(true));
        $this->DataSource->amount_to_pay->SetValue($this->amount_to_pay->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->patient_id->SetValue($this->patient_id->GetValue(true));
        $this->DataSource->status_id->SetValue($this->status_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @10-FE57C856
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->consultant_i_c->SetValue($this->consultant_i_c->GetValue(true));
        $this->DataSource->l_m_p->SetValue($this->l_m_p->GetValue(true));
        $this->DataSource->clinic_id->SetValue($this->clinic_id->GetValue(true));
        $this->DataSource->primary_diagnosis->SetValue($this->primary_diagnosis->GetValue(true));
        $this->DataSource->clinical_notes->SetValue($this->clinical_notes->GetValue(true));
        $this->DataSource->date->SetValue($this->date->GetValue(true));
        $this->DataSource->sup_dept_id->SetValue($this->sup_dept_id->GetValue(true));
        $this->DataSource->amount_to_pay->SetValue($this->amount_to_pay->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->patient_id->SetValue($this->patient_id->GetValue(true));
        $this->DataSource->status_id->SetValue($this->status_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @10-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @10-8F3643E0
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

        $this->clinic_id->Prepare();
        $this->sup_dept_id->Prepare();
        $this->department_id->Prepare();

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
                    $this->consultant_i_c->SetValue($this->DataSource->consultant_i_c->GetValue());
                    $this->l_m_p->SetValue($this->DataSource->l_m_p->GetValue());
                    $this->clinic_id->SetValue($this->DataSource->clinic_id->GetValue());
                    $this->primary_diagnosis->SetValue($this->DataSource->primary_diagnosis->GetValue());
                    $this->clinical_notes->SetValue($this->DataSource->clinical_notes->GetValue());
                    $this->date->SetValue($this->DataSource->date->GetValue());
                    $this->sup_dept_id->SetValue($this->DataSource->sup_dept_id->GetValue());
                    $this->amount_to_pay->SetValue($this->DataSource->amount_to_pay->GetValue());
                    $this->department_id->SetValue($this->DataSource->department_id->GetValue());
                    $this->patient_id->SetValue($this->DataSource->patient_id->GetValue());
                    $this->status_id->SetValue($this->DataSource->status_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->consultant_i_c->Errors->ToString());
            $Error = ComposeStrings($Error, $this->l_m_p->Errors->ToString());
            $Error = ComposeStrings($Error, $this->clinic_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->primary_diagnosis->Errors->ToString());
            $Error = ComposeStrings($Error, $this->clinical_notes->Errors->ToString());
            $Error = ComposeStrings($Error, $this->date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sup_dept_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->amount_to_pay->Errors->ToString());
            $Error = ComposeStrings($Error, $this->department_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->patient_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->status_id->Errors->ToString());
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
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->consultant_i_c->Show();
        $this->l_m_p->Show();
        $this->clinic_id->Show();
        $this->primary_diagnosis->Show();
        $this->clinical_notes->Show();
        $this->date->Show();
        $this->sup_dept_id->Show();
        $this->amount_to_pay->Show();
        $this->department_id->Show();
        $this->patient_id->Show();
        $this->status_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End result Class @10-FCB6E20C

class clsresultDataSource extends clsDBConnection1 {  //resultDataSource Class @10-E277B187

//DataSource Variables @10-556A4D10
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $consultant_i_c;
    public $l_m_p;
    public $clinic_id;
    public $primary_diagnosis;
    public $clinical_notes;
    public $date;
    public $sup_dept_id;
    public $amount_to_pay;
    public $department_id;
    public $patient_id;
    public $status_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-984F7F35
    function clsresultDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record result/Error";
        $this->Initialize();
        $this->consultant_i_c = new clsField("consultant_i_c", ccsText, "");
        
        $this->l_m_p = new clsField("l_m_p", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        
        $this->clinic_id = new clsField("clinic_id", ccsInteger, "");
        
        $this->primary_diagnosis = new clsField("primary_diagnosis", ccsText, "");
        
        $this->clinical_notes = new clsField("clinical_notes", ccsText, "");
        
        $this->date = new clsField("date", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->sup_dept_id = new clsField("sup_dept_id", ccsInteger, "");
        
        $this->amount_to_pay = new clsField("amount_to_pay", ccsFloat, "");
        
        $this->department_id = new clsField("department_id", ccsInteger, "");
        
        $this->patient_id = new clsField("patient_id", ccsInteger, "");
        
        $this->status_id = new clsField("status_id", ccsInteger, "");
        

        $this->InsertFields["consultant_i_c"] = array("Name" => "consultant_i_c", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["l_m_p"] = array("Name" => "l_m_p", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["clinic_id"] = array("Name" => "clinic_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["primary_diagnosis"] = array("Name" => "primary_diagnosis", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["clinical_notes"] = array("Name" => "clinical_notes", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["date"] = array("Name" => "date", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->InsertFields["sup_dept_id"] = array("Name" => "sup_dept_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["amount_to_pay"] = array("Name" => "amount_to_pay", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->InsertFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["patient_id"] = array("Name" => "patient_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["status_id"] = array("Name" => "status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["consultant_i_c"] = array("Name" => "consultant_i_c", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["l_m_p"] = array("Name" => "l_m_p", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["clinic_id"] = array("Name" => "clinic_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["primary_diagnosis"] = array("Name" => "primary_diagnosis", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["clinical_notes"] = array("Name" => "clinical_notes", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["date"] = array("Name" => "date", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["sup_dept_id"] = array("Name" => "sup_dept_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["amount_to_pay"] = array("Name" => "amount_to_pay", "Value" => "", "DataType" => ccsFloat, "OmitIfEmpty" => 1);
        $this->UpdateFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["patient_id"] = array("Name" => "patient_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["status_id"] = array("Name" => "status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @10-7EA7128F
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

//Open Method @10-FDA34939
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

//SetValues Method @10-ACFAB7AD
    function SetValues()
    {
        $this->consultant_i_c->SetDBValue($this->f("consultant_i_c"));
        $this->l_m_p->SetDBValue(trim($this->f("l_m_p")));
        $this->clinic_id->SetDBValue(trim($this->f("clinic_id")));
        $this->primary_diagnosis->SetDBValue($this->f("primary_diagnosis"));
        $this->clinical_notes->SetDBValue($this->f("clinical_notes"));
        $this->date->SetDBValue(trim($this->f("date")));
        $this->sup_dept_id->SetDBValue(trim($this->f("sup_dept_id")));
        $this->amount_to_pay->SetDBValue(trim($this->f("amount_to_pay")));
        $this->department_id->SetDBValue(trim($this->f("department_id")));
        $this->patient_id->SetDBValue(trim($this->f("patient_id")));
        $this->status_id->SetDBValue(trim($this->f("status_id")));
    }
//End SetValues Method

//Insert Method @10-AB4168C8
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["consultant_i_c"]["Value"] = $this->consultant_i_c->GetDBValue(true);
        $this->InsertFields["l_m_p"]["Value"] = $this->l_m_p->GetDBValue(true);
        $this->InsertFields["clinic_id"]["Value"] = $this->clinic_id->GetDBValue(true);
        $this->InsertFields["primary_diagnosis"]["Value"] = $this->primary_diagnosis->GetDBValue(true);
        $this->InsertFields["clinical_notes"]["Value"] = $this->clinical_notes->GetDBValue(true);
        $this->InsertFields["date"]["Value"] = $this->date->GetDBValue(true);
        $this->InsertFields["sup_dept_id"]["Value"] = $this->sup_dept_id->GetDBValue(true);
        $this->InsertFields["amount_to_pay"]["Value"] = $this->amount_to_pay->GetDBValue(true);
        $this->InsertFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->InsertFields["patient_id"]["Value"] = $this->patient_id->GetDBValue(true);
        $this->InsertFields["status_id"]["Value"] = $this->status_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("result", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @10-2E26A772
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["consultant_i_c"]["Value"] = $this->consultant_i_c->GetDBValue(true);
        $this->UpdateFields["l_m_p"]["Value"] = $this->l_m_p->GetDBValue(true);
        $this->UpdateFields["clinic_id"]["Value"] = $this->clinic_id->GetDBValue(true);
        $this->UpdateFields["primary_diagnosis"]["Value"] = $this->primary_diagnosis->GetDBValue(true);
        $this->UpdateFields["clinical_notes"]["Value"] = $this->clinical_notes->GetDBValue(true);
        $this->UpdateFields["date"]["Value"] = $this->date->GetDBValue(true);
        $this->UpdateFields["sup_dept_id"]["Value"] = $this->sup_dept_id->GetDBValue(true);
        $this->UpdateFields["amount_to_pay"]["Value"] = $this->amount_to_pay->GetDBValue(true);
        $this->UpdateFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->UpdateFields["patient_id"]["Value"] = $this->patient_id->GetDBValue(true);
        $this->UpdateFields["status_id"]["Value"] = $this->status_id->GetDBValue(true);
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

//Delete Method @10-8E4CE7C3
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM result";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End resultDataSource Class @10-FCB6E20C

//Include Page implementation @33-B7AA25BF
include_once(RelativePath . "/includes/header_receptionist_st.php");
//End Include Page implementation

//Initialize Page @1-53A2A140
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
$TemplateFileName = "schedule_test.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-8791BA6A
CCSecurityRedirect("1;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-CB55F313
include_once("./schedule_test_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-ABE954A0
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
$result = new clsRecordresult("", $MainPage);
$header_receptionist_st = new clsheader_receptionist_st("../includes/", "header_receptionist_st", $MainPage);
$header_receptionist_st->Initialize();
$MainPage->footer = & $footer;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->result = & $result;
$MainPage->header_receptionist_st = & $header_receptionist_st;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());
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

//Execute Components @1-5E0E3344
$header_receptionist_st->Operations();
$result->Operation();
$footer->Operations();
//End Execute Components

//Go to destination page @1-9899F205
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    unset($result);
    $header_receptionist_st->Class_Terminate();
    unset($header_receptionist_st);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-ABED940D
$footer->Show();
$result->Show();
$header_receptionist_st->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2AF0E584
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
unset($result);
$header_receptionist_st->Class_Terminate();
unset($header_receptionist_st);
unset($Tpl);
//End Unload Page
?>
