<?php
// //Events @1-F81417CB

//footer_Link1_BeforeShow @2-C60BE12C
function footer_Link1_BeforeShow(& $sender)
{
    $footer_Link1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $footer; //Compatibility
//End footer_Link1_BeforeShow

//Custom Code @3-2A29BDB7
// -------------------------
    global $MainPage; 
    $footer->Redirect = $MainPage;      
// -------------------------
//End Custom Code

//Close footer_Link1_BeforeShow @2-7618FD2B
    return $footer_Link1_BeforeShow;
}
//End Close footer_Link1_BeforeShow


?>
