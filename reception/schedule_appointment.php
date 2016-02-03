<?php

//Include Common Files @1-FB13F966
define("RelativePath", "..");
define("PathToCurrentPage", "/reception/");
define("FileName", "schedule_appointment.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
include_once(RelativePath . "/CalendarNavigator.php");
//End Include Common Files

//Include Page implementation @3-9C963C63
include_once(RelativePath . "/includes/footer.php");
//End Include Page implementation

//Include Page implementation @4-83F11AF0
include_once(RelativePath . "/includes/header_receptionist_sa.php");
//End Include Page implementation

class clsRecordresult { //result Class @12-3AFEA74E

//Variables @12-9E315808

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

//Class_Initialize Event @12-EBD6DB9C
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
            $this->appointment_date = new clsControl(ccsTextBox, "appointment_date", "Appointment Date", ccsDate, array("LongDate"), CCGetRequestParam("appointment_date", $Method, NULL), $this);
            $this->appointment_date->Required = true;
            $this->appointment_time = new clsControl(ccsTextBox, "appointment_time", "Appointment Time", ccsDate, array("h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("appointment_time", $Method, NULL), $this);
            $this->doctor_name = new clsControl(ccsListBox, "doctor_name", "Doctor's Name", ccsInteger, "", CCGetRequestParam("doctor_name", $Method, NULL), $this);
            $this->doctor_name->DSType = dsTable;
            $this->doctor_name->DataSource = new clsDBConnection1();
            $this->doctor_name->ds = & $this->doctor_name->DataSource;
            $this->doctor_name->DataSource->SQL = "SELECT user_id, concat_ws(\" \",first_name, last_name) AS docname \n" .
"FROM users {SQL_Where} {SQL_OrderBy}";
            list($this->doctor_name->BoundColumn, $this->doctor_name->TextColumn, $this->doctor_name->DBFormat) = array("user_id", "docname", "");
            $this->doctor_name->DataSource->Parameters["urldepartment_id"] = CCGetFromGet("department_id", NULL);
            $this->doctor_name->DataSource->wp = new clsSQLParameters();
            $this->doctor_name->DataSource->wp->AddParameter("2", "urldepartment_id", ccsInteger, "", "", $this->doctor_name->DataSource->Parameters["urldepartment_id"], "", false);
            $this->doctor_name->DataSource->wp->Criterion[1] = "( group_id=2 )";
            $this->doctor_name->DataSource->wp->Criterion[2] = $this->doctor_name->DataSource->wp->Operation(opEqual, "department_id", $this->doctor_name->DataSource->wp->GetDBValue("2"), $this->doctor_name->DataSource->ToSQL($this->doctor_name->DataSource->wp->GetDBValue("2"), ccsInteger),false);
            $this->doctor_name->DataSource->Where = $this->doctor_name->DataSource->wp->opAND(
                 false, 
                 $this->doctor_name->DataSource->wp->Criterion[1], 
                 $this->doctor_name->DataSource->wp->Criterion[2]);
            if(!$this->FormSubmitted) {
                if(!is_array($this->appointment_time->Value) && !strlen($this->appointment_time->Value) && $this->appointment_time->Value !== false)
                    $this->appointment_time->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @12-576B2713
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlresult_id"] = CCGetFromGet("result_id", NULL);
    }
//End Initialize Method

//Validate Method @12-E0A8525D
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->appointment_date->Validate() && $Validation);
        $Validation = ($this->appointment_time->Validate() && $Validation);
        $Validation = ($this->doctor_name->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->appointment_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->appointment_time->Errors->Count() == 0);
        $Validation =  $Validation && ($this->doctor_name->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @12-CEDEDEDC
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->appointment_date->Errors->Count());
        $errors = ($errors || $this->appointment_time->Errors->Count());
        $errors = ($errors || $this->doctor_name->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @12-517B5C36
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

//UpdateRow Method @12-3843F9C1
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->appointment_date->SetValue($this->appointment_date->GetValue(true));
        $this->DataSource->appointment_time->SetValue($this->appointment_time->GetValue(true));
        $this->DataSource->doctor_name->SetValue($this->doctor_name->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @12-3A8BD984
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

        $this->doctor_name->Prepare();

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
                    $this->appointment_date->SetValue($this->DataSource->appointment_date->GetValue());
                    $this->appointment_time->SetValue($this->DataSource->appointment_time->GetValue());
                    $this->doctor_name->SetValue($this->DataSource->doctor_name->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->appointment_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->appointment_time->Errors->ToString());
            $Error = ComposeStrings($Error, $this->doctor_name->Errors->ToString());
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
        $this->appointment_date->Show();
        $this->appointment_time->Show();
        $this->doctor_name->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End result Class @12-FCB6E20C

class clsresultDataSource extends clsDBConnection1 {  //resultDataSource Class @12-E277B187

//DataSource Variables @12-5D691771
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
    public $appointment_date;
    public $appointment_time;
    public $doctor_name;
//End DataSource Variables

//DataSourceClass_Initialize Event @12-A67E140C
    function clsresultDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record result/Error";
        $this->Initialize();
        $this->appointment_date = new clsField("appointment_date", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        
        $this->appointment_time = new clsField("appointment_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        
        $this->doctor_name = new clsField("doctor_name", ccsInteger, "");
        

        $this->UpdateFields["appointment_date"] = array("Name" => "appointment_date", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["appointment_time"] = array("Name" => "appointment_time", "Value" => "", "DataType" => ccsDate, "OmitIfEmpty" => 1);
        $this->UpdateFields["user_id"] = array("Name" => "user_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @12-7EA7128F
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

//Open Method @12-FDA34939
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

//SetValues Method @12-C0FEDF8E
    function SetValues()
    {
        $this->appointment_date->SetDBValue(trim($this->f("appointment_date")));
        $this->appointment_time->SetDBValue(trim($this->f("appointment_time")));
        $this->doctor_name->SetDBValue(trim($this->f("user_id")));
    }
//End SetValues Method

//Update Method @12-DAE3FF5B
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["appointment_date"]["Value"] = $this->appointment_date->GetDBValue(true);
        $this->UpdateFields["appointment_time"]["Value"] = $this->appointment_time->GetDBValue(true);
        $this->UpdateFields["user_id"]["Value"] = $this->doctor_name->GetDBValue(true);
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

} //End resultDataSource Class @12-FCB6E20C

//result_users clsEvent @35-6C610CDA
class clsEventresult_users {
    public $_Time;
    public $EventTime;
    public $EventDescription;

}
//End result_users clsEvent

class clsCalendarresult_users { //result_users Class @35-4B61F8E1

//result_users Variables @35-E247CE17

    public $ComponentType = "Calendar";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $DataSource;
    public $ds;
    public $Type;
    //Calendar variables
    public $CurrentDate;
    public $CurrentProcessingDate;
    public $NextProcessingDate;
    public $PrevProcessingDate;
    public $CalendarStyles = array();
    public $CurrentStyle;
    public $FirstWeekDay;
    public $Now;
    public $IsCurrentMonth;
    public $MonthsInRow;
    public $CCSEvents = array();
    public $CCSEventResult;
    public $Parent;
    public $StartDate;
    public $EndDate;
    public $MonthsCount;
    public $FirstProcessingDate;
    public $LastProcessingDate;
    public $Attributes;
//End result_users Variables

//result_users Class_Initialize Event @35-C1ECA1D7
    function clsCalendarresult_users($RelativePath, & $Parent) {
        global $CCSLocales;
        global $DefaultDateFormat;
        global $FileName;
        global $Redirect;
        $this->ComponentName = "result_users";
        $this->Type = "1";
        $this->Visible = True;
        $this->RelativePath = $RelativePath;
        $this->Parent = & $Parent;
        $this->Errors = new clsErrors();
        $CCSForm = CCGetFromGet("ccsForm", "");
        if ($CCSForm == $this->ComponentName) {
            $Redirect = FileName . "?" .  CCGetQueryString("All", array("ccsForm"));
            $this->Visible = false;
            return;
        }
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsresult_usersDataSource($this);
        $this->ds = & $this->DataSource;
        $this->FirstWeekDay = $CCSLocales->GetFormatInfo("FirstWeekDay");
        $this->MonthsInRow = 1;
        $this->MonthsCount = 1;


        $this->DayOfWeek = new clsControl(ccsLabel, "DayOfWeek", "DayOfWeek", ccsDate, array("dddd"), CCGetRequestParam("DayOfWeek", ccsGet, NULL), $this);
        $this->DayNumber = new clsControl(ccsLabel, "DayNumber", "DayNumber", ccsDate, array("d"), CCGetRequestParam("DayNumber", ccsGet, NULL), $this);
        $this->EventTime = new clsControl(ccsLabel, "EventTime", "EventTime", ccsDate, array("h", ":", "nn", " ", "AM/PM"), CCGetRequestParam("EventTime", ccsGet, NULL), $this);
        $this->EventDescription = new clsControl(ccsLabel, "EventDescription", "EventDescription", ccsText, "", CCGetRequestParam("EventDescription", ccsGet, NULL), $this);
        $this->EventDescription->HTML = true;
        $this->Navigator = new clsCalendarNavigator($this->ComponentName, "Navigator", $this->Type, 10, $this);
        $this->Now = CCGetDateArray();
        $this->CalendarStyles["WeekdayName"] = "";
        $this->CalendarStyles["WeekendName"] = "";
        $this->CalendarStyles["Day"] = "";
        $this->CalendarStyles["Weekend"] = "";
        $this->CalendarStyles["Today"] = "";
        $this->CalendarStyles["WeekendToday"] = "";
        $this->CalendarStyles["OtherMonthDay"] = "";
        $this->CalendarStyles["OtherMonthToday"] = "";
        $this->CalendarStyles["OtherMonthWeekend"] = "";
        $this->CalendarStyles["OtherMonthWeekendToday"] = "";
    }
//End result_users Class_Initialize Event

//Initialize Method @35-24A58114
    function Initialize()
    {
        if(!$this->Visible) return;
        $this->DataSource->SetOrder("", "");
        $this->CurrentDate = $this->Now;
        if ($FullDate = CCGetFromGet($this->ComponentName . "Date", "")) {
            @list($year,$month) = split("-", $FullDate, 2);
        } else {
            $year = CCGetFromGet($this->ComponentName . "Year", "");
            $month = CCGetFromGet($this->ComponentName . "Month", "");
        }
        if (is_numeric($year) &&  $year >=101 && $year <=9999)
            $this->CurrentDate[ccsYear] = $year;
        if (is_numeric($month) &&  $month >=1 && $month <=12)
            $this->CurrentDate[ccsMonth] = $month;
        $this->CurrentDate[ccsDay] = 1;
        $this->CalculateCalendarPeriod();
    }
//End Initialize Method

//Show Method @35-236FDF60
    function Show () {
        global $Tpl;
        global $CCSLocales;
        global $DefaultDateFormat;
        if(!$this->Visible) return;

        $this->CalculateCalendarPeriod();
        $this->DataSource->Parameters["urldepartment_id"] = CCGetFromGet("department_id", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->DataSource->Prepare();
        $this->DataSource->Open();

        while ($this->DataSource->next_record()) {
            $DateField = CCParseDate($this->DataSource->f("appointment_date"), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
            if (!is_array($DateField)) continue;
            if (CCCompareValues($DateField, $this->StartDate, ccsDate) >= 0 && CCCompareValues($DateField, $this->EndDate , ccsDate) <= 0) {
                $this->DataSource->SetValues();
                $Event = new clsEventresult_users();
                $Event->_Time = CCParseDate($this->DataSource->f("appointment_time"), array("HH", ":", "nn", ":", "ss"));
                $Event->EventTime = $this->DataSource->EventTime->GetValue();
                $Event->EventDescription = $this->DataSource->EventDescription->GetValue();
                $Event->Attributes = $this->Attributes->GetAsArray();
                $datestr = CCFormatDate($DateField, array("yyyy","mm","dd"));
                if(!isset($this->Events[$datestr])) $this->Events[$datestr] = array();
                $this->Events[$datestr][] = $Event;
            }
        }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;
        $this->Attributes->Show();

        $CalendarBlock = "Calendar " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $CalendarBlock;
        $this->Errors->AddErrors($this->DataSource->Errors);
        if($this->Errors->Count()) {
            $Tpl->replaceblock("", $this->Errors->ToString());
            $Tpl->block_path = $ParentPath;
            return;
        } else {
            $month = 0;
            $this->CurrentProcessingDate = $this->FirstProcessingDate;
            $this->NextProcessingDate = CCDateAdd($this->CurrentProcessingDate, "1month");
            $this->PrevProcessingDate = CCDateAdd($this->CurrentProcessingDate, "-1month");
            $Tpl->block_path = $ParentPath . "/" . $CalendarBlock . "/Month";
            while ($this->MonthsCount > $month++) {
                $this->ShowMonth();
                if(($this->MonthsCount != $month) && ($month % $this->MonthsInRow == 0)) {
                    $this->Attributes->Show();
                    $Tpl->SetVar("MonthsInRow", $this->MonthsInRow);
                    $Tpl->block_path = $ParentPath . "/" . $CalendarBlock;
                    $Tpl->ParseTo("MonthsRowSeparator", true, "Month");
                    $Tpl->block_path = $ParentPath . "/" . $CalendarBlock . "/Month";
                }
                $Tpl->SetBlockVar("Week", "");
                $Tpl->SetBlockVar("Week/Day", "");
                $this->ProcessNextDate(CCDateAdd($this->NextProcessingDate, "+1month"));
            }
            $this->CurrentProcessingDate = $this->FirstProcessingDate;
            $this->NextProcessingDate = CCDateAdd($this->CurrentProcessingDate, "1month");
            $this->PrevProcessingDate = CCDateAdd($this->CurrentProcessingDate, "-1month");
            $Tpl->SetVar("MonthsInRow", $this->MonthsInRow);
            $Tpl->block_path = $ParentPath . "/" . $CalendarBlock;
            $this->Navigator->CurrentDate = $this->CurrentDate;
            $this->Navigator->PrevProcessingDate = $this->PrevProcessingDate;
            $this->Navigator->NextProcessingDate = $this->NextProcessingDate;
            $this->Navigator->Show();
            $Tpl->Parse();
        }
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

//result_users ShowMonth Method @35-77BB1C86
    function ShowMonth () {
        $Tpl = & CCGetTemplate($this);
        global $CCSLocales;
        global $DefaultDateFormat;
        $ParentPath = $Tpl->block_path;
        $OldCurrentProcessingDate = $this->CurrentProcessingDate;
        $OldNextProcessingDate = $this->NextProcessingDate;
        $OldPrevProcessingDate = $this->PrevProcessingDate;
        $FirstMonthDate = CCParseDate(CCFormatDate($this->CurrentProcessingDate, array("yyyy", "-", "mm","-01 00:00:00")), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        $LastMonthDate = CCDateAdd($FirstMonthDate, "+1month -1second");
        $Days = (CCFormatDate($FirstMonthDate, array("w")) - $this->FirstWeekDay + 6) % 7;
        $FirstShowedDate = CCDateAdd($FirstMonthDate, "-" . $Days . "day");
        $Days += $LastMonthDate[ccsDay];
        $Days += ($this->FirstWeekDay  - CCFormatDate($LastMonthDate, array("w")) + 7) % 7;
        $this->CurrentProcessingDate =  $FirstShowedDate;
        $this->PrevProcessingDate =  CCDateAdd($FirstShowedDate, "-1day");
        $this->NextProcessingDate =  CCDateAdd($FirstShowedDate, "+1day");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowMonth", $this);
        $this->Attributes->Show();
        $ShowedDays = 0;
        $WeekDay = CCFormatDate($this->CurrentProcessingDate, array("w"));
        while($ShowedDays < $Days) {
            if ($ShowedDays % 7 == 0) {
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowWeek", $this);
                $this->Attributes->Show();
            }
            $this->IsCurrentMonth = $this->CurrentProcessingDate[ccsMonth] == $OldCurrentProcessingDate[ccsMonth];
            $this->SetCurrentStyle("Day", $WeekDay);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowDay", $this);
            $this->Attributes->Show();
            if ($this->IsCurrentMonth) {
                $datestr = CCFormatDate($this->CurrentProcessingDate, array("yyyy","mm","dd"));
                $Tpl->block_path = $ParentPath . "/Week/Day/EventRow";
                $Tpl->SetBlockVar("", "");
                if (isset($this->Events[$datestr])) {
                    uasort($this->Events[$datestr], array($this, "CompareEventTime"));
                    foreach ($this->Events[$datestr] as $key=>$event) {
                        $Tpl->block_path = $ParentPath . "/Week/Day/EventRow";
                        $this->Attributes->AddFromArray($this->Events[$datestr][$key]->Attributes);
                        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowEvent", $this);
                        $this->EventTime->SetValue($event->EventTime);
                        $this->EventDescription->SetValue($event->EventDescription);
                        $this->EventTime->Show();
                        $this->EventDescription->Show();
                        $this->Attributes->Show();
                        $Tpl->Parse("", true);
                    }
                } else {
                }
                $Tpl->block_path = $ParentPath . "/Week/Day";
                $this->DayNumber->SetValue($this->CurrentProcessingDate);
                $this->DayNumber->Show();
                $this->Attributes->Show();
                $Tpl->SetVar("Style", $this->CurrentStyle);
                $Tpl->Parse("", true);
            } else {
                $Tpl->block_path = $ParentPath . "/Week/EmptyDay";
                $this->Attributes->Show();
                $Tpl->block_path = $ParentPath . "/Week";
                $Tpl->SetVar("Style", $this->CurrentStyle);
                $Tpl->ParseTo("EmptyDay", true, "Day");
            }
            $ShowedDays++;
            if ($ShowedDays and $ShowedDays % 7 == 0) {
                $Tpl->block_path = $ParentPath . "/Week";
                $this->Attributes->Show();
                $Tpl->Parse("", true);
                $Tpl->SetBlockVar("Day", "");
            }
            $this->ProcessNextDate(CCDateAdd($this->NextProcessingDate, "+1day"));
            $WeekDay = $WeekDay == 7 ? 1 : $WeekDay + 1;
        }
        $Tpl->block_path = $ParentPath . "/WeekDays";
        $Tpl->SetBlockVar("","");
        $WeekDay = CCFormatDate($this->CurrentProcessingDate, array("w"));
        $ShowedDays = 0;
        $this->CurrentProcessingDate =  $FirstShowedDate;
        $this->PrevProcessingDate =  CCDateAdd($FirstShowedDate, "-1day");
        $this->NextProcessingDate =  CCDateAdd($FirstShowedDate, "+1day");
        while($ShowedDays < 7) {
            $this->Attributes->Show();
            $this->DayOfWeek->SetValue($this->CurrentProcessingDate);
            $this->DayOfWeek->Show();
            $this->SetCurrentStyle("WeekDay", $WeekDay);
            $Tpl->SetVar("Style", $this->CurrentStyle);
            $Tpl->Parse("", true);
            $WeekDay = $WeekDay == 7 ? 1 : $WeekDay + 1;
            $this->ProcessNextDate(CCDateAdd($this->NextProcessingDate, "+1day"));
            $ShowedDays++;
        }
        $Tpl->block_path = $ParentPath;
        $this->CurrentProcessingDate = $OldCurrentProcessingDate;
        $this->NextProcessingDate = $OldNextProcessingDate;
        $this->PrevProcessingDate = $OldPrevProcessingDate;
        $Tpl->Parse("", true);
        $Tpl->block_path = $ParentPath;
    }
//End result_users ShowMonth Method

//result_users ProcessNextDate Method @35-67D24A68
    function ProcessNextDate($NewDate) {
        $this->PrevProcessingDate = $this->CurrentProcessingDate;
        $this->CurrentProcessingDate = $this->NextProcessingDate;
        $this->NextProcessingDate = $NewDate;
    }
//End result_users ProcessNextDate Method

//result_users CalculateCalendarPeriod Method @35-8917C348
    function CalculateCalendarPeriod() {
        $this->FirstProcessingDate = CCParseDate(CCFormatDate($this->CurrentDate, array("yyyy","-","mm","-01 00:00:00")), array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        $Days = (CCFormatDate($this->FirstProcessingDate, array("w")) - $this->FirstWeekDay + 6) % 7;
        $this->StartDate = CCDateAdd($this->FirstProcessingDate, "-" . $Days . "day");
        $this->LastProcessingDate = CCDateAdd($this->FirstProcessingDate, "1month -1second");
        $Days = ($this->FirstWeekDay - CCFormatDate($this->LastProcessingDate, array("w")) + 7) % 7;
        $this->EndDate = CCDateAdd($this->LastProcessingDate, $Days . "day");
    }
//End result_users CalculateCalendarPeriod Method

//result_users SetCurrentStyle Method @35-E3596475
    function SetCurrentStyle ($scope, $weekday="") {
        global $CCSLocales;
        $Result="";
        $Weekends = $CCSLocales->GetFormatInfo("Weekend");
        $IsWeekend = in_array($weekday, $Weekends);
        switch ($scope) {
            case "WeekDay":
                if ($IsWeekend)
                    $Result = "WeekendName";
                else
                    $Result = "WeekdayName";
                break;
            case "Day":
                if (!$this->IsCurrentMonth) {
                    $Result = "OtherMonth" . ($IsWeekend ? "Weekend" : "Day");
                } else {
                    $IsCurrentDay = $this->CurrentProcessingDate[ccsYear] == $this->Now[ccsYear] &&
                        $this->CurrentProcessingDate[ccsMonth] == $this->Now[ccsMonth] &&
                        $this->CurrentProcessingDate[ccsDay] == $this->Now[ccsDay];
                    if($IsCurrentDay)
                        $Result = "Today";
                    if($IsWeekend) 
                        $Result = "Weekend" . $Result;
                    elseif (!$Result) 
                        $Result = "Day";
                }
                break;
        }
        $this->CurrentStyle = isset($this->CalendarStyles[$Result]) ? $this->CalendarStyles[$Result] : "";
    }
//End result_users SetCurrentStyle Method

//result_users CompareEventTime Method @35-DC59CE14
    function CompareEventTime($val1, $val2) {
        $className = "clsEventresult_users";
        $time1 = ($val1 instanceof $className) && is_array($val1->_Time) ? $val1->_Time[ccsHour] * 3600 + $val1->_Time[ccsMinute] * 60 + $val1->_Time[ccsSecond] : 0;
        $time2 = ($val2 instanceof $className) && is_array($val2->_Time) ? $val2->_Time[ccsHour] * 3600 + $val2->_Time[ccsMinute] * 60 + $val2->_Time[ccsSecond] : 0;
        if ($time1 == $time2)
            return 0;
        return $time1 > $time2 ? 1 : -1;
    }
//End result_users CompareEventTime Method

} //End result_users Class @35-FCB6E20C

class clsresult_usersDataSource extends clsDBConnection1 {  //result_usersDataSource Class @35-04924A07

//DataSource Variables @35-142424B3
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;


    // Datasource fields
    public $EventTime;
    public $EventDescription;
//End DataSource Variables

//DataSourceClass_Initialize Event @35-A44D9BD8
    function clsresult_usersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "";
        $this->Initialize();
        $this->EventTime = new clsField("EventTime", ccsDate, array("HH", ":", "nn", ":", "ss"));
        
        $this->EventDescription = new clsField("EventDescription", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @35-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @35-A22A501F
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urldepartment_id", ccsInteger, "", "", $this->Parameters["urldepartment_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "users.department_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @35-9D86B78C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT result.*, concat_ws(\" \",first_name, last_name) AS names \n\n" .
        "FROM result INNER JOIN users ON\n\n" .
        "result.user_id = users.user_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @35-CFDDE8E1
    function SetValues()
    {
        $this->EventTime->SetDBValue(trim($this->f("appointment_time")));
        $this->EventDescription->SetDBValue($this->f("names"));
    }
//End SetValues Method

} //End result_usersDataSource Class @35-FCB6E20C

//Initialize Page @1-A2783416
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
$TemplateFileName = "schedule_appointment.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-8791BA6A
CCSecurityRedirect("1;4", "../access_denied.php");
//End Authenticate User

//Include events file @1-0140BA96
include_once("./schedule_appointment_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-442FBD55
$DBConnection1 = new clsDBConnection1();
$MainPage->Connections["Connection1"] = & $DBConnection1;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$footer = new clsfooter("../includes/", "footer", $MainPage);
$footer->Initialize();
$header_receptionist_sa = new clsheader_receptionist_sa("../includes/", "header_receptionist_sa", $MainPage);
$header_receptionist_sa->Initialize();
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$Label3 = new clsControl(ccsLabel, "Label3", "Label3", ccsText, "", CCGetRequestParam("Label3", ccsGet, NULL), $MainPage);
$result = new clsRecordresult("", $MainPage);
$result_users = new clsCalendarresult_users("", $MainPage);
$Label4 = new clsControl(ccsLabel, "Label4", "Label4", ccsDate, array("LongDate"), CCGetRequestParam("Label4", ccsGet, NULL), $MainPage);
$Label5 = new clsControl(ccsLabel, "Label5", "Label5", ccsText, "", CCGetRequestParam("Label5", ccsGet, NULL), $MainPage);
$MainPage->footer = & $footer;
$MainPage->header_receptionist_sa = & $header_receptionist_sa;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->Label3 = & $Label3;
$MainPage->result = & $result;
$MainPage->result_users = & $result_users;
$MainPage->Label4 = & $Label4;
$MainPage->Label5 = & $Label5;
if(!is_array($Label2->Value) && !strlen($Label2->Value) && $Label2->Value !== false)
    $Label2->SetText(getUserName());
if(!is_array($Label4->Value) && !strlen($Label4->Value) && $Label4->Value !== false)
    $Label4->SetValue(time());
if(!is_array($Label5->Value) && !strlen($Label5->Value) && $Label5->Value !== false)
    $Label5->SetText(ccgetparam('result_id'));
$result->Initialize();
$result_users->Initialize();

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

//Execute Components @1-8A5A03DC
$result->Operation();
$header_receptionist_sa->Operations();
$footer->Operations();
//End Execute Components

//Go to destination page @1-925A9F73
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBConnection1->close();
    header("Location: " . $Redirect);
    $footer->Class_Terminate();
    unset($footer);
    $header_receptionist_sa->Class_Terminate();
    unset($header_receptionist_sa);
    unset($result);
    unset($result_users);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-41B49378
$footer->Show();
$header_receptionist_sa->Show();
$result->Show();
$result_users->Show();
$Label1->Show();
$Label2->Show();
$Label3->Show();
$Label4->Show();
$Label5->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-6E1A94E9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBConnection1->close();
$footer->Class_Terminate();
unset($footer);
$header_receptionist_sa->Class_Terminate();
unset($header_receptionist_sa);
unset($result);
unset($result_users);
unset($Tpl);
//End Unload Page
?>
