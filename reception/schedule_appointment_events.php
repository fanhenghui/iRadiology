<?php
//BindEvents Method @1-D36867D1
function BindEvents()
{
    global $Label1;
    global $Label3;
    global $result;
    global $result_users;
    global $Label5;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $Label3->CCSEvents["BeforeShow"] = "Label3_BeforeShow";
    $result->CCSEvents["AfterUpdate"] = "result_AfterUpdate";
    $result_users->EventDescription->CCSEvents["BeforeShow"] = "result_users_EventDescription_BeforeShow";
    $Label5->CCSEvents["BeforeShow"] = "Label5_BeforeShow";
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

//Label3_BeforeShow @10-FCE582BF
function Label3_BeforeShow(& $sender)
{
    $Label3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label3; //Compatibility
//End Label3_BeforeShow

//Custom Code @11-2A29BDB7
// -------------------------
    global $Redirect;
    $db = new clsDBconnection1();
 	$sql = "select surname, other_names from patient inner join result on patient.patient_id=result.patient_id where result.result_id=".ccgetparam("result_id","");
  	$db->query($sql);
  	$Result = $db->next_record();
  	$Label3->SetValue($db->f('surname')." ".$db->f('other_names'));  	
// -------------------------
//End Custom Code

//Close Label3_BeforeShow @10-55E33DF9
    return $Label3_BeforeShow;
}
//End Close Label3_BeforeShow

//result_AfterUpdate @12-7787D635
function result_AfterUpdate(& $sender)
{
    $result_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_AfterUpdate

//Custom Code @100-2A29BDB7
// -------------------------
    $result->Errors->addError('DONE!');
// -------------------------
//End Custom Code

//Close result_AfterUpdate @12-FF40E88D
    return $result_AfterUpdate;
}
//End Close result_AfterUpdate

//result_users_EventDescription_BeforeShow @59-7C2A797B
function result_users_EventDescription_BeforeShow(& $sender)
{
    $result_users_EventDescription_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result_users; //Compatibility
//End result_users_EventDescription_BeforeShow

//Custom Code @86-2A29BDB7
// -------------------------
    $result_users->EventDescription->HTML = True;
    $result_users->EventDescription->SetText('<label class="label label-success">'.$result_users->EventDescription->GetValue().'</label>');
    
    // -------------------------
//End Custom Code

//Close result_users_EventDescription_BeforeShow @59-DC1CBC5C
    return $result_users_EventDescription_BeforeShow;
}
//End Close result_users_EventDescription_BeforeShow

//Label5_BeforeShow @103-85860421
function Label5_BeforeShow(& $sender)
{
    $Label5_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label5; //Compatibility
//End Label5_BeforeShow

//Custom Code @104-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql1 = "select patient_id from result where result_id=".CCGetParam('result_id','');
  	$db->query($sql1);
  	$Result1 = $db->next_record(); 
  	$pid = $db->f('patient_id');	
  	if($Result1)
  	$Label5->SetValue($pid."-".CCGetParam('result_id',''));
// -------------------------
//End Custom Code

//Close Label5_BeforeShow @103-AD21764F
    return $Label5_BeforeShow;
}
//End Close Label5_BeforeShow


?>
