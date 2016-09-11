<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
}

	//Define the Data Array 
	$data = array();
	$is_exist = false;
	$is_edit = false;	
	$show_status = isset($_POST['show_status']) ? $_POST['show_status'] : 1;
	
	//Define the Notification Array 
	$notificationArray = array();
	
	// following code is done for managing view boxes on all pages and for managing permissions of functions and subfunctions
	$include_subcon = false;
	$function_type = 'subfunction';
	$is_internal_subfunction = 1;
	
	if($function == 'show_box_view')
	{	
		$is_internal_subfunction = 0; //echo $current_pageid; exit;			
		$arr_allfunctions = $applnObject->getAllSubMenu($logArray['user_id'], $current_pageid); //echo count($arr_allfunctions);
		if(count($arr_allfunctions) > 1)
		{	//echo "here"; exit;
			$data['check_from'] = 'function';
			$data['module'] = $module;
			$data['arr_alldata'] = $arr_allfunctions;
			$include_subcon = true;
			$function_type = 'function';
		}
		elseif(count($arr_allfunctions) == 1)
		{	//echo "in else"; exit;//printr($arr_allfunctions); //echo "here"; exit;
			$mainfunction = $function;			
			$arr_subfunctions = $applnObject->getMenuData($logArray['user_id'], $arr_allfunctions[0]['function_id']); //printr($arr_subfunctions); 
			if(count($arr_subfunctions) > 1)
			{	//echo "if"; exit;
				$data['arr_alldata'] = $arr_subfunctions;
				$data['module'] = $module;
				$include_subcon = true;				
			}
			elseif(count($arr_subfunctions) == 1)
			{	//echo "else"; exit;
				$subfunction_name = $arr_subfunctions[0]['function_name'];				
				$function = $arr_subfunctions[0]['function_name'];				
				$set_subfunction_id = $arr_subfunctions[0]['function_id'];	//echo $set_subfunction_id; exit;
			}
		}	
	} 
	elseif(isset($_POST['from_menu']) && ($_POST['from_menu'] == 'function'))
	{
		$is_internal_subfunction = 0;
		$mainfunction = $function;				
		$arr_subfunctions = $applnObject->getMenuData($logArray['user_id'], $function,'function_name',$current_pageid);
		
		if(count($arr_subfunctions) > 1)
		{
			$data['arr_alldata'] = $arr_subfunctions;
			$include_subcon = true;			
		}
		elseif(count($arr_subfunctions) == 1)
		{	
			$subfunction_name = $arr_subfunctions[0]['function_name'];				
			$function = $arr_subfunctions[0]['function_name'];
			$set_subfunction_id = $arr_subfunctions[0]['function_id'];
		}		
	}
	
	if($is_internal_subfunction == 1)
	{	
		if(isset($_POST['mainfunction']))
		{	
			$main_functionid = $applnObject->getCurrentFunctionId($_POST['mainfunction'],$current_pageid); 
			$set_subfunction_id =  $applnObject->getOne('sub_functions','function_id',"page_id = '".$current_pageid."' and main_function_id= '".$main_functionid."' and function_name = '".$_POST['subfunction_name']."'");
		}	
	}
	$current_year = $applnObject->getOne('year','id','current_year = 1');		
	//echo $module.'###'.$page.'###'.$function;	
	
	if($include_subcon == true)
	{
		$page="view.php";
	}
	else
	{	
		if($module != 'dashboard')
		{
			// for managing actions permissions
			if(isset($_POST['mainfunction']))
			{
				$data['mainfunction'] = $_POST['mainfunction'];
				$data['subfunction_name'] = $_POST['subfunction_name'];					
			}
			else
			{
				$data['mainfunction'] = $mainfunction;
				$data['subfunction_name'] = $subfunction_name;
			}
			
			$arr_permissions = $applnObject->getActionPermissions($logArray['user_id'],$current_pageid,$function,$function_type,$set_subfunction_id);
			$data['arr_permission'] = $arr_permissions;	
			//echo "<pre>"; print_r($data['arr_permission']); exit;
			///////////////////////////////////
		}
		
		include('sub_controllers/sc_'.$module.'.php');
	}
	// ends boxes and permissions management code
	//////////////////////////////////////////////////////////////////////////////////////////
	
	if(!is_file("views/".$page)){
		include_once('views/uc.php');
	}
	else
	{		
		extract($data);
		include_once("views/".$page);
	}
?>
<input type="hidden" name="from_menu" id="from_menu" value="<?php if(isset($check_from)) echo $check_from; ?>">
