<?php

//Include Common Files @1-9827ED95
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
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

//Include Page implementation @4-739D6FF7
include_once(RelativePath . "/includes/header_admin.php");
//End Include Page implementation

class clsRecordusers { //users Class @10-9BE1AF6F

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

//Class_Initialize Event @10-7A524D89
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
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->user_login = new clsControl(ccsTextBox, "user_login", "Username", ccsText, "", CCGetRequestParam("user_login", $Method, NULL), $this);
            $this->user_login->Required = true;
            $this->user_password = new clsControl(ccsTextBox, "user_password", "Password", ccsText, "", CCGetRequestParam("user_password", $Method, NULL), $this);
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
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->Hidden1 = new clsControl(ccsHidden, "Hidden1", "Hidden1", ccsInteger, "", CCGetRequestParam("Hidden1", $Method, NULL), $this);
            if(!$this->FormSubmitted) {
                if(!is_array($this->Hidden1->Value) && !strlen($this->Hidden1->Value) && $this->Hidden1->Value !== false)
                    $this->Hidden1->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @10-53A359F1
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urluser_id"] = CCGetFromGet("user_id", NULL);
    }
//End Initialize Method

//Validate Method @10-99367806
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->user_login->SetValue($this->user_login->GetValue());
        if(CCDLookUp("COUNT(*)", "users", "user_login=" . $this->DataSource->ToSQL($this->DataSource->user_login->GetDBValue(), $this->DataSource->user_login->DataType) . $Where, $this->DataSource) > 0)
            $this->user_login->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Username"));
        $Validation = ($this->user_login->Validate() && $Validation);
        $Validation = ($this->user_password->Validate() && $Validation);
        $Validation = ($this->last_name->Validate() && $Validation);
        $Validation = ($this->middle_name->Validate() && $Validation);
        $Validation = ($this->group_id->Validate() && $Validation);
        $Validation = ($this->department_id->Validate() && $Validation);
        $Validation = ($this->title_id->Validate() && $Validation);
        $Validation = ($this->first_name->Validate() && $Validation);
        $Validation = ($this->Hidden1->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->user_login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->last_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->middle_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->group_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->department_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->title_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->first_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->Hidden1->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @10-C4EC4445
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->user_login->Errors->Count());
        $errors = ($errors || $this->user_password->Errors->Count());
        $errors = ($errors || $this->last_name->Errors->Count());
        $errors = ($errors || $this->middle_name->Errors->Count());
        $errors = ($errors || $this->group_id->Errors->Count());
        $errors = ($errors || $this->department_id->Errors->Count());
        $errors = ($errors || $this->title_id->Errors->Count());
        $errors = ($errors || $this->first_name->Errors->Count());
        $errors = ($errors || $this->Hidden1->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @10-E6B2C379
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

//InsertRow Method @10-0F17FB34
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->user_login->SetValue($this->user_login->GetValue(true));
        $this->DataSource->user_password->SetValue($this->user_password->GetValue(true));
        $this->DataSource->last_name->SetValue($this->last_name->GetValue(true));
        $this->DataSource->middle_name->SetValue($this->middle_name->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->title_id->SetValue($this->title_id->GetValue(true));
        $this->DataSource->first_name->SetValue($this->first_name->GetValue(true));
        $this->DataSource->Hidden1->SetValue($this->Hidden1->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @10-6D838AF8
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->user_login->SetValue($this->user_login->GetValue(true));
        $this->DataSource->user_password->SetValue($this->user_password->GetValue(true));
        $this->DataSource->last_name->SetValue($this->last_name->GetValue(true));
        $this->DataSource->middle_name->SetValue($this->middle_name->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->department_id->SetValue($this->department_id->GetValue(true));
        $this->DataSource->title_id->SetValue($this->title_id->GetValue(true));
        $this->DataSource->first_name->SetValue($this->first_name->GetValue(true));
        $this->DataSource->Hidden1->SetValue($this->Hidden1->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @10-36FF1767
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
                    $this->user_login->SetValue($this->DataSource->user_login->GetValue());
                    $this->user_password->SetValue($this->DataSource->user_password->GetValue());
                    $this->last_name->SetValue($this->DataSource->last_name->GetValue());
                    $this->middle_name->SetValue($this->DataSource->middle_name->GetValue());
                    $this->group_id->SetValue($this->DataSource->group_id->GetValue());
                    $this->department_id->SetValue($this->DataSource->department_id->GetValue());
                    $this->title_id->SetValue($this->DataSource->title_id->GetValue());
                    $this->first_name->SetValue($this->DataSource->first_name->GetValue());
                    $this->Hidden1->SetValue($this->DataSource->Hidden1->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->user_login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->last_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->middle_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->group_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->department_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->title_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->first_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Hidden1->Errors->ToString());
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
        $this->user_login->Show();
        $this->user_password->Show();
        $this->last_name->Show();
        $this->middle_name->Show();
        $this->group_id->Show();
        $this->department_id->Show();
        $this->title_id->Show();
        $this->first_name->Show();
        $this->Button1->Show();
        $this->Hidden1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End users Class @10-FCB6E20C

class clsusersDataSource extends clsDBConnection1 {  //usersDataSource Class @10-DF0C03ED

//DataSource Variables @10-E4BF48B7
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
    public $user_login;
    public $user_password;
    public $last_name;
    public $middle_name;
    public $group_id;
    public $department_id;
    public $title_id;
    public $first_name;
    public $Hidden1;
//End DataSource Variables

//DataSourceClass_Initialize Event @10-AF5EC4C6
    function clsusersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record users/Error";
        $this->Initialize();
        $this->user_login = new clsField("user_login", ccsText, "");
        
        $this->user_password = new clsField("user_password", ccsText, "");
        
        $this->last_name = new clsField("last_name", ccsText, "");
        
        $this->middle_name = new clsField("middle_name", ccsText, "");
        
        $this->group_id = new clsField("group_id", ccsInteger, "");
        
        $this->department_id = new clsField("department_id", ccsInteger, "");
        
        $this->title_id = new clsField("title_id", ccsInteger, "");
        
        $this->first_name = new clsField("first_name", ccsText, "");
        
        $this->Hidden1 = new clsField("Hidden1", ccsInteger, "");
        

        $this->InsertFields["user_login"] = array("Name" => "user_login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["user_password"] = array("Name" => "user_password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["last_name"] = array("Name" => "last_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["middle_name"] = array("Name" => "middle_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["title_id"] = array("Name" => "title_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["first_name"] = array("Name" => "first_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["user_status_id"] = array("Name" => "user_status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["user_login"] = array("Name" => "user_login", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["user_password"] = array("Name" => "user_password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["last_name"] = array("Name" => "last_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["middle_name"] = array("Name" => "middle_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["department_id"] = array("Name" => "department_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["title_id"] = array("Name" => "title_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["first_name"] = array("Name" => "first_name", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["user_status_id"] = array("Name" => "user_status_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @10-B49E291C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urluser_id", ccsInteger, "", "", $this->Parameters["urluser_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @10-B071412E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM users {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @10-78CC7A0D
    function SetValues()
    {
        $this->user_login->SetDBValue($this->f("user_login"));
        $this->user_password->SetDBValue($this->f("user_password"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->middle_name->SetDBValue($this->f("middle_name"));
        $this->group_id->SetDBValue(trim($this->f("group_id")));
        $this->department_id->SetDBValue(trim($this->f("department_id")));
        $this->title_id->SetDBValue(trim($this->f("title_id")));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->Hidden1->SetDBValue(trim($this->f("user_status_id")));
    }
//End SetValues Method

//Insert Method @10-F4D43BD3
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["user_login"]["Value"] = $this->user_login->GetDBValue(true);
        $this->InsertFields["user_password"]["Value"] = $this->user_password->GetDBValue(true);
        $this->InsertFields["last_name"]["Value"] = $this->last_name->GetDBValue(true);
        $this->InsertFields["middle_name"]["Value"] = $this->middle_name->GetDBValue(true);
        $this->InsertFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->InsertFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->InsertFields["title_id"]["Value"] = $this->title_id->GetDBValue(true);
        $this->InsertFields["first_name"]["Value"] = $this->first_name->GetDBValue(true);
        $this->InsertFields["user_status_id"]["Value"] = $this->Hidden1->GetDBValue(true);
        $this->SQL = CCBuildInsert("users", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @10-114990AC
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["user_login"]["Value"] = $this->user_login->GetDBValue(true);
        $this->UpdateFields["user_password"]["Value"] = $this->user_password->GetDBValue(true);
        $this->UpdateFields["last_name"]["Value"] = $this->last_name->GetDBValue(true);
        $this->UpdateFields["middle_name"]["Value"] = $this->middle_name->GetDBValue(true);
        $this->UpdateFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->UpdateFields["department_id"]["Value"] = $this->department_id->GetDBValue(true);
        $this->UpdateFields["title_id"]["Value"] = $this->title_id->GetDBValue(true);
        $this->UpdateFields["first_name"]["Value"] = $this->first_name->GetDBValue(true);
        $this->UpdateFields["user_status_id"]["Value"] = $this->Hidden1->GetDBValue(true);
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

} //End usersDataSource Class @10-FCB6E20C

class clsGridtitle_user_group_departme { //title_user_group_departme class @31-CEA1628F

//Variables @31-6E1D47F8

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
    public $Sorter_f_group_1;
    public $Sorter_first_name;
    public $Sorter_user_status;
//End Variables

//Class_Initialize Event @31-CC47C1FF
    function clsGridtitle_user_group_departme($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "title_user_group_departme";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid title_user_group_departme";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clstitle_user_group_departmeDataSource($this);
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
        $this->SorterName = CCGetParam("title_user_group_departmeOrder", "");
        $this->SorterDirection = CCGetParam("title_user_group_departmeDir", "");

        $this->f_group_1 = new clsControl(ccsLabel, "f_group_1", "f_group_1", ccsText, "", CCGetRequestParam("f_group_1", ccsGet, NULL), $this);
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet, NULL), $this);
        $this->user_status = new clsControl(ccsLink, "user_status", "user_status", ccsText, "", CCGetRequestParam("user_status", ccsGet, NULL), $this);
        $this->user_status->HTML = true;
        $this->user_status->Page = "activate_users.php";
        $this->department = new clsControl(ccsLabel, "department", "department", ccsText, "", CCGetRequestParam("department", ccsGet, NULL), $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->first_name = new clsControl(ccsLabel, "first_name", "first_name", ccsText, "", CCGetRequestParam("first_name", ccsGet, NULL), $this);
        $this->middle_name = new clsControl(ccsLabel, "middle_name", "middle_name", ccsText, "", CCGetRequestParam("middle_name", ccsGet, NULL), $this);
        $this->last_name = new clsControl(ccsLabel, "last_name", "last_name", ccsText, "", CCGetRequestParam("last_name", ccsGet, NULL), $this);
        $this->myid = new clsControl(ccsHidden, "myid", "myid", ccsInteger, "", CCGetRequestParam("myid", ccsGet, NULL), $this);
        $this->Sorter_f_group_1 = new clsSorter($this->ComponentName, "Sorter_f_group_1", $FileName, $this);
        $this->Sorter_first_name = new clsSorter($this->ComponentName, "Sorter_first_name", $FileName, $this);
        $this->Sorter_user_status = new clsSorter($this->ComponentName, "Sorter_user_status", $FileName, $this);
    }
//End Class_Initialize Event

//Initialize Method @31-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @31-56E4751F
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
            $this->ControlsVisible["f_group_1"] = $this->f_group_1->Visible;
            $this->ControlsVisible["title"] = $this->title->Visible;
            $this->ControlsVisible["user_status"] = $this->user_status->Visible;
            $this->ControlsVisible["department"] = $this->department->Visible;
            $this->ControlsVisible["Label1"] = $this->Label1->Visible;
            $this->ControlsVisible["first_name"] = $this->first_name->Visible;
            $this->ControlsVisible["middle_name"] = $this->middle_name->Visible;
            $this->ControlsVisible["last_name"] = $this->last_name->Visible;
            $this->ControlsVisible["myid"] = $this->myid->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                if(!is_array($this->Label1->Value) && !strlen($this->Label1->Value) && $this->Label1->Value !== false)
                    $this->Label1->SetText('-');
                $this->f_group_1->SetValue($this->DataSource->f_group_1->GetValue());
                $this->title->SetValue($this->DataSource->title->GetValue());
                $this->user_status->SetValue($this->DataSource->user_status->GetValue());
                $this->user_status->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->user_status->Parameters = CCAddParam($this->user_status->Parameters, "uid", $this->DataSource->f("user_id"));
                $this->department->SetValue($this->DataSource->department->GetValue());
                $this->first_name->SetValue($this->DataSource->first_name->GetValue());
                $this->middle_name->SetValue($this->DataSource->middle_name->GetValue());
                $this->last_name->SetValue($this->DataSource->last_name->GetValue());
                $this->myid->SetValue($this->DataSource->myid->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->f_group_1->Show();
                $this->title->Show();
                $this->user_status->Show();
                $this->department->Show();
                $this->Label1->Show();
                $this->first_name->Show();
                $this->middle_name->Show();
                $this->last_name->Show();
                $this->myid->Show();
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
        $this->Sorter_f_group_1->Show();
        $this->Sorter_first_name->Show();
        $this->Sorter_user_status->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @31-0FA1BFB3
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->f_group_1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->title->Errors->ToString());
        $errors = ComposeStrings($errors, $this->user_status->Errors->ToString());
        $errors = ComposeStrings($errors, $this->department->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->first_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->middle_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->last_name->Errors->ToString());
        $errors = ComposeStrings($errors, $this->myid->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End title_user_group_departme Class @31-FCB6E20C

class clstitle_user_group_departmeDataSource extends clsDBConnection1 {  //title_user_group_departmeDataSource Class @31-25DAE999

//DataSource Variables @31-01B958CF
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $f_group_1;
    public $title;
    public $user_status;
    public $department;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $myid;
//End DataSource Variables

//DataSourceClass_Initialize Event @31-0DAC0FFF
    function clstitle_user_group_departmeDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid title_user_group_departme";
        $this->Initialize();
        $this->f_group_1 = new clsField("f_group_1", ccsText, "");
        
        $this->title = new clsField("title", ccsText, "");
        
        $this->user_status = new clsField("user_status", ccsText, "");
        
        $this->department = new clsField("department", ccsText, "");
        
        $this->first_name = new clsField("first_name", ccsText, "");
        
        $this->middle_name = new clsField("middle_name", ccsText, "");
        
        $this->last_name = new clsField("last_name", ccsText, "");
        
        $this->myid = new clsField("myid", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @31-98D1DB26
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "first_name";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_f_group_1" => array("`group`", ""), 
            "Sorter_first_name" => array("first_name", ""), 
            "Sorter_user_status" => array("user_status", "")));
    }
//End SetOrder Method

//Prepare Method @31-308FB5F1
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->AddParameter("2", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->AddParameter("3", "urls_keyword", ccsText, "", "", $this->Parameters["urls_keyword"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "users.first_name", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "users.last_name", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "department.department", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->Where = $this->wp->opOR(
             true, $this->wp->opOR(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]);
    }
//End Prepare Method

//Open Method @31-20478CCC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM user_status RIGHT JOIN (((users LEFT JOIN department ON\n\n" .
        "users.department_id = department.department_id) INNER JOIN user_group ON\n\n" .
        "users.group_id = user_group.group_id) LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "user_status.user_status_id = users.user_status_id";
        $this->SQL = "SELECT user_id, first_name, last_name, middle_name, department.*, title.*, user_status.*, user_group.* \n\n" .
        "FROM user_status RIGHT JOIN (((users LEFT JOIN department ON\n\n" .
        "users.department_id = department.department_id) INNER JOIN user_group ON\n\n" .
        "users.group_id = user_group.group_id) LEFT JOIN title ON\n\n" .
        "users.title_id = title.title_id) ON\n\n" .
        "user_status.user_status_id = users.user_status_id {SQL_Where} {SQL_OrderBy}";
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

//SetValues Method @31-FEE3F47D
    function SetValues()
    {
        $this->f_group_1->SetDBValue($this->f("group"));
        $this->title->SetDBValue($this->f("title"));
        $this->user_status->SetDBValue($this->f("user_status"));
        $this->department->SetDBValue($this->f("department"));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->middle_name->SetDBValue($this->f("middle_name"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->myid->SetDBValue(trim($this->f("user_id")));
    }
//End SetValues Method

} //End title_user_group_departmeDataSource Class @31-FCB6E20C

class clsRecordtitle_user_group_departme1 { //title_user_group_departme1 Class @71-EF6B6781

//Variables @71-9E315808

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

//Class_Initialize Event @71-FC8A29CE
    function clsRecordtitle_user_group_departme1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record title_user_group_departme1/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "title_user_group_departme1";
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

//Validate Method @71-A144A629
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

//CheckErrors Method @71-D6729123
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_keyword->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @71-670B96B7
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

//Show Method @71-0BB4DF41
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

} //End title_user_group_departme1 Class @71-FCB6E20C

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

//Authenticate User @1-0D352854
CCSecurityRedirect("4", "../access_denied.php");
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

//Initialize Objects @1-D702ED54
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_admin = new clsheader_admin("../includes/", "header_admin", $MainPage);
$header_admin->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$users = new clsRecordusers("", $MainPage);
$title_user_group_departme = new clsGridtitle_user_group_departme("", $MainPage);
$title_user_group_departme1 = new clsRecordtitle_user_group_departme1("", $MainPage);
$MainPage->footer = & $footer;
$MainPage->header_admin = & $header_admin;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->users = & $users;
$MainPage->title_user_group_departme = & $title_user_group_departme;
$MainPage->title_user_group_departme1 = & $title_user_group_departme1;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());
$users->Initialize();
$title_user_group_departme->Initialize();

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

//Execute Components @1-6BE460C4
$title_user_group_departme1->Operation();
$users->Operation();
$header_admin->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-1E5C9509
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_admin->Class_Terminate();
    unset($header_admin);
    unset($users);
    unset($title_user_group_departme);
    unset($title_user_group_departme1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4715B4F3
$footer->Show();
$header_admin->Show();
$users->Show();
$title_user_group_departme->Show();
$title_user_group_departme1->Show();
$Label1->Show();
$Label2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C459CEE9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
$header_admin->Class_Terminate();
unset($header_admin);
unset($users);
unset($title_user_group_departme);
unset($title_user_group_departme1);
unset($Tpl);
//End Unload Page
?>
