<?php
include_once('library/config/Config.php');
include_once('library/commonFunctions.php');
include_once('library/config/checkSession.php'); 
include_once('library/applicationManager.php'); 
$applnObject = new applicationManager();

unset($_GET);
$applnObject->purifyInputs();	//Purify all request vaiables

$request_string = http_build_query($_REQUEST);
$session_string = http_build_query($_SESSION);	

if(!(isset($_POST['page']) || isset($_POST['function'])))
{
	$default_page_details = $applnObject->getPageDetails($_SESSION['user_main_group']);
	$page = $default_page_details[0]['page_name'];
	$function = $default_page_details[0]['function_name'];
	$module = $default_page_details[0]['module_name'];
	//$main_page = $default_page_details[0]['main_page'];
}	
else 
{
	$page = setPage();
	$function = setFunction();
	$module = setModule();
	//$main_page = setMainPage();
}

$pageTitle = $applnObject->getPageTitle($page); 

$logArray = array(
'user_id'=>$_SESSION['user_id'],
'page'=>$page,
'function'=>$function,
'request_variables'=>$request_string,
'session_variables'=>$session_string,
'request_time'=>date('Y-m-d H:i:s'),
'ip_address'=>$_SERVER['REMOTE_ADDR']);
//$log_id = $applnObject->insertLog($logArray);	// to make log array entry uncomment this line 
$current_pageid = $applnObject->getCurrentPageId($module); 

//Check Page & Function Permissions
if($function!='logout')
{	
	$arr_all = array(
				'page' => $page,
				'function' => $function				
				);
	if(isset($_REQUEST['mainfunction']))
		$arr_all['mainfunction'] = $_REQUEST['mainfunction'];
	if(isset($_REQUEST['subfunction_name']))
		$arr_all['subfunction_name'] = $_REQUEST['subfunction_name'];
	$applnObject->checkUserPemission($arr_all);	
}

unset($_REQUEST['page']);
unset($_REQUEST['function']);
unset($_POST['page']);
unset($_POST['function']);
?>
