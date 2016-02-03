<?php
//BindEvents Method @1-03A88541
function BindEvents()
{
    global $Login;
    global $users;
    global $CCSEvents;
    $Login->Button_DoLogin->CCSEvents["OnClick"] = "Login_Button_DoLogin_OnClick";
    $users->Button1->CCSEvents["OnClick"] = "users_Button1_OnClick";
    $users->CCSEvents["AfterInsert"] = "users_AfterInsert";
}
//End BindEvents Method

//Login_Button_DoLogin_OnClick @6-1454CF55
function Login_Button_DoLogin_OnClick(& $sender)
{
    $Login_Button_DoLogin_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Login; //Compatibility
//End Login_Button_DoLogin_OnClick

//Login @9-79F6EB3D
    global $CCSLocales;
    global $Redirect;
    if ($Container->autoLogin->Value != $Container->autoLogin->CheckedValue) {
        CCSetCookie("iRadiologyLogin", "");
    }
    if ( !CCLoginUser( $Container->login1->Value, $Container->password->Value)) {
        $Container->Errors->addError($CCSLocales->GetText("CCS_LoginError"));
        $Container->password->SetValue("");
        $Login_Button_DoLogin_OnClick = 0;
        CCSetCookie("iRadiologyLogin", "");
    } else {
        global $Redirect;          
        if(getUst() == 1)
        {$Login->Errors->addError("You have not been activated!"); return;} 
        else if(getUst() == 3)
        {$Login->Errors->addError("Sorry! You have been Deactivated!"); return;} 
        else if(getUst() == 2){
        if ($Container->autoLogin->Value == $Container->autoLogin->CheckedValue) {
            $ALLogin    = $Container->login1->Value;
            $ALPassword = $Container->password->Value;
            CCSetALCookie($ALLogin, $ALPassword);
        }        
        switch(CCGetGroupID())
  		{
  			case 1: $Redirect = "../reception";
  			break; 
 			case 2: $Redirect = "../doctors";
  			break;
  			case 3: $Redirect = "../typist";
  			break;
  			case 4: $Redirect = "../admin";
  			break;
  			default: $Redirect = "access_denied.php";
  		}
        $Redirect = CCGetParam("ret_link", $Redirect);
        $Login_Button_DoLogin_OnClick = 1;
    }}
//End Login

//Close Login_Button_DoLogin_OnClick @6-0EB5DCFE
    return $Login_Button_DoLogin_OnClick;
}
//End Close Login_Button_DoLogin_OnClick

//users_Button1_OnClick @36-2C3CF7BE
function users_Button1_OnClick(& $sender)
{
    $users_Button1_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_Button1_OnClick

//Custom Code @30-2A29BDB7
// -------------------------
    global $Redirect;
    $Redirect = "../login";
// -------------------------
//End Custom Code

//Close users_Button1_OnClick @36-6153EED6
    return $users_Button1_OnClick;
}
//End Close users_Button1_OnClick

//users_AfterInsert @14-F49FDF23
function users_AfterInsert(& $sender)
{
    $users_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_AfterInsert

//Custom Code @42-2A29BDB7
// -------------------------
    global $Redirect;
    $db = new clsDBconnection1();
 	$sql1 = "select max(user_id) as uid from users";
  	$db->query($sql1);
  	$Result1 = $db->next_record(); 
  	$uid = $db->f('uid');	
  	if($Result1)
  	CCSetSession("myid",$uid);
  	$Redirect = "welcome.php";
// -------------------------
//End Custom Code

//Close users_AfterInsert @14-11208659
    return $users_AfterInsert;
}
//End Close users_AfterInsert

//DEL  // -------------------------
//DEL      global $Redirect;
//DEL      $Redirect = "../admin";
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      $users->Errors->addError('<label class="label-success">'."DONE! Click Clear Button to clear and register another user".'</label>');
//DEL      
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      $users->Errors->addError('<label class="label-success">'."DONE! Click Clear Button to clear and register another user".'</label>');
//DEL      
//DEL  // -------------------------

//Page_BeforeInitialize @1-E5CCA708
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $index; //Compatibility
//End Page_BeforeInitialize

//Logout @13-229E921B
    CCLogoutUser();
    CCSetCookie("iRadiologyLogin", "");
//End Logout

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//DEL  // -------------------------
//DEL      
//DEL  // -------------------------



?>
