<?php

//Include Common Files @1-705F51F0
define("RelativePath", "..");
define("PathToCurrentPage", "/login/");
define("FileName", "index.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-D9317994
include_once(RelativePath . "/includes/header_login.php");
//End Include Page implementation

class clsRecordLogin { //Login Class @5-58926B8F

//Variables @5-9E315808

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

//Class_Initialize Event @5-D5FDB183
    function clsRecordLogin($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record Login/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "Login";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->login1 = new clsControl(ccsTextBox, "login1", "Username", ccsText, "", CCGetRequestParam("login1", $Method, NULL), $this);
            $this->login1->Required = true;
            $this->password = new clsControl(ccsTextBox, "password", "password", ccsText, "", CCGetRequestParam("password", $Method, NULL), $this);
            $this->password->Required = true;
            $this->autoLogin = new clsControl(ccsCheckBox, "autoLogin", "autoLogin", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("autoLogin", $Method, NULL), $this);
            $this->autoLogin->CheckedValue = true;
            $this->autoLogin->UncheckedValue = false;
            $this->Button_DoLogin = new clsButton("Button_DoLogin", $Method, $this);
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->Link1->Page = "#";
            if(!$this->FormSubmitted) {
                if(!is_array($this->autoLogin->Value) && !strlen($this->autoLogin->Value) && $this->autoLogin->Value !== false)
                    $this->autoLogin->SetValue(false);
            }
        }
    }
//End Class_Initialize Event

//Validate Method @5-FA27E083
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->login1->Validate() && $Validation);
        $Validation = ($this->password->Validate() && $Validation);
        $Validation = ($this->autoLogin->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->login1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->autoLogin->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-2BC6C263
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->login1->Errors->Count());
        $errors = ($errors || $this->password->Errors->Count());
        $errors = ($errors || $this->autoLogin->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @5-5AC4CFBE
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
            $this->PressedButton = "Button_DoLogin";
            if($this->Button_DoLogin->Pressed) {
                $this->PressedButton = "Button_DoLogin";
            }
        }
        $Redirect = $FileName;
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoLogin") {
                if(!CCGetEvent($this->Button_DoLogin->CCSEvents, "OnClick", $this->Button_DoLogin)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @5-C3EE21EE
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
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->login1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->autoLogin->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
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

        $this->login1->Show();
        $this->password->Show();
        $this->autoLogin->Show();
        $this->Button_DoLogin->Show();
        $this->Link1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End Login Class @5-FCB6E20C

class clsRecordusers { //users Class @14-9BE1AF6F

//Variables @14-9E315808

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

//Class_Initialize Event @14-C656A286
    function clsRecordusers($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record users/Error";
        $this->DataSource = new clsusersDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "users";
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
            $this->last_name = new clsControl(ccsTextBox, "last_name", "Last Name", ccsText, "", CCGetRequestParam("last_name", $Method, NULL), $this);
            $this->last_name->Required = true;
            $this->middle_name = new clsControl(ccsTextBox, "middle_name", "Middle Name", ccsText, "", CCGetRequestParam("middle_name", $Method, NULL), $this);
            $this->group_id = new clsControl(ccsListBox, "group_id", "Designation", ccsInteger, "", CCGetRequestParam("group_id", $Method, NULL), $this);
            $this->group_id->DSType = dsTable;
            $this->group_id->DataSource = new clsDBConnection1();
            $this->group_id->ds = & $this->group_id->DataSource;
            $this->group_id->DataSource->SQL = "SELECT *, group_id \n" .
"FROM user_group {SQL_Where} {SQL_OrderBy}";
            list($this->group_id->BoundColumn, $this->group_id->TextColumn, $this->group_id->DBFormat) = array("group_id", "group", "");
            $this->group_id->DataSource->wp = new clsSQLParameters();
            $this->group_id->DataSource->wp->Criterion[1] = "( group_id<4 )";
            $this->group_id->DataSource->Where = 
                 $this->group_id->DataSource->wp->Criterion[1];
            $this->group_id->Required = true;
            $this->department_id = new clsControl(ccsListBox, "department_id", "Department", ccsInteger, "", CCGetRequestParam("department_id", $Method, NULL), $this);
            $this->department_id->DSType = dsTable;
            $this->department_id->DataSource = new clsDBConnection1();
            $this->department_id->ds = & $this->department_id->DataSource;
            $this->department_id->DataSource->SQL = "SELECT * \n" .
"FROM department {SQL_Where} {SQL_OrderBy}";
            list($this->department_id->BoundColumn, $this->department_id->TextColumn, $this->department_id->DBFormat) = array("department_id", "department", "");
            $this->title_id = new clsControl(ccsListBox, "title_id", "Title", ccsInteger, "", CCGetRequestParam("title_id", $Method, NULL), $this);
            $this->title_id->DSType = dsTable;
            $this->title_id->DataSource = new clsDBConnection1();
            $this->title_id->ds = & $this->title_id->DataSource;
            $this->title_id->DataSource->SQL = "SELECT * \n" .
"FROM title {SQL_Where} {SQL_OrderBy}";
            list($this->title_id->BoundColumn, $this->title_id->TextColumn, $this->title_id->DBFormat) = array("title_id", "title", "");
            $this->title_id->Required = true;
            $this->first_name = new clsControl(ccsTextBox, "first_name", "First Name", ccsText, "", CCGetRequestParam("first_name", $Method, NULL), $this);
            $this->first_name->Required = true;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->Hidden1 = new clsControl(ccsHidden, "Hidden1", "Hidden1", ccsInteger, "", CCGetRequestParam("Hidden1", $Method, NULL), $this);
            $this->user_id = new clsControl(ccsHidden, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->Hidden1->Value) && !strlen($this->Hidden1->Value) && $this->Hidden1->Value !== false)
                    $this->Hidden1->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @14-910FCC06
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["postuser_id"] = CCGetFromPost("user_id", NULL);
    }
//End Initialize Method

//Validate Method @14-AFAD81D8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->last_name->Validate() && $Validation);
        $Validation = ($this->middle_name->Validate() && $Validation);
        $Validation = ($this->group_id->Validate() && $Validation);
        $Validation = ($this->department_id->Validate() && $Validation);
        $Validation = ($this->title_id->Validate() && $Validation);
        $Validation = ($this->first_name->Validate() && $Validation);
        $Validation = ($this->Hidden1->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->last_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->middle_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->group_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->department_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->title_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->first_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Hidden1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @14-214E7556
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->last_name->Errors->Count());
        $errors = ($errors || $this->middle_name->Errors->Count());
        $errors = ($errors || $this->group_id->Errors->Count());
        $errors = ($errors || $this->department_id->Errors->Count());
        $errors = ($errors || $this->title_id->Errors->Count());
        $errors = ($errors || $this->first_name->Errors->Count());
        $errors = ($errors || $this->Hidden1->Errors->Count());
        $errors = ($errors || $this->user_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @14-D94A35C0
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
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "welcome.php" . "?" . CCGetQueryString("All", array("ccsForm"));
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
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

//InsertRow Method @14-CC7D4B0C
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->last_name->SetValue($this->last_name->GetValue(true));
        $this->DataSource->middle_name->SetValue($this->middle_name->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->title_id->SetValue($this->title_id->GetValue(true));
        $this->DataSource->first_name->SetValue($this->first_name->GetValue(true));
        $this->DataSource->Hidden1->SetValue($this->Hidden1->GetValue(true));
        $this->DataSource->user_id->SetValue($this->user_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @14-4E801A10
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->last_name->SetValue($this->last_name->GetValue(true));
        $this->DataSource->middle_name->SetValue($this->middle_name->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->title_id->SetValue($this->title_id->GetValue(true));
        $this->DataSource->first_name->SetValue($this->first_name->GetValue(true));
        $this->DataSource->Hidden1->SetValue($this->Hidden1->GetValue(true));
        $this->DataSource->user_id->SetValue($this->user_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @14-942EDF60
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

        $this->group_id->Prepare();
        $this->department_id->Prepare();
        $this->title_id->Prepare();

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
                    $this->last_name->SetValue($this->DataSource->last_name->GetValue());
                    $this->middle_name->SetValue($this->DataSource->middle_name->GetValue());
                    $this->group_id->SetValue($this->DataSource->group_id->GetValue());
                    $this->department_id->SetValue($this->DataSource->department_id->GetValue());
                    $this->title_id->SetValue($this->DataSource->title_id->GetValue());
                    $this->first_name->SetValue($this->DataSource->first_name->GetValue());
                    $this->Hidden1->SetValue($this->DataSource->Hidden1->GetValue());
                    $this->user_id->SetValue($this->DataSource->user_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->last_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->middle_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->group_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->department_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->title_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->first_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Hidden1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        if($this->FormSubmitted || CCGetFromGet("ccsForm")) {
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        } else {
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("All", ""), "ccsForm", $CCSForm);
        }
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->last_name->Show();
        $this->middle_name->Show();
        $this->group_id->Show();
        $this->department_id->Show();
        $this->title_id->Show();
        $this->first_name->Show();
        $this->Button_Insert->Show();
        $this->Button1->Show();
        $this->Hidden1->Show();
        $this->user_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End users Class @14-FCB6E20C

class clsusersDataSource extends clsDBConnection1 {  //usersDataSource Class @14-DF0C03ED

//DataSource Variables @14-6DD57D0C
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
    public $last_name;
    public $middle_name;
    public $group_id;
    public $department_id;
    public $title_id;
    public $first_name;
    public $Hidden1;
    public $user_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @14-FEC2B779
    function clsusersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record users/Error";
        $this->Initialize();
        $this->last_name = new clsField("last_name", ccsText, "");
        
        $this->middle_name = new clsField("middle_name", ccsText, "");
        
        $this->group_id = new clsField("group_id", ccsInteger, "");
        
        $this->department_id = new clsField("department_id", ccsInteger, "");
        
        $this->title_id = new clsField("title_id", ccsInteger, "");
        
        $this->first_name = new clsField("first_name", ccsText, "");
        
        $this->Hidden1 = new clsField("Hidden1", ccsInteger, "");
        
        $this->user_id = new clsField("user_id", ccsInteger, "");
        

        $this->InsertFields["last_name"] = array("Name" => "last_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["middle_name"] = array("Name" => "middle_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["title_id"] = array("Name" => "title_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["first_name"] = array("Name" => "first_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["user_status_id"] = array("Name" => "user_status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["user_id"] = array("Name" => "user_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["last_name"] = array("Name" => "last_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["middle_name"] = array("Name" => "middle_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["title_id"] = array("Name" => "title_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["first_name"] = array("Name" => "first_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["user_status_id"] = array("Name" => "user_status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["user_id"] = array("Name" => "user_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @14-6517D5E2
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "postuser_id", ccsInteger, "", "", $this->Parameters["postuser_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @14-984AB44B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *, user_id \n\n" .
        "FROM users {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @14-C373C9C4
    function SetValues()
    {
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->middle_name->SetDBValue($this->f("middle_name"));
        $this->group_id->SetDBValue(trim($this->f("group_id")));
        $this->department_id->SetDBValue(trim($this->f("department_id")));
        $this->title_id->SetDBValue(trim($this->f("title_id")));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->Hidden1->SetDBValue(trim($this->f("user_status_id")));
        $this->user_id->SetDBValue(trim($this->f("user_id")));
    }
//End SetValues Method

//Insert Method @14-47D670EC
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["last_name"]["Value"] = $this->last_name->GetDBValue(true);
        $this->InsertFields["middle_name"]["Value"] = $this->middle_name->GetDBValue(true);
        $this->InsertFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->InsertFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->InsertFields["title_id"]["Value"] = $this->title_id->GetDBValue(true);
        $this->InsertFields["first_name"]["Value"] = $this->first_name->GetDBValue(true);
        $this->InsertFields["user_status_id"]["Value"] = $this->Hidden1->GetDBValue(true);
        $this->InsertFields["user_id"]["Value"] = $this->user_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("users", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @14-A84644DB
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["last_name"]["Value"] = $this->last_name->GetDBValue(true);
        $this->UpdateFields["middle_name"]["Value"] = $this->middle_name->GetDBValue(true);
        $this->UpdateFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->UpdateFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->UpdateFields["title_id"]["Value"] = $this->title_id->GetDBValue(true);
        $this->UpdateFields["first_name"]["Value"] = $this->first_name->GetDBValue(true);
        $this->UpdateFields["user_status_id"]["Value"] = $this->Hidden1->GetDBValue(true);
        $this->UpdateFields["user_id"]["Value"] = $this->user_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("users", $this->UpdateFields, $this);
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

} //End usersDataSource Class @14-FCB6E20C

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

//Include events file @1-B7D86394
include_once("./index_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-2A7670DD
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_login = new clsheader_login("../includes/", "header_login", $MainPage);
$header_login->Initialize();
$Login = new clsRecordLogin("", $MainPage);
$users = new clsRecordusers("", $MainPage);
$MainPage->footer = & $footer;
$MainPage->header_login = & $header_login;
$MainPage->Login = & $Login;
$MainPage->users = & $users;
$users->Initialize();

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

//Execute Components @1-591F1357
$users->Operation();
$Login->Operation();
$header_login->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-3B3C1DBF
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_login->Class_Terminate();
    unset($header_login);
    unset($Login);
    unset($users);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-60374958
$footer->Show();
$header_login->Show();
$Login->Show();
$users->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-2C24A92C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
$header_login->Class_Terminate();
unset($header_login);
unset($Login);
unset($users);
unset($Tpl);
//End Unload Page
?>
