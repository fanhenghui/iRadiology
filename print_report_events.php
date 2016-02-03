<?php
//BindEvents Method @1-734A2E98
function BindEvents()
{
    global $patID;
    global $startDate;
    global $deptShort;
    $patID->CCSEvents["BeforeShow"] = "patID_BeforeShow";
    $startDate->CCSEvents["BeforeShow"] = "startDate_BeforeShow";
    $deptShort->CCSEvents["BeforeShow"] = "deptShort_BeforeShow";
}
//End BindEvents Method

//patID_BeforeShow @79-3C45569A
function patID_BeforeShow(& $sender)
{
    $patID_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patID; //Compatibility
//End patID_BeforeShow

//Custom Code @83-2A29BDB7
// -------------------------
    $dbw = new clsDBconnection1();
 	$sqll = "select patient_id from result where result_id =".CCGetParam("result_id");
  	$dbw->query($sqll);
  	$Result3 = $dbw->next_record(); 
  	$pid = $dbw->f('patient_id');	
  	if($Result3)
  	$patID->SetValue("".$pid);
// -------------------------
//End Custom Code

//Close patID_BeforeShow @79-E39F40DB
    return $patID_BeforeShow;
}
//End Close patID_BeforeShow

//startDate_BeforeShow @81-13E321CB
function startDate_BeforeShow(& $sender)
{
    $startDate_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $startDate; //Compatibility
//End startDate_BeforeShow

//Custom Code @84-2A29BDB7
// -------------------------	
    $db = new clsDBconnection1();
 	$sqll = "select date from result where result_id =".CCGetParam("result_id");
  	$db->query($sqll);
  	$Result = $db->next_record(); 
  	$thedate = $db->f('date');	
  	if($Result)
  	$startDate->SetValue("".substr($thedate, 0, 10));
// -------------------------
//End Custom Code

//Close startDate_BeforeShow @81-28ECA311
    return $startDate_BeforeShow;
}
//End Close startDate_BeforeShow

//deptShort_BeforeShow @82-8254843C
function deptShort_BeforeShow(& $sender)
{
    $deptShort_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $deptShort; //Compatibility
//End deptShort_BeforeShow

//Custom Code @85-2A29BDB7
// -------------------------
    $dbs = new clsDBconnection1();
 	$sqlq = "select department_id from result where result_id =".CCGetParam("result_id");
  	$dbs->query($sqlq);
  	$Resulted = $dbs->next_record(); 
  	$deptID = $dbs->f('department_id');	
  	if($Resulted)
  	{
  		if($deptID == 1)
  		{
  			$deptShort->SetValue("USD");
  		}
  		else if($deptID == 2)
  		{
  			$deptShort->SetValue("X/M");
  		}
  		else if($deptID == 3)
  		{
  			$deptShort->SetValue("FRC");
  		}
  		else if($deptID == 4)
  		{
  			$deptShort->SetValue("CTS");
  		}
  		else if($deptID == 5)
  		{
  			$deptShort->SetValue("MRI");
  		}
  	}
// -------------------------
//End Custom Code

//Close deptShort_BeforeShow @82-D697CAAE
    return $deptShort_BeforeShow;
}
//End Close deptShort_BeforeShow


?>
