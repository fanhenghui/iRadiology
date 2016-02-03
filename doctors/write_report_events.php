<?php
//BindEvents Method @1-F4A88D27
function BindEvents()
{
    global $Label1;
    global $Label3;
    global $result;
    global $CCSEvents;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $Label3->CCSEvents["BeforeShow"] = "Label3_BeforeShow";
    $result->Label1->CCSEvents["BeforeShow"] = "result_Label1_BeforeShow";
    $result->Label2->CCSEvents["BeforeShow"] = "result_Label2_BeforeShow";
    $result->CCSEvents["AfterUpdate"] = "result_AfterUpdate";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
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

//Label3_BeforeShow @11-FCE582BF
function Label3_BeforeShow(& $sender)
{
    $Label3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label3; //Compatibility
//End Label3_BeforeShow

//Custom Code @12-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sqlq = "select department from department inner join users on department.department_id = users.department_id where user_id =".CCGetuserid();
  	$db->query($sqlq);
  	$Resultq = $db->next_record(); 
  	$dept = $db->f('department');	
  	if($Resultq)
  	$Label3->SetValue(" ".$dept);
// -------------------------
//End Custom Code

//Close Label3_BeforeShow @11-55E33DF9
    return $Label3_BeforeShow;
}
//End Close Label3_BeforeShow

//result_Label1_BeforeShow @59-792A2CCB
function result_Label1_BeforeShow(& $sender)
{
    $result_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_Label1_BeforeShow

//Custom Code @60-2A29BDB7
// -------------------------
    $dbd = new clsDBconnection1();
 	$sqlq = "select clinic from clinic where clinic_id =".$result->clinic_id->GetValue();
  	$dbd->query($sqlq);
  	$Resultp = $dbd->next_record(); 
  	$clinic = $dbd->f('clinic');	
  	if($Resultp)
  	$result->Label1->SetValue("".$clinic);
// -------------------------
//End Custom Code

//Close result_Label1_BeforeShow @59-702C0BDF
    return $result_Label1_BeforeShow;
}
//End Close result_Label1_BeforeShow

//result_Label2_BeforeShow @61-050CB42F
function result_Label2_BeforeShow(& $sender)
{
    $result_Label2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_Label2_BeforeShow

//Custom Code @62-2A29BDB7
// -------------------------
    $dbw = new clsDBconnection1();
 	$sqll = "select sub_dept from sub_dept where sub_dept_id =".$result->sup_dept_id->GetValue();
  	$dbw->query($sqll);
  	$Result3 = $dbw->next_record(); 
  	$sub_dept = $dbw->f('sub_dept');	
  	if($Result3)
  	$result->Label2->SetValue("".$sub_dept);
// -------------------------
//End Custom Code

//Close result_Label2_BeforeShow @61-0C4D2E04
    return $result_Label2_BeforeShow;
}
//End Close result_Label2_BeforeShow

//result_AfterUpdate @48-7787D635
function result_AfterUpdate(& $sender)
{
    $result_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_AfterUpdate

//Custom Code @68-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql2 = "Update result set status_id=3 where result_id=".ccgetparam('result_id');
  	$db->query($sql2);
  	$Result3 = $db->next_record();
  	$result->Errors->addError("DONE! CLICK HOME TO GO BACK!");    	
// -------------------------
//End Custom Code

//Close result_AfterUpdate @48-FF40E88D
    return $result_AfterUpdate;
}
//End Close result_AfterUpdate

//Page_BeforeShow @1-56E500AC
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $write_report; //Compatibility
//End Page_BeforeShow

//Custom Code @69-2A29BDB7
// -------------------------
	if(is_numeric(ccgetparam('result_id')))
	{
	    $db = new clsDBconnection1();
	 	$sqlq = "Update result set status_id=2 where result_id=".ccgetparam('result_id');
	  	$db->query($sqlq);
	  	$db->next_record();	  	
	}
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
