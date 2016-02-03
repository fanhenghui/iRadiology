<?php
//Page_BeforeInitialize @1-AD27CA57
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $single_free1; //Compatibility
//End Page_BeforeInitialize

//FlashChart1 Initialization @5-857F56FE
    if ('single_free1FlashChart1' == CCGetParam('callbackControl')) {
        global $CCSLocales;
        $Service = new Service();
        $formatter = new TemplateFormatter();
        $formatter->SetTemplate(file_get_contents(RelativePath . "/" . "single_free1FlashChart1.xml"));
        $Service->SetFormatter($formatter);
//End FlashChart1 Initialization

//FlashChart1 DataSource @5-DA6D444A
        $Service->DataSource = new clsDBConnection1();
        $Service->ds = & $Service->DataSource;
        $Service->DataSource->SQL = "SELECT statistical_conclusion_id, patient_id, result_id \n" .
"FROM result {SQL_Where} {SQL_OrderBy}";
        $Service->DataSource->PageSize = 25;
        $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End FlashChart1 DataSource

//FlashChart1 Execution @5-BBF3D7D9
        $Service->AddDataSetValue("Title", "Chart Title");
        $Service->AddHttpHeader("Cache-Control", "cache, must-revalidate");
        $Service->AddHttpHeader("Pragma", "public");
        $Service->AddHttpHeader("Content-type", "text/xml");
        $Service->DisplayHeaders();
        echo $Service->Execute();
//End FlashChart1 Execution

//FlashChart1 Tail @5-27890EF8
        exit;
    }
//End FlashChart1 Tail

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
