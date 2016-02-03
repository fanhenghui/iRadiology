<?php
//BindEvents Method @1-5D5BE2DD
function BindEvents()
{
    global $Label1;
    global $Label3;
    global $status_result_occupation;
    global $nop5;
    global $nop1;
    global $nop2;
    global $nop3;
    global $nop4;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $Label3->CCSEvents["BeforeShow"] = "Label3_BeforeShow";
    $status_result_occupation->status_result_occupation_TotalRecords->CCSEvents["BeforeShow"] = "status_result_occupation_status_result_occupation_TotalRecords_BeforeShow";
    $nop5->CCSEvents["BeforeShow"] = "nop5_BeforeShow";
    $nop1->CCSEvents["BeforeShow"] = "nop1_BeforeShow";
    $nop2->CCSEvents["BeforeShow"] = "nop2_BeforeShow";
    $nop3->CCSEvents["BeforeShow"] = "nop3_BeforeShow";
    $nop4->CCSEvents["BeforeShow"] = "nop4_BeforeShow";
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

//Label3_BeforeShow @12-FCE582BF
function Label3_BeforeShow(& $sender)
{
    $Label3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label3; //Compatibility
//End Label3_BeforeShow

//Custom Code @13-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sqlq = "select department from department inner join users on department.department_id = users.department_id where user_id =".CCGetuserid();
  	$db->query($sqlq);
  	$Resultq = $db->next_record(); 
  	$dept = $db->f('department');	
  	if($Resultq)
  	$Label3->SetValue(" ".$dept);
  	$db->close();
// -------------------------
//End Custom Code

//Close Label3_BeforeShow @12-55E33DF9
    return $Label3_BeforeShow;
}
//End Close Label3_BeforeShow

//status_result_occupation_status_result_occupation_TotalRecords_BeforeShow @36-5D0D116D
function status_result_occupation_status_result_occupation_TotalRecords_BeforeShow(& $sender)
{
    $status_result_occupation_status_result_occupation_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $status_result_occupation; //Compatibility
//End status_result_occupation_status_result_occupation_TotalRecords_BeforeShow

//Retrieve number of records @37-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close status_result_occupation_status_result_occupation_TotalRecords_BeforeShow @36-977CA41E
    return $status_result_occupation_status_result_occupation_TotalRecords_BeforeShow;
}
//End Close status_result_occupation_status_result_occupation_TotalRecords_BeforeShow

//nop5_BeforeShow @119-14CC00EE
function nop5_BeforeShow(& $sender)
{
    $nop5_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nop5; //Compatibility
//End nop5_BeforeShow

//Custom Code @128-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql = "select count(weekday(appointment_date)) as Friday from result where (WEEKOFYEAR(curdate())) = WEEKOFYEAR(appointment_date) and weekday(appointment_date) = 4 and user_id=".CCGetUserID();
    $db->query($sql);
    $Resultt = $db->next_record(); 
    $fri = $db->f('Friday');    
    if($Resultt)
    $nop5->SetValue($fri);
    else 
    $nop5->SetValue(0);
    $db->close();
// -------------------------
//End Custom Code

//Close nop5_BeforeShow @119-EBFECEBF
    return $nop5_BeforeShow;
}
//End Close nop5_BeforeShow

//nop1_BeforeShow @120-FA78D952
function nop1_BeforeShow(& $sender)
{
    $nop1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nop1; //Compatibility
//End nop1_BeforeShow

//Custom Code @124-2A29BDB7
// -------------------------
   	$db = new clsDBconnection1();
 	$sql = "select count(weekday(appointment_date)) as Monday from result where (WEEKOFYEAR(curdate())) = WEEKOFYEAR(appointment_date) and weekday(appointment_date) = 0 and user_id=".CCGetUserID();
    $db->query($sql);
    $Result = $db->next_record(); 
    $mon = $db->f('Monday');    
    if($Result)
    $nop1->SetValue($mon);
    else 
    $nop1->SetValue(0);
    $db->close();
// -------------------------
//End Custom Code
//Close nop1_BeforeShow @120-F25241A4
    return $nop1_BeforeShow;
}
//End Close nop1_BeforeShow

//nop2_BeforeShow @121-B68F83E3
function nop2_BeforeShow(& $sender)
{
    $nop2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nop2; //Compatibility
//End nop2_BeforeShow

//Custom Code @125-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql = "select count(weekday(appointment_date)) as Tuesday from result where (WEEKOFYEAR(curdate())) = WEEKOFYEAR(appointment_date) and weekday(appointment_date) = 1 and user_id=".CCGetUserID();
    $db->query($sql);
    $Result1 = $db->next_record(); 
    $tue = $db->f('Tuesday');    
    if($Result1)
    $nop2->SetValue($tue);
    else 
    $nop2->SetValue(0);
    $db->close();
// -------------------------
//End Custom Code

//Close nop2_BeforeShow @121-8E33647F
    return $nop2_BeforeShow;
}
//End Close nop2_BeforeShow

//nop3_BeforeShow @122-8D22B58C
function nop3_BeforeShow(& $sender)
{
    $nop3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nop3; //Compatibility
//End nop3_BeforeShow

//Custom Code @126-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql = "select count(weekday(appointment_date)) as Wednesday from result where (WEEKOFYEAR(curdate())) = WEEKOFYEAR(appointment_date) and weekday(appointment_date) = 2 and user_id=".CCGetUserID();
    $db->query($sql);
    $Result2 = $db->next_record(); 
    $wed = $db->f('Wednesday');    
    if($Result2)
    $nop3->SetValue($wed);
    else 
    $nop3->SetValue(0);
    $db->close();
// -------------------------
//End Custom Code

//Close nop3_BeforeShow @122-133C8509
    return $nop3_BeforeShow;
}
//End Close nop3_BeforeShow

//nop4_BeforeShow @123-2F613681
function nop4_BeforeShow(& $sender)
{
    $nop4_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nop4; //Compatibility
//End nop4_BeforeShow

//Custom Code @127-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql = "select count(weekday(appointment_date)) as Thursday from result where (WEEKOFYEAR(curdate())) = WEEKOFYEAR(appointment_date) and weekday(appointment_date) = 3 and user_id=".CCGetUserID();
    $db->query($sql);
    $Result3 = $db->next_record(); 
    $thur = $db->f('Thursday');    
    if($Result3)
    $nop4->SetValue($thur);
    else 
    $nop4->SetValue(0);
    $db->close();
// -------------------------
//End Custom Code

//Close nop4_BeforeShow @123-76F12FC9
    return $nop4_BeforeShow;
}
//End Close nop4_BeforeShow

//DEL  // -------------------------
//DEL      $db = new clsDBconnection1();
//DEL   	$sql = "select count(weekday(appointment_date)) as Monday from result where (WEEKOFYEAR(curdate())) = WEEKOFYEAR(appointment_date) and weekday(appointment_date) = 2 and user_id=".CCGetUserID();
//DEL    	$db->query($sql);
//DEL    	$Result = $db->next_record(); 
//DEL    	$nop = $db->f('Monday');	
//DEL    	$Co
//DEL    	if($Result)
//DEL    	
//DEL    	$index->SetValue(" ".$dept);
//DEL    	$db->close();
//DEL  // -------------------------



?>
