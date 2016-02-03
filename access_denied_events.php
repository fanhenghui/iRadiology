<?php
//BindEvents Method @1-7DF649C6
function BindEvents()
{
    global $Label1;
    global $NewRecord1;
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $NewRecord1->Button_Insert->CCSEvents["OnClick"] = "NewRecord1_Button_Insert_OnClick";
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
    if(ccgetparam('type','')== "illegalGroup")
    {
    	$Label1->SetValue("Designation not Allowed!");
    }
    else if(ccgetparam('type','')== "notLogged")
    {
    	$Label1->SetValue("Not Logged in");
    }else 
    {$Label1->SetValue("");}
// -------------------------
//End Custom Code

//Close Label1_BeforeShow @5-B48DF954
    return $Label1_BeforeShow;
}
//End Close Label1_BeforeShow

//DEL  // -------------------------
//DEL      global $Redirect;
//DEL      if(1>0)
//DEL      $Redirect = "index.php";
//DEL  // -------------------------

//NewRecord1_Button_Insert_OnClick @10-848B3021
function NewRecord1_Button_Insert_OnClick(& $sender)
{
    $NewRecord1_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $NewRecord1; //Compatibility
//End NewRecord1_Button_Insert_OnClick

//Custom Code @11-2A29BDB7
// -------------------------
    global $Redirect;
    if(1>0)
    $Redirect = "login?ret_link=".ccgetparam("ret_link","");;
// -------------------------
//End Custom Code

//Close NewRecord1_Button_Insert_OnClick @10-A9FC55FD
    return $NewRecord1_Button_Insert_OnClick;
}
//End Close NewRecord1_Button_Insert_OnClick

//DEL  // -------------------------
//DEL      global $Redirect;
//DEL      if(1>0)
//DEL      $Redirect = "index.php";
//DEL  // -------------------------



?>
