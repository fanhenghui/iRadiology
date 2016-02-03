<?php

// //Events @1-F81417CB

//complete_daily_request_distribution_date_count_values_BeforeShow @5-73532EBD
function complete_daily_request_distribution_date_count_values_BeforeShow(& $sender)
{
    $complete_daily_request_distribution_date_count_values_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $complete_daily_request_distribution; //Compatibility
//End complete_daily_request_distribution_date_count_values_BeforeShow

//Custom Code @6-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql = "call patientdatecount;";
  	$db->query($sql);
  	$Result = $db->next_record(); 
  	$rs = $db->f('rs');	
  	if($Result)
  	{
  		$complete_daily_request_distribution->date_count_values->SetValue($rs);
  	}else{$complete_daily_request_distribution->date_count_values->SetValue(0);} 
  	$db->close();
// -------------------------
//End Custom Code

//Close complete_daily_request_distribution_date_count_values_BeforeShow @5-3607DB0E
    return $complete_daily_request_distribution_date_count_values_BeforeShow;
}
//End Close complete_daily_request_distribution_date_count_values_BeforeShow
?>
