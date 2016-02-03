<?php
//BindEvents Method @1-75FFBC90
function BindEvents()
{
    global $Label1;
    global $Label2;
    global $sex_department_patient_re;
    global $result;
    global $CCSEvents;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $Label2->CCSEvents["BeforeShow"] = "Label2_BeforeShow";
    $sex_department_patient_re->CCSEvents["BeforeShow"] = "sex_department_patient_re_BeforeShow";
    $result->patName->CCSEvents["BeforeShow"] = "result_patName_BeforeShow";
    $result->CCSEvents["BeforeShow"] = "result_BeforeShow";
    $result->CCSEvents["AfterUpdate"] = "result_AfterUpdate";
}
//End BindEvents Method

//Label1_BeforeShow @7-62EBFD0A
function Label1_BeforeShow(& $sender)
{
    $Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label1; //Compatibility
//End Label1_BeforeShow

//Custom Code @8-2A29BDB7
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

//Close Label1_BeforeShow @7-B48DF954
    return $Label1_BeforeShow;
}
//End Close Label1_BeforeShow

//Label2_BeforeShow @9-5E5A3E45
function Label2_BeforeShow(& $sender)
{
    $Label2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label2; //Compatibility
//End Label2_BeforeShow

//Custom Code @10-2A29BDB7
// -------------------------
    
// -------------------------
//End Custom Code

//Close Label2_BeforeShow @9-C8ECDC8F
    return $Label2_BeforeShow;
}
//End Close Label2_BeforeShow

//sex_department_patient_re_BeforeShow @11-3F649B5A
function sex_department_patient_re_BeforeShow(& $sender)
{
    $sex_department_patient_re_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $sex_department_patient_re; //Compatibility
//End sex_department_patient_re_BeforeShow

//Custom Code @166-2A29BDB7
// -------------------------
    if(ccgetparam("s_surname","")=="" and ccgetparam("s_other_names","")=="" and ccgetparam("s_hospital_no","")=="" and ccgetparam("s_result_id","")=="" and ccgetparam("s_patient_id","")=="")
    {
    	$sex_department_patient_re->Visible = false;
    } 
// -------------------------
//End Custom Code

//Close sex_department_patient_re_BeforeShow @11-B396286A
    return $sex_department_patient_re_BeforeShow;
}
//End Close sex_department_patient_re_BeforeShow

//result_patName_BeforeShow @167-678F740D
function result_patName_BeforeShow(& $sender)
{
    $result_patName_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_patName_BeforeShow

//Custom Code @181-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql11 = "select concat_ws(' ',surname,other_names) as names from patient inner join result on patient.patient_id = result.patient_id where result_id=".ccgetparam("result_id");
  	$db->query($sql11);
  	$Result21 = $db->next_record(); 
  	$names = $db->f('names');	
  	if($Result21)
  	$result->patName->SetValue(" ".$names);
// -------------------------
//End Custom Code

//Close result_patName_BeforeShow @167-4F33EC17
    return $result_patName_BeforeShow;
}
//End Close result_patName_BeforeShow

//result_BeforeShow @51-A19B5542
function result_BeforeShow(& $sender)
{
    $result_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_BeforeShow

//Custom Code @165-2A29BDB7
// -------------------------
    if(ccgetparam("result_id","") == "")
    {
    	$result->Visible = false;
    } 
// -------------------------
//End Custom Code

//Close result_BeforeShow @51-AD5480E6
    return $result_BeforeShow;
}
//End Close result_BeforeShow

//result_AfterUpdate @51-7787D635
function result_AfterUpdate(& $sender)
{
    $result_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_AfterUpdate

//Custom Code @182-2A29BDB7
// -------------------------
	global $Redirect;
    if(is_numeric(ccgetparam('result_id')))
	{
	    $db = new clsDBconnection1();
	 	$sqlq = "Update result set status_id=3 where result_id=".ccgetparam('result_id');
	  	$db->query($sqlq);
	  	$db->next_record();	 	
		$Redirect = "../print_report.php?result_id=".CCGetParam("result_id","");
	}
// -------------------------
//End Custom Code

//Close result_AfterUpdate @51-FF40E88D
    return $result_AfterUpdate;
}
//End Close result_AfterUpdate

//Page_BeforeInitialize @1-E5CCA708
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $index; //Compatibility
//End Page_BeforeInitialize

//YahooAutocomplete1 Initialization @65-2A144B48
    if ('sex_department_patient_re1s_surnameYahooAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete1 Initialization

//YahooAutocomplete1 DataSource @65-D7716879
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

//YahooAutocomplete1 DataFields @65-7B8C1313
        $Service->AddDataSourceField('surname');
//End YahooAutocomplete1 DataFields

//YahooAutocomplete1 Execution @65-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete1 Execution

//YahooAutocomplete1 Tail @65-27890EF8
        exit;
    }
//End YahooAutocomplete1 Tail

//YahooAutocomplete2 Initialization @66-4B9AF09F
    if ('sex_department_patient_re1s_other_namesYahooAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete2 Initialization

//YahooAutocomplete2 DataSource @66-A29C63C1
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

//YahooAutocomplete2 DataFields @66-6D762D08
        $Service->AddDataSourceField('other_names');
//End YahooAutocomplete2 DataFields

//YahooAutocomplete2 Execution @66-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete2 Execution

//YahooAutocomplete2 Tail @66-27890EF8
        exit;
    }
//End YahooAutocomplete2 Tail

//YahooAutocomplete3 Initialization @67-604AB22E
    if ('sex_department_patient_re1s_hospital_noYahooAutocomplete3' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete3 Initialization

//YahooAutocomplete3 DataSource @67-6F74E980
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

//YahooAutocomplete3 DataFields @67-BAEED557
        $Service->AddDataSourceField('hospital_no');
//End YahooAutocomplete3 DataFields

//YahooAutocomplete3 Execution @67-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete3 Execution

//YahooAutocomplete3 Tail @67-27890EF8
        exit;
    }
//End YahooAutocomplete3 Tail

//YahooAutocomplete4 Initialization @68-EEC841F4
    if ('sex_department_patient_re1s_patient_idYahooAutocomplete4' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete4 Initialization

//YahooAutocomplete4 DataSource @68-54A4C37F
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM result {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "patient_id", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete4 DataSource

//YahooAutocomplete4 DataFields @68-2A140E80
        $Service->AddDataSourceField('patient_id');
//End YahooAutocomplete4 DataFields

//YahooAutocomplete4 Execution @68-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete4 Execution

//YahooAutocomplete4 Tail @68-27890EF8
        exit;
    }
//End YahooAutocomplete4 Tail

//YahooAutocomplete5 Initialization @69-45F7FEB1
    if ('sex_department_patient_re1s_result_idYahooAutocomplete5' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete5 Initialization

//YahooAutocomplete5 DataSource @69-96886DBA
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM result {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "result_id", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete5 DataSource

//YahooAutocomplete5 DataFields @69-F2E2F41D
        $Service->AddDataSourceField('result_id');
//End YahooAutocomplete5 DataFields

//YahooAutocomplete5 Execution @69-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete5 Execution

//YahooAutocomplete5 Tail @69-27890EF8
        exit;
    }
//End YahooAutocomplete5 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//DEL  // -------------------------
//DEL      $db = new clsDBconnection1();
//DEL   	$sql1 = "select user_group.group from user_group inner join users on user_group.group_id=users.group_id where users.user_id=".CCGetuserid();
//DEL    	$db->query($sql1);
//DEL    	$Result1 = $db->next_record(); 
//DEL    	$ugroup = $db->f('group');	
//DEL    	if($Result1)
//DEL    	$Label1->SetValue(" ".$ugroup);
//DEL  // -------------------------



?>
