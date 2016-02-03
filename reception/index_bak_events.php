<?php
//BindEvents Method @1-BE53C23E
function BindEvents()
{
    global $Label1;
    global $sex_occupation_patient;
    global $sex_occupation_patient1;
    global $patient;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $sex_occupation_patient->CCSEvents["BeforeShow"] = "sex_occupation_patient_BeforeShow";
    $sex_occupation_patient1->CCSEvents["BeforeShow"] = "sex_occupation_patient1_BeforeShow";
    $patient->Button1->CCSEvents["OnClick"] = "patient_Button1_OnClick";
    $patient->Label1->CCSEvents["BeforeShow"] = "patient_Label1_BeforeShow";
    $patient->Label2->CCSEvents["BeforeShow"] = "patient_Label2_BeforeShow";
    $patient->CCSEvents["BeforeShow"] = "patient_BeforeShow";
    $patient->CCSEvents["AfterInsert"] = "patient_AfterInsert";
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

//sex_occupation_patient_BeforeShow @11-CC7A26FC
function sex_occupation_patient_BeforeShow(& $sender)
{
    $sex_occupation_patient_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $sex_occupation_patient; //Compatibility
//End sex_occupation_patient_BeforeShow

//Custom Code @56-2A29BDB7
// -------------------------    
    if((ccgetparam("s_keyword","") == "") or (ccgetparam("onAdd","") == 1))
    {
    	$sex_occupation_patient->Visible = false;    	    
    }    
// -------------------------
//End Custom Code

//Close sex_occupation_patient_BeforeShow @11-9A07F3BA
    return $sex_occupation_patient_BeforeShow;
}
//End Close sex_occupation_patient_BeforeShow

//sex_occupation_patient1_BeforeShow @39-775A4752
function sex_occupation_patient1_BeforeShow(& $sender)
{
    $sex_occupation_patient1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $sex_occupation_patient1; //Compatibility
//End sex_occupation_patient1_BeforeShow

//Custom Code @55-2A29BDB7
// -------------------------
    if(ccgetparam("onAdd","") == 1)
    {
    	$sex_occupation_patient1->Visible = false;    
    }
// -------------------------
//End Custom Code

//Close sex_occupation_patient1_BeforeShow @39-1C7A1989
    return $sex_occupation_patient1_BeforeShow;
}
//End Close sex_occupation_patient1_BeforeShow

//DEL  // -------------------------
//DEL      if(ccgetparam("patient_id","") != "")
//DEL      {
//DEL      	$patient->surname->Visible = false;
//DEL      }
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      if(ccgetparam("patient_id","") != "")
//DEL      {
//DEL      	$patient->sex_id->HTML = '<input class="disable">';
//DEL      }
//DEL  // -------------------------

//patient_Button1_OnClick @74-66A4F117
function patient_Button1_OnClick(& $sender)
{
    $patient_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_Button1_OnClick

//Custom Code @75-2A29BDB7
// -------------------------
    global $Redirect;
    $Redirect= "index.php";   
// -------------------------
//End Custom Code

//Close patient_Button1_OnClick @74-56991CDD
    return $patient_Button1_OnClick;
}
//End Close patient_Button1_OnClick

//patient_Label1_BeforeShow @77-351C38D7
function patient_Label1_BeforeShow(& $sender)
{
    $patient_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_Label1_BeforeShow

//Custom Code @78-2A29BDB7
// -------------------------	
    $patient->Label1->SetValue("Fill this form to register a new patient. Proceed to complete Radiology Request information. All fields are Required!");
	if(ccgetparam("patient_id","") != "")
	{
		$patient->Label1->Visible = false;
	}
// -------------------------
//End Custom Code

//Close patient_Label1_BeforeShow @77-8BC6BDFD
    return $patient_Label1_BeforeShow;
}
//End Close patient_Label1_BeforeShow

//patient_Label2_BeforeShow @79-93917843
function patient_Label2_BeforeShow(& $sender)
{
    $patient_Label2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_Label2_BeforeShow

//Custom Code @80-2A29BDB7
// -------------------------
    $patient->Label2->SetValue("Update patients information, particularly Age, Occupation and Maybe their Surnames!");
    if(ccgetparam("patient_id","") != "")
    {
    	$patient->Label2->Visible = true;
    }
    else
    {
    	$patient->Label2->Visible = false;
    }
// -------------------------
//End Custom Code

//Close patient_Label2_BeforeShow @79-F7A79826
    return $patient_Label2_BeforeShow;
}
//End Close patient_Label2_BeforeShow

//patient_BeforeShow @42-BB92BB4C
function patient_BeforeShow(& $sender)
{
    $patient_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_BeforeShow

//Custom Code @57-2A29BDB7
// -------------------------
    if((ccgetparam("patient_id","") != "") or (ccgetparam("onAdd","") == 1))
    {
    	$patient->Visible = true;
    }
    else
    {
    	$patient->Visible = false;
    }
// -------------------------
//End Custom Code

//Close patient_BeforeShow @42-055DA218
    return $patient_BeforeShow;
}
//End Close patient_BeforeShow

//patient_AfterInsert @42-3AEAF9E0
function patient_AfterInsert(& $sender)
{
    $patient_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $patient; //Compatibility
//End patient_AfterInsert

//Custom Code @83-2A29BDB7
// -------------------------
    global $Redirect;
    $db = new clsDBconnection1();
 	$sql1 = "select max(patient_id) as maxp from patient";
  	$db->query($sql1);
  	$Result1 = $db->next_record(); 
  	$maxp = $db->f('maxp');	
  	if($Result1)
  	$Redirect = "schedule_test.php?patient_id=".$maxp;
// -------------------------
//End Custom Code

//Close patient_AfterInsert @42-6AC4FF3B
    return $patient_AfterInsert;
}
//End Close patient_AfterInsert


?>
