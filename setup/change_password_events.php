<?php

// //Events @1-F81417CB

//DEL  // -------------------------
//DEL      
//DEL  // -------------------------

//change_password_changepwd1_OnValidate @8-EACA1AF4
function change_password_changepwd1_OnValidate(& $sender)
{
    $change_password_changepwd1_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $change_password; //Compatibility
//End change_password_changepwd1_OnValidate

//Custom Code @13-2A29BDB7
// -------------------------
    if($change_password->changepwd1->newpwd->GetValue() != $change_password->changepwd1->confirmpwd->GetValue())
    {
    	$change_password->changepwd1->Errors->addError("New Password and Confirm Password Mismatch!");
    	return;
    }
    $db = new clsDBconnection1();
 	$sqll = "select user_password from users where user_id =".ccgetuserid();
  	$db->query($sqll);
  	$Result = $db->next_record(); 
  	$upwd = $db->f('user_password');	
  	if(($Result) and ($change_password->changepwd1->oldpwd->GetValue() != $upwd))
  	{
  		$change_password->changepwd1->Errors->addError("Old Password is incorrect!");
  		return;
  	}    
// -------------------------
//End Custom Code

//Close change_password_changepwd1_OnValidate @8-91FAC17C
    return $change_password_changepwd1_OnValidate;
}
//End Close change_password_changepwd1_OnValidate

//change_password_changepwd1_AfterUpdate @8-33BA0A51
function change_password_changepwd1_AfterUpdate(& $sender)
{
    $change_password_changepwd1_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $change_password; //Compatibility
//End change_password_changepwd1_AfterUpdate

//Custom Code @18-2A29BDB7
// -------------------------
    $dbw = new clsDBconnection1();
 	$sql1 = "update users set user_password ='".$change_password->changepwd1->confirmpwd->GetValue()."' where user_id=".CCGetUserID();
  	$dbw->query($sql1);
  	//$Result3 = $dbw->next_record(); 
  	if($dbw->affected_rows()>0)
  	{$change_password->changepwd1->Errors->addError('<div class="alert alert-success">DONE! Password Succesfully Changed! Login with new password to continue...</div>');
  		CCLogoutUser();
    	CCSetCookie("iRadiologyLogin", "");
  		} 
  	else 
  	{$change_password->changepwd1->Errors->addError('<div class="alert">Unable to Change Password! Try Again Later!</div>');}	
// -------------------------
//End Custom Code

//DEL      


//Close change_password_changepwd1_AfterUpdate @8-7BFDFC76
    return $change_password_changepwd1_AfterUpdate;
}
//End Close change_password_changepwd1_AfterUpdate
?>
