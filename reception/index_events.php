<?php
//BindEvents Method @1-F06AA5C2
function BindEvents()
{
    global $Label1;
    global $sex_occupation_patient;
    global $sex_occupation_patient1;
    global $patient;
    global $title_status_users_result;
    global $CCSEvents;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $sex_occupation_patient->CCSEvents["BeforeShow"] = "sex_occupation_patient_BeforeShow";
    $sex_occupation_patient1->CCSEvents["BeforeShow"] = "sex_occupation_patient1_BeforeShow";
    $patient->Button1->CCSEvents["OnClick"] = "patient_Button1_OnClick";
    $patient->Label1->CCSEvents["BeforeShow"] = "patient_Label1_BeforeShow";
    $patient->Label2->CCSEvents["BeforeShow"] = "patient_Label2_BeforeShow";
    $patient->CCSEvents["BeforeShow"] = "patient_BeforeShow";
    $patient->CCSEvents["AfterInsert"] = "patient_AfterInsert";
    $title_status_users_result->title_status_users_result_TotalRecords->CCSEvents["BeforeShow"] = "title_status_users_result_title_status_users_result_TotalRecords_BeforeShow";
}
//End BindEvents Method

//Label1_BeforeShow @5-62EBFD0A
function Label1_BeforeShow(& $sender)
{
    $Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label1; //Compatibility
//End Label1_BeforeShow

//Custom Code @6-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql1 = "select user_group.group from user_group inner join users on user_group.group_id=users.group_id where users.user_id=".CCGetuserid();
  	$db->query($sql1);
  	$Result1 = $db->next_record(); 
  	$ugroup = $db->f('group');	
  	if($Result1)
  	$Label1->SetValue(" ".$ugroup);
// -------------------------
//End Custom Code

//Close Label1_BeforeShow @5-B48DF954
    return $Label1_BeforeShow;
}
//End Close Label1_BeforeShow

//sex_occupation_patient_BeforeShow @11-CC7A26FC
function sex_occupation_patient_BeforeShow(& $sender)
{
    $sex_occupation_patient_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $sex_occupation_patient; //Compatibility
//End sex_occupation_patient_BeforeShow

//Custom Code @56-2A29BDB7
// -------------------------    
    if((ccgetparam("s_keyword","") == "") or (ccgetparam("onAdd","") == 1))
    {
    	$sex_occupation_patient->Visible = false;    	    
    }    
// -------------------------
//End Custom Code

//Close sex_occupation_patient_BeforeShow @11-9A07F3BA
    return $sex_occupation_patient_BeforeShow;
}
//End Close sex_occupation_patient_BeforeShow

//sex_occupation_patient1_BeforeShow @39-775A4752
function sex_occupation_patient1_BeforeShow(& $sender)
{
    $sex_occupation_patient1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $sex_occupation_patient1; //Compatibility
//End sex_occupation_patient1_BeforeShow

//Custom Code @55-2A29BDB7
// -------------------------
    if(ccgetparam("onAdd","") == 1)
    {
    	$sex_occupation_patient1->Visible = false;    
    }
// -------------------------
//End Custom Code

//Close sex_occupation_patient1_BeforeShow @39-1C7A1989
    return $sex_occupation_patient1_BeforeShow;
}
//End Close sex_occupation_patient1_BeforeShow

//DEL  // -------------------------
//DEL      if(ccgetparam("patient_id","") != "")
//DEL      {
//DEL      	$patient->surname->Visible = false;
//DEL      }
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      if(ccgetparam("patient_id","") != "")
//DEL      {
//DEL      	$patient->sex_id->HTML = '<input class="disable">';
//DEL      }
//DEL  // -------------------------

//patient_Button1_OnClick @74-66A4F117
function patient_Button1_OnClick(& $sender)
{
    $patient_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_Button1_OnClick

//Custom Code @75-2A29BDB7
// -------------------------
    global $Redirect;
    $Redirect= "index.php";   
// -------------------------
//End Custom Code

//Close patient_Button1_OnClick @74-56991CDD
    return $patient_Button1_OnClick;
}
//End Close patient_Button1_OnClick

//patient_Label1_BeforeShow @77-351C38D7
function patient_Label1_BeforeShow(& $sender)
{
    $patient_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_Label1_BeforeShow

//Custom Code @78-2A29BDB7
// -------------------------	
    $patient->Label1->SetValue("Fill this form to register a new patient. Proceed to complete Radiology Request information. All fields are Required!");
	if(ccgetparam("patient_id","") != "")
	{
		$patient->Label1->Visible = false;
	}
// -------------------------
//End Custom Code

//Close patient_Label1_BeforeShow @77-8BC6BDFD
    return $patient_Label1_BeforeShow;
}
//End Close patient_Label1_BeforeShow

//patient_Label2_BeforeShow @79-93917843
function patient_Label2_BeforeShow(& $sender)
{
    $patient_Label2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_Label2_BeforeShow

//Custom Code @80-2A29BDB7
// -------------------------
    $patient->Label2->SetValue("Update patients information, particularly Age, Occupation and Maybe their Surnames!");
    if(ccgetparam("patient_id","") != "")
    {
    	$patient->Label2->Visible = true;
    }
    else
    {
    	$patient->Label2->Visible = false;
    }
// -------------------------
//End Custom Code

//Close patient_Label2_BeforeShow @79-F7A79826
    return $patient_Label2_BeforeShow;
}
//End Close patient_Label2_BeforeShow

//patient_BeforeShow @42-BB92BB4C
function patient_BeforeShow(& $sender)
{
    $patient_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_BeforeShow

//Custom Code @57-2A29BDB7
// -------------------------
    if((ccgetparam("patient_id","") != "") or (ccgetparam("onAdd","") == 1))
    {
    	$patient->Visible = true;
    }
    else
    {
    	$patient->Visible = false;
    }
// -------------------------
//End Custom Code

//Close patient_BeforeShow @42-055DA218
    return $patient_BeforeShow;
}
//End Close patient_BeforeShow

//patient_AfterInsert @42-3AEAF9E0
function patient_AfterInsert(& $sender)
{
    $patient_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_AfterInsert

//Custom Code @83-2A29BDB7
// -------------------------
    global $Redirect;
    $db = new clsDBconnection1();
 	$sql1 = "select max(patient_id) as maxp from patient";
  	$db->query($sql1);
  	$Result1 = $db->next_record(); 
  	$maxp = $db->f('maxp');	
  	if($Result1)
  	$Redirect = "schedule_test.php?patient_id=".$maxp;
// -------------------------
//End Custom Code

//Close patient_AfterInsert @42-6AC4FF3B
    return $patient_AfterInsert;
}
//End Close patient_AfterInsert

//title_status_users_result_title_status_users_result_TotalRecords_BeforeShow @136-ED3DED74
function title_status_users_result_title_status_users_result_TotalRecords_BeforeShow(& $sender)
{
    $title_status_users_result_title_status_users_result_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $title_status_users_result; //Compatibility
//End title_status_users_result_title_status_users_result_TotalRecords_BeforeShow

//Retrieve number of records @137-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close title_status_users_result_title_status_users_result_TotalRecords_BeforeShow @136-542042E2
    return $title_status_users_result_title_status_users_result_TotalRecords_BeforeShow;
}
//End Close title_status_users_result_title_status_users_result_TotalRecords_BeforeShow

//Page_BeforeInitialize @1-E5CCA708
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $index; //Compatibility
//End Page_BeforeInitialize

//YahooAutocomplete1 Initialization @169-663F79D3
    if ('sex_occupation_patient1s_keywordYahooAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete1 Initialization

//YahooAutocomplete1 DataSource @169-D7716879
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM patient {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "surname", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete1 DataSource

//YahooAutocomplete1 DataFields @169-7B8C1313
        $Service->AddDataSourceField('surname');
//End YahooAutocomplete1 DataFields

//YahooAutocomplete1 Execution @169-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete1 Execution

//YahooAutocomplete1 Tail @169-27890EF8
        exit;
    }
//End YahooAutocomplete1 Tail

//YahooAutocomplete2 Initialization @170-F89F3274
    if ('sex_occupation_patient1s_keywordYahooAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete2 Initialization

//YahooAutocomplete2 DataSource @170-A29C63C1
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM patient {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "other_names", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete2 DataSource

//YahooAutocomplete2 DataFields @170-6D762D08
        $Service->AddDataSourceField('other_names');
//End YahooAutocomplete2 DataFields

//YahooAutocomplete2 Execution @170-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete2 Execution

//YahooAutocomplete2 Tail @170-27890EF8
        exit;
    }
//End YahooAutocomplete2 Tail

//YahooAutocomplete3 Initialization @171-8D00F4E9
    if ('sex_occupation_patient1s_keywordYahooAutocomplete3' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete3 Initialization

//YahooAutocomplete3 DataSource @171-6F74E980
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM patient {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "hospital_no", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete3 DataSource

//YahooAutocomplete3 DataFields @171-BAEED557
        $Service->AddDataSourceField('hospital_no');
//End YahooAutocomplete3 DataFields

//YahooAutocomplete3 Execution @171-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete3 Execution

//YahooAutocomplete3 Tail @171-27890EF8
        exit;
    }
//End YahooAutocomplete3 Tail

//YahooAutocomplete1 Initialization @172-3ED9C29E
    if ('title_status_users_result1s_patient_idYahooAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete1 Initialization

//YahooAutocomplete1 DataSource @172-EB18E68D
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM patient {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "patient_id", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete1 DataSource

//YahooAutocomplete1 DataFields @172-2A140E80
        $Service->AddDataSourceField('patient_id');
//End YahooAutocomplete1 DataFields

//YahooAutocomplete1 Execution @172-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete1 Execution

//YahooAutocomplete1 Tail @172-27890EF8
        exit;
    }
//End YahooAutocomplete1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
