<?php
//BindEvents Method @1-EDF35030
function BindEvents()
{
    global $Label1;
    global $Label3;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $Label3->CCSEvents["BeforeShow"] = "Label3_BeforeShow";
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


?>
