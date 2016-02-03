<?php
//BindEvents Method @1-0CCD91E1
function BindEvents()
{
    global $users;
    $users->CCSEvents["OnValidate"] = "users_OnValidate";
    $users->CCSEvents["AfterUpdate"] = "users_AfterUpdate";
}
//End BindEvents Method

//users_OnValidate @5-B2171EAD
function users_OnValidate(& $sender)
{
    $users_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_OnValidate

//Custom Code @12-2A29BDB7
// -------------------------
    if($users->pwrd->GetValue() != $users->user_password->GetValue())
    {
    	$users->Errors->addError("Password Mismatch!");
    	return;
    }
// -------------------------
//End Custom Code

//Close users_OnValidate @5-6FF40A5B
    return $users_OnValidate;
}
//End Close users_OnValidate

//users_AfterUpdate @5-59D9CA5D
function users_AfterUpdate(& $sender)
{
    $users_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_AfterUpdate

//Custom Code @34-2A29BDB7
// -------------------------
    $users->Errors->addError('<div class="alert alert-success"> DONE! Username and Password Creation Successful. Request for Activation </div>');
	
// -------------------------
//End Custom Code

//Close users_AfterUpdate @5-DE0947D6
    return $users_AfterUpdate;
}
//End Close users_AfterUpdate


?>
