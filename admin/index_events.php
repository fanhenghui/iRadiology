<?php
//BindEvents Method @1-9E25CDB3
function BindEvents()
{
    global $Label1;
    global $users;
    global $title_user_group_departme;
    global $CCSEvents;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $users->Button1->CCSEvents["OnClick"] = "users_Button1_OnClick";
    $users->CCSEvents["AfterInsert"] = "users_AfterInsert";
    $users->CCSEvents["AfterUpdate"] = "users_AfterUpdate";
    $title_user_group_departme->user_status->CCSEvents["BeforeShow"] = "title_user_group_departme_user_status_BeforeShow";
    $title_user_group_departme->Label1->CCSEvents["BeforeShow"] = "title_user_group_departme_Label1_BeforeShow";
    $title_user_group_departme->CCSEvents["BeforeShowRow"] = "title_user_group_departme_BeforeShowRow";
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

//users_Button1_OnClick @29-2C3CF7BE
function users_Button1_OnClick(& $sender)
{
    $users_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_Button1_OnClick

//Custom Code @30-2A29BDB7
// -------------------------
    global $Redirect;
    $Redirect = "../admin";
// -------------------------
//End Custom Code

//Close users_Button1_OnClick @29-6153EED6
    return $users_Button1_OnClick;
}
//End Close users_Button1_OnClick

//users_AfterInsert @10-F49FDF23
function users_AfterInsert(& $sender)
{
    $users_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_AfterInsert

//Custom Code @28-2A29BDB7
// -------------------------
    $users->Errors->addError('<label class="label-success">'."DONE! Click Clear Button to clear and register another user".'</label>');
    
// -------------------------
//End Custom Code

//Close users_AfterInsert @10-11208659
    return $users_AfterInsert;
}
//End Close users_AfterInsert

//users_AfterUpdate @10-59D9CA5D
function users_AfterUpdate(& $sender)
{
    $users_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_AfterUpdate

//Custom Code @170-2A29BDB7
// -------------------------
    $users->Errors->addError('<label class="label-success">'."DONE! Click Clear Button to clear and register another user".'</label>');
    
// -------------------------
//End Custom Code

//Close users_AfterUpdate @10-DE0947D6
    return $users_AfterUpdate;
}
//End Close users_AfterUpdate

//title_user_group_departme_user_status_BeforeShow @70-93A37F14
function title_user_group_departme_user_status_BeforeShow(& $sender)
{
    $title_user_group_departme_user_status_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $title_user_group_departme; //Compatibility
//End title_user_group_departme_user_status_BeforeShow

//Custom Code @79-2A29BDB7
// -------------------------
	$status_var = $title_user_group_departme->user_status->GetText();	
    if($status_var == "Exists")
    {
    	$title_user_group_departme->user_status->HTML = true;
    	$title_user_group_departme->user_status->SetText('<label class="label label-info">'.$status_var.'</label>');
    }
    else if($status_var == "Active")
    {
    	$title_user_group_departme->user_status->HTML = true;
    	$title_user_group_departme->user_status->SetText('<label class="label label-success">'.$status_var.'</label>');
    }
    else if($status_var == "Deactivated")
    {
    	$title_user_group_departme->user_status->SetText('<label class="label label-important">'.$status_var.'</label>');
    }
// -------------------------
//End Custom Code

//Close title_user_group_departme_user_status_BeforeShow @70-27703A8F
    return $title_user_group_departme_user_status_BeforeShow;
}
//End Close title_user_group_departme_user_status_BeforeShow

//title_user_group_departme_Label1_BeforeShow @77-AC116C71
function title_user_group_departme_Label1_BeforeShow(& $sender)
{
    $title_user_group_departme_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $title_user_group_departme; //Compatibility
//End title_user_group_departme_Label1_BeforeShow

//Custom Code @78-2A29BDB7
// -------------------------
    if($title_user_group_departme->department->GetValue() == "")
    {
    	$title_user_group_departme->Label1->Visible = false;
    }
    else {$title_user_group_departme->Label1->Visible = true;}
// -------------------------
//End Custom Code

//Close title_user_group_departme_Label1_BeforeShow @77-16EC39F5
    return $title_user_group_departme_Label1_BeforeShow;
}
//End Close title_user_group_departme_Label1_BeforeShow

//title_user_group_departme_BeforeShowRow @31-79C42F46
function title_user_group_departme_BeforeShowRow(& $sender)
{
    $title_user_group_departme_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $title_user_group_departme; //Compatibility
//End title_user_group_departme_BeforeShowRow

//Custom Code @178-2A29BDB7
// -------------------------
    //while ($title_user_group_departme->DataSource->RecordsCount > 0)
  	//{
  		$title_user_group_departme->Button1->Visible = false;
  		$title_user_group_departme->Button2->Visible = false;
		$status = $title_user_group_departme->user_status->GetValue();
 	    if(($status == "Exists") and ($status != "Deactivated") and ($status != "Active"))
  	    {
  	    	$title_user_group_departme->Button2->Visible = false;
 	    	$title_user_group_departme->Button1->Visible = true;
  	    }
  	    else if(($status == "Active") and ($status != "Exists") and ($status != "Deactivated"))
  	    {
 	    	$title_user_group_departme->Button1->Visible = false;
  	    	$title_user_group_departme->Button2->Visible = true;
  	    }
 	    else if(($status == "Deactivated") and ($status != "Exists") and ($status != "Active"))
  	    {
  	    	$title_user_group_departme->Button1->Visible = true;
  	    	$title_user_group_departme->Button2->Visible = false;
  	    }
  	    //$title_user_group_departme->Label2->SetValue($title_user_group_departme->DataSource);
 	//}
      /*else
      {
      	$title_user_group_departme->Button2->Visible = false;
      	$title_user_group_departme->Button1->Visible = false;	
      }*/
// -------------------------
//End Custom Code

//Close title_user_group_departme_BeforeShowRow @31-14BB6BAC
    return $title_user_group_departme_BeforeShowRow;
}
//End Close title_user_group_departme_BeforeShowRow

//DEL  // -------------------------    
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      $title_user_group_departme->Label2->SetValue($title_user_group_departme->title->GetValue());
//DEL  // -------------------------

//DEL  // -------------------------
//DEL  	//while ($title_user_group_departme->DataSource->RecordsCount > 0)
//DEL  	//{
//DEL  		$title_user_group_departme->Button1->Visible = false;
//DEL  		$title_user_group_departme->Button2->Visible = false;
//DEL  		$status = $title_user_group_departme->user_status->GetValue();
//DEL  	    if(($status == "Exists") and ($status != "Deactivated") and ($status != "Active"))
//DEL  	    {
//DEL  	    	$title_user_group_departme->Button2->Visible = false;
//DEL  	    	$title_user_group_departme->Button1->Visible = true;
//DEL  	    }
//DEL  	    else if(($status == "Active") and ($status != "Exists") and ($status != "Deactivated"))
//DEL  	    {
//DEL  	    	$title_user_group_departme->Button1->Visible = false;
//DEL  	    	$title_user_group_departme->Button2->Visible = true;
//DEL  	    }
//DEL  	    else if(($status == "Deactivated") and ($status != "Exists") and ($status != "Active"))
//DEL  	    {
//DEL  	    	$title_user_group_departme->Button1->Visible = true;
//DEL  	    	$title_user_group_departme->Button2->Visible = false;
//DEL  	    }
//DEL  	    //$title_user_group_departme->Label2->SetValue($title_user_group_departme->DataSource);
//DEL  	//}
//DEL      /*else
//DEL      {
//DEL      	$title_user_group_departme->Button2->Visible = false;
//DEL      	$title_user_group_departme->Button1->Visible = false;	
//DEL      }*/
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      $dbq = new clsDBconnection1();
//DEL   	$sql = "update users set user_status = 2 where users.user_id=".$title_user_group_departme->myid->GetValue();
//DEL    	$dbq->query($sql);
//DEL    	$Result1 = $dbq->next_record(); 
//DEL    	//$ugroup = $dbq->f('group');	
//DEL    	//if($Result1)
//DEL    	//$Label1->SetValue(" ".$ugroup);
//DEL    	global $Redirect;
//DEL    	$Redirect = "index.php";
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      if(ccgetparam('s_keyword','')== "")
//DEL      {
//DEL      	$title_user_group_departme->Visible = false;
//DEL      }    
//DEL  // -------------------------

//Page_BeforeInitialize @1-E5CCA708
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $index; //Compatibility
//End Page_BeforeInitialize

//YahooAutocomplete1 Initialization @74-299480B3
    if ('title_user_group_departme1s_keywordYahooAutocomplete1' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete1 Initialization

//YahooAutocomplete1 DataSource @74-23A485AF
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM users {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "first_name", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete1 DataSource

//YahooAutocomplete1 DataFields @74-A2FDBB32
        $Service->AddDataSourceField('first_name');
//End YahooAutocomplete1 DataFields

//YahooAutocomplete1 Execution @74-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete1 Execution

//YahooAutocomplete1 Tail @74-27890EF8
        exit;
    }
//End YahooAutocomplete1 Tail

//YahooAutocomplete2 Initialization @75-B734CB14
    if ('title_user_group_departme1s_keywordYahooAutocomplete2' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete2 Initialization

//YahooAutocomplete2 DataSource @75-E4ED46DB
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM users {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "last_name", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete2 DataSource

//YahooAutocomplete2 DataFields @75-0BC99D58
        $Service->AddDataSourceField('last_name');
//End YahooAutocomplete2 DataFields

//YahooAutocomplete2 Execution @75-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete2 Execution

//YahooAutocomplete2 Tail @75-27890EF8
        exit;
    }
//End YahooAutocomplete2 Tail

//YahooAutocomplete3 Initialization @76-C2AB0D89
    if ('title_user_group_departme1s_keywordYahooAutocomplete3' == CCGetParam('callbackControl')) {
        $Service = new Service();
        $Service->SetFormatter(new JsonFormatter());
//End YahooAutocomplete3 Initialization

//YahooAutocomplete3 DataSource @76-1B31722E
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT * \n" .
"FROM department {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->Parameters["urlquery"] = CCGetFromGet("query", NULL);
        $Service->DataSource->wp = new clsSQLParameters();
        $Service->DataSource->wp->AddParameter("1", "urlquery", ccsText, "", "", $Service->DataSource->Parameters["urlquery"], -1, false);
        $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "department", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
        $Service->DataSource->Where = 
             $Service->DataSource->wp->Criterion[1];
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End YahooAutocomplete3 DataSource

//YahooAutocomplete3 DataFields @76-6EE6BEC7
        $Service->AddDataSourceField('department');
//End YahooAutocomplete3 DataFields

//YahooAutocomplete3 Execution @76-73F24F96
        echo '{"Result":' . $Service->Execute() . '}';
//End YahooAutocomplete3 Execution

//YahooAutocomplete3 Tail @76-27890EF8
        exit;
    }
//End YahooAutocomplete3 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
