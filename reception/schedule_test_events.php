<?php
//BindEvents Method @1-2954F602
function BindEvents()
{
    global $Label1;
    global $result;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $result->CCSEvents["AfterInsert"] = "result_AfterInsert";
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

//result_AfterInsert @10-84F96099
function result_AfterInsert(& $sender)
{
    $result_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $result; //Compatibility
//End result_AfterInsert

//Custom Code @36-2A29BDB7
// -------------------------
    global $Redirect;
    $db1 = new clsDBconnection1();
 	$sql1 = "select max(result_id) as maxp from result";
  	$db1->query($sql1);
  	$Result1 = $db1->next_record(); 
  	$maxp = $db1->f('maxp');
  	$sqlp = "select department_id from result where result.result_id=".$maxp;
  	$db1->query($sqlp);
  	$Result2 = $db1->next_record();	
  	if($Result1 and $Result2)
  	$Redirect = "schedule_appointment.php?result_id=".$maxp."&department_id=".$db1->f('department_id');
  	
// -------------------------
//End Custom Code

//Close result_AfterInsert @10-30692902
    return $result_AfterInsert;
}
//End Close result_AfterInsert


?>
