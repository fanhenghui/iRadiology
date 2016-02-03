<?php
//BindEvents Method @1-120E8ACC
function BindEvents()
{
    global $date_count_values;
    $date_count_values->CCSEvents["BeforeShow"] = "date_count_values_BeforeShow";
}
//End BindEvents Method

//date_count_values_BeforeShow @5-6EE0EC14
function date_count_values_BeforeShow(& $sender)
{
    $date_count_values_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $date_count_values; //Compatibility
//End date_count_values_BeforeShow

//Custom Code @6-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();
 	$sql = "call patientdatecount;";
  	$db->query($sql);
  	$Result = $db->next_record(); 
  	$rs = $db->f('rs');	
  	if($Result)
  	{
  		$date_count_values->SetValue($rs);
  	}else{$date_count_values->SetValue(0);} 
  	$db->close();
// -------------------------
//End Custom Code

//Close date_count_values_BeforeShow @5-A61B4F44
    return $date_count_values_BeforeShow;
}
//End Close date_count_values_BeforeShow


?>
