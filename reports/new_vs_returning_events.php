<?php

// //Events @1-F81417CB

//new_vs_returning_newPatient_BeforeShow @7-AAAFBDD8
function new_vs_returning_newPatient_BeforeShow(& $sender)
{
    $new_vs_returning_newPatient_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $new_vs_returning; //Compatibility
//End new_vs_returning_newPatient_BeforeShow

//Custom Code @8-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sqll = "select (count(distinct patient_id)/count(patient_id))*100 as nPc from result";
  	$db->query($sqll);
  	$Result = $db->next_record(); 
  	$npc = $db->f('nPc');	
  	if($Result)
  	{
  		$new_vs_returning->newPatient->SetValue($npc);
  	}else{$new_vs_returning->newPatient->SetValue(0);} 
  	$db->close();  	
// -------------------------
//End Custom Code

//Close new_vs_returning_newPatient_BeforeShow @7-F19A1CD5
    return $new_vs_returning_newPatient_BeforeShow;
}
//End Close new_vs_returning_newPatient_BeforeShow

//new_vs_returning_returningPatient_BeforeShow @9-43B0AB83
function new_vs_returning_returningPatient_BeforeShow(& $sender)
{
    $new_vs_returning_returningPatient_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $new_vs_returning; //Compatibility
//End new_vs_returning_returningPatient_BeforeShow

//Custom Code @10-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sqll = "select ((count(patient_id) - count(distinct patient_id))/count(patient_id))*100 as rPc from result;";
  	$db->query($sqll);
  	$Result = $db->next_record(); 
  	$rpc = $db->f('rPc');	
  	if($Result)
  	{
  		$new_vs_returning->returningPatient->SetValue($rpc);
  	}else{$new_vs_returning->returningPatient->SetValue(0);} 
  	$db->close(); 
// -------------------------
//End Custom Code

//Close new_vs_returning_returningPatient_BeforeShow @9-0342B8F8
    return $new_vs_returning_returningPatient_BeforeShow;
}
//End Close new_vs_returning_returningPatient_BeforeShow
?>
