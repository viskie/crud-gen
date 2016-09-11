<?php
class applicationManager extends CommonManager
{
	function __construct()
    {					
    }
	function getAppTitle()
	{	
		return $this->getOne('settings','config_value',"config_name='application_title'");
	}
	function getCopyrightText()
	{
		return $this->getOne('settings','config_value',"config_name='footer_text'");
	}
	function getPageDetails($user_main_group)
	{
		$landing_page = $this->getOne('user_groups','landing_page',"group_id='".$user_main_group."'"); 
		$landing_page = explode(',',$landing_page); 
		
		$default_page_details = $this->getData("Select p.`page_id`,p.module_name,p.page_name,sb.function_name from `pages` p LEFT JOIN `functions` f ON p.page_id=f.page_id LEFT JOIN sub_functions sb ON sb.main_function_id=f.function_id where sb.function_id='".$landing_page[2]."'"); //,sb.main_page
		
		return $default_page_details;		
	}
	function getPageTitle($pageName)
	{
		return $page_title = $this->getOne('pages','title',"page_name = '".$pageName."'"); 
	}
	function insertLog($logArray)
	{	
		$insertid = $this->insert('requestlog',$logArray);
		return $insertid;
	}
	function getCurrentPageId($module)
	{
		$pageid = $this->getOne('pages','page_id','module_name = "'.$module.'"'); 
		return $pageid;
	}
	function getCurrentFunctionId($name, $pageid)
	{
		$functionid = $this->getOne('functions','function_id','function_name = "'.$name.'" and page_id="'.$pageid.'"'); 
		return $functionid;
	}
	// for permission management functions 
	function checkUserPemission($arr_all)
	{	
		$group_id = $_SESSION['user_main_group'];
		$cond = " group_id = '".$group_id."'";
		if($group_id != DEVELOPER_GRP_ID)
		{
			if(isset($arr_all['page']))
			{
				$page_id 	= $this->getOne('pages','page_id',"page_name = '".$arr_all['page']."'"); 
				if($page_id != "")
					$cond .= " and page_id = '".$page_id."'";
			}
			
			if((isset($arr_all['mainfunction']) && ($arr_all['mainfunction'] != 'show_box_view') ) || (isset($arr_all['function']) && ($arr_all['function'] != 'show_box_view') ))
			{
				if(isset($arr_all['mainfunction']))
					$function_name = $arr_all['mainfunction'];
				else	
					$function_name = $arr_all['function'];
				$function_id = $this->getOne('functions','function_id',"page_id = '".$page_id."' and function_name = '".$function_name."'"); 
				if($function_id != "")
					$cond .= " and function_id = '".$function_id."'";			
				
				if(isset($arr_all['subfunction_name']))
				{	
					$subfunction_id = $this->getOne('sub_functions','function_id'," main_function_id  = '".$function_id."' and function_name = '".$arr_all['subfunction_name']."'");  
					if($subfunction_id != "")
						$cond .= " and sub_function_id = '".$subfunction_id."'";
				}
			}
			
			$check_permission= $this->getAll('user_permissions','permission_id',$cond); 
			if(count($check_permission) == 0)
			{
				 echo "<script type='text/javascript'>
							alert(\"You do not have permission to view this page.".$function." Please Contact administrator\");
							window.location = 'index.php';
					   </script>";
				exit;
			}
		}		
	}
	function getAllMenu($userid)
	{
		$groupid = $this->getOne('users','user_group',"user_id = '".$userid."'"); 
		$arr_allmenu = $this->getAll('pages','*'," 1 ORDER BY tab_order ASC"); 
		$arr_menu = array();
		foreach($arr_allmenu as $k=>$v)
		{
			if($groupid == DEVELOPER_GRP_ID)
			{
				$arr_menu[] = $v;
			}
			else
			{
				$check_permission = $this->getAll('user_permissions','permission_id',"group_id = '".$groupid."' and page_id = '".$v['page_id']."'"); 
				if(count($check_permission) > 0)
				{
					$arr_menu[] = $v;
				}
			}
		} 
		return $arr_menu;
	}	
	function getAllSubMenu($userid,$pageid)
	{
		$groupid = $this->getOne('users','user_group',"user_id = '".$userid."'"); 
		$arr_submenu = array();
		$arr_allsubmenu = $this->getAll('functions','*',"page_id = '".$pageid."' ORDER BY menu_order ASC"); 
		foreach($arr_allsubmenu as $k=>$v)
		{
			if($groupid == DEVELOPER_GRP_ID)
			{
				$arr_submenu[] = $v;
			}
			else
			{
				$check_permission = $this->getAll('user_permissions','permission_id',"group_id = '".$groupid."' and page_id = '".$pageid."' and function_id ='".$v['function_id']."'"); //getData("select permission_id from  user_permissions WHERE group_id = '".$groupid."' and page_id = '".$pageid."' and function_id ='".$v['function_id']."' and is_active=1");
				if(count($check_permission) > 0)
				{
					$arr_submenu[] = $v;
				}
			}
		}		
		return($arr_submenu);			
	}
	function getMenuData($userid,$id,$byfield='',$pageid='')
	{	
		if($byfield == 'function_name')
		{
			$functionid = $this->getCurrentFunctionId($id,$pageid);
			$cond = "main_function_id = '".$functionid."'";
		}
		else
			$cond = "main_function_id = '".$id."'";
		$arr_allfunctions = $this->getAll('sub_functions','function_id, page_id, function_name, friendly_name, main_function_id, is_crud',$cond." ORDER BY menu_order ASC"); //getData("select function_id, page_id, function_name, friendly_name, main_function_id, is_crud from sub_functions WHERE ".$cond." and is_active=1 ORDER BY menu_order ASC");
		
		$groupid = $this->getOne('users','user_group',"user_id = '".$userid."'"); 
		$all_subfunction = array();
		foreach($arr_allfunctions as $k=>$v)
		{	
			if($groupid == DEVELOPER_GRP_ID)
			{
				$all_subfunction[] = $v;
			}
			else
			{
				$check_permission = getAll('user_permissions','*',"group_id = '".$groupid."' and page_id = '".$v['page_id']."' and function_id  ='".$v['main_function_id']."' and sub_function_id = '".$v['function_id']."'"); //getData("select * from  user_permissions WHERE group_id = '".$groupid."' and page_id = '".$v['page_id']."' and function_id  ='".$v['main_function_id']."' and sub_function_id = '".$v['function_id']."' and is_active=1");
				if(count($check_permission) > 0)
				{
					$all_subfunction[] = $v;
				}
			}
		}	
		return $all_subfunction;
	}
	function getActionPermissions($userid,$pageid,$function,$function_type,$set_subfunction_id)
	{
		$groupid = $this->getOne('users','user_group',"user_id = '".$userid."'"); 
		if($groupid == DEVELOPER_GRP_ID)
		{
				$check_permission[0] = array(
					'permission_id' => 0,
					'view_perm' => 1,
					'add_perm' => 1,
					'edit_perm' => 1,
					'delete_perm' => 1,
					'restore_perm' => 1,
					);
		}
		else
		{	
			$cond='';
			if($function_type == '')
			{
				$functionid = $this->getCurrentFunctionId($function,$pageid);
				$cond .= ' function_id = "'.$functionid.'"';
			}
			elseif($function_type == 'subfunction')
			{
				$cond = " sub_function_id = '".$set_subfunction_id."'";
			}
			$check_permission = $this->getAll('user_permissions','permission_id, view_perm, add_perm, edit_perm, delete_perm, restore_perm',"group_id = '".$groupid."' and page_id = '".$pageid."' and ".$cond); //getData("select  permission_id, view_perm, add_perm, edit_perm, delete_perm, restore_perm from user_permissions WHERE group_id = '".$groupid."' and page_id = '".$pageid."' and ".$cond);		
			
		}
		return $check_permission;		 
	}
	/*************************************/
	function getPermission($from)
	{
		$arr_permission = array();
		$arr_exist_group = $this->getAll('status_permissions','group_id','status_category ="'.$from.'" GROUP BY group_id');
		
		for($i=0; $i<count($arr_exist_group); $i++)
		{
			$exist_status = $this->getAll('status_permissions','status_permission_id, group_id, status_id','status_category ="'.$from.'" and group_id = "'.$arr_exist_group[$i]['group_id'].'"');
			for($j=0; $j<count($exist_status); $j++)
			{
				$arr_permission[$arr_exist_group[$i]['group_id']][$j] = $exist_status[$j]['status_id'];
			}
		}
		return $arr_permission;
	}
	function getAllGroups()
	{
		$arr_groups =  $this->getAll('user_groups','group_id, group_name'); 
		return ($arr_groups);
	}	
	function savePermission($arr_data, $from)
	{
		$arr_groups = getAllGroups();
		for($i=0; $i<count($arr_groups); $i++)
		{
			$groupid = $arr_groups[$i]['group_id'];
			if(isset($arr_data["status_$groupid"]))
			{
				$all_exist_status = $this->getAll('status_permissions','status_permission_id, status_id',"status_category ='".$from."' and group_id ='".$groupid."'");
				$exist_status = array();
				foreach($all_exist_status as $k=>$v)
				{
					$exist_status[] =  $v['status_id'];
				}
				$intersect = array_intersect($arr_data["status_$groupid"],$exist_status);
				$new_extra = array_diff_assoc($arr_data["status_$groupid"], $intersect);
				$old_extra = array_diff_assoc($exist_status,$intersect);
				foreach($old_extra as $k=>$v) 
				{
					//$delquery = "DELETE FROM status_permissions WHERE status_category = '".$from."' and status_id=".$v." and group_id=".$groupid;
					//updateData($delquery);
					$this->delete('status_permissions',"","","status_category = '".$from."' and status_id=".$v." and group_id='".$groupid."'",true);
				}
				foreach($new_extra as $k=>$v)
				{
					$insert_data = array(
											'status_category' => $from,
											'group_id' 	=> $groupid,
											'status_id' => $v,
											);
					//$insertQry = getInsertDataString($insert_data, 'status_permissions');
					//updateData($insertQry);
					$this->insert('status_permissions',$insert_data);					
				}				
			}
			else
			{
				//$delquery = "DELETE FROM status_permissions WHERE status_category = '".$from."' and group_id=".$groupid;
				//updateData($delquery);
				$this->delete('status_permissions','','',"status_category = '".$from."' and group_id='".$groupid."'",true);
			}
		}
	}
	function checkPermission($check='',$groupid='',$pageid='',$functionid='',$subfunctionid='',$action='')
	{
		if($check == 'all')
		{
			$perm_pages = $this->getAll('user_permissions','DISTINCT page_id',"group_id = '".$groupid."'");
			$pages 	= $this->getAll('pages','page_id');
			if(count($perm_pages) == count($pages))
				return true;
			else
				return false;
		}
		else
		{
			$str_condition = ' group_id='.$groupid.' and is_active=1';
			if($pageid != "")
				$str_condition .= ' and page_id='.$pageid;
			if($functionid != "")
				$str_condition .= ' and function_id='.$functionid;
			if($subfunctionid != "")
				$str_condition .= ' and sub_function_id='.$subfunctionid;
			if($check == 'subfunction')
			{
				if($action == 'view')
					$str_condition .= ' and view_perm = 1';
				if($action == 'add')
					$str_condition .= ' and add_perm = 1';
				if($action == 'edit')
					$str_condition .= ' and edit_perm = 1';
				if($action == 'delete')
					$str_condition .= ' and delete_perm = 1';
				if($action == 'restore')
					$str_condition .= ' and restore_perm = 1';			
			}
			$arr_permission = $this->getAll('user_permissions','permission_id',$str_condition);			
			if(count($arr_permission)> 0)
				return true;
			else
				return false;
		}	
	}
	function getPermissionData()
	{
		$arr_permission = array();
		$arr_pages = $this->getAll('pages','*');
		$i=0;
		foreach($arr_pages as $k=>$v)
		{
			$arr_permission[$i]['page_id'] = $v['page_id'];
			$arr_permission[$i]['module_name'] = $v['module_name'];
			$arr_functions = $this->getAll('functions','*',"page_id = '".$v['page_id']."' ORDER BY menu_order ASC");
			$j=0;
			foreach($arr_functions as $k1=>$v1)
			{
				$arr_permission[$i]['functions'][$j] = $v1;
				$arr_subfunctions = $this->getAll('sub_functions','*',"main_function_id = '".$v1['function_id']."' ORDER BY menu_order ASC");
				foreach($arr_subfunctions as $k2=>$v2)
				{
					$arr_permission[$i]['functions'][$j]['subfunction'][] = $v2;
				}
				$j++;
			}
			$i++;
		}
		//echo "<pre>"; print_r($arr_permission); //exit;
		return ($arr_permission);
	}
	
}
?>
