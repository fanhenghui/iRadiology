<?php
//BindEvents Method @1-D38E3A57
function BindEvents()
{
    global $users;
    $users->Label1->CCSEvents["BeforeShow"] = "users_Label1_BeforeShow";
    $users->CCSEvents["AfterUpdate"] = "users_AfterUpdate";
}
//End BindEvents Method

//DEL  // -------------------------
//DEL      $users->
//DEL  // -------------------------

//users_Label1_BeforeShow @12-B8AC82A6
function users_Label1_BeforeShow(& $sender)
{
    $users_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_Label1_BeforeShow

//Custom Code @13-2A29BDB7
// -------------------------
    if($users->user_status_id->GetValue() == 2)
    {
    	$users->Label1->SetValue('<label class="label label-important">Deactivate</label>');    
    }
    else if (($users->user_status_id->GetValue() == 1) or ($users->user_status_id->GetValue() == 3))
    {
    	$users->Label1->SetValue('<label class="label label-success">Activate</label>');
    }
    else 
    {
    	$users->Label1->SetValue('<label class="label label-info">Activate/Deactivate</label>');
    }
    
    
// -------------------------
//End Custom Code

//Close users_Label1_BeforeShow @12-3B81C0CC
    return $users_Label1_BeforeShow;
}
//End Close users_Label1_BeforeShow

//users_AfterUpdate @2-59D9CA5D
function users_AfterUpdate(& $sender)
{
    $users_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_AfterUpdate

//Custom Code @14-2A29BDB7
// -------------------------
    $db = new clsDBconnection1();   	    
    if($users->user_status_id->GetValue() == 2)
    {
    	$sql = "update users set user_status_id = 3 where users.user_id=".CCGetParam("uid");
    	$db->query($sql);
    	$Result1 = $db->next_record();    	
    }else if($users->user_status_id->GetValue() == 3 or $users->user_status_id->GetValue() == 1)
    {
    	$sql = "update users set user_status_id = 2 where users.user_id=".CCGetParam("uid");
    	$db->query($sql);
    	$Result1 = $db->next_record();    	
    }
// -------------------------
//End Custom Code

//Close users_AfterUpdate @2-DE0947D6
    return $users_AfterUpdate;
}
//End Close users_AfterUpdate
?>
