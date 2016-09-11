<?php 
include_once('library/userManager.php');
$userObject= new UserManager();
include_once('library/groupManager.php');
$groupObject= new GroupManager();

switch($function)
{
	case "default": 
		$str='';
		foreach($arr_grp as $val)
		{ $str.=$val.",";}
		$str=trim($str,",");
		$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
		$data['allUsers'] = $userObject->getAll($userObject->tb1_name,'*','user_group<>'.EMPLOYEE_GRP_ID.' and user_group not in ('.$str.')',$data['show_status']);
		$data['allGroups'] = $groupObject->getAll($groupObject->tb1_name,'*','group_id not in ('.$str.')'); 
		$data['rec_counts'] = $userObject->getRecordCountsUsers($arr_grp);				
		$page="manage_users.php";
	break;
		
	case "showform":
       if($_POST['edit_id']!==''){          
           $data['userVariables']=$userObject->getRow($userObject->tb1_name,'*',"user_id='".$_POST['edit_id']."'");
        }
		$str='';
		foreach($arr_grp as $val)
		{ $str.=$val.",";}
		$str=trim($str,",");
        $data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
        $data['allUsers'] = $userObject->getAll($userObject->tb1_name,'*','user_group<>'.EMPLOYEE_GRP_ID.' and user_group not in ('.$str.')',$data['show_status']);
		$data['allGroups'] = $groupObject->getAll($groupObject->tb1_name,'*','group_id not in ('.$str.')');
		$data['rec_counts'] = $userObject->getRecordCountsUsers($arr_grp);
        $page="manage_users.php";
    break;
	
	case "save":
            $userVariables =  $userObject->getUserVariables($_POST);
			$userVariables['user_id'] = $_POST['edit_id']; 
			if($userObject->isUserExist($userVariables['user_name'],$userVariables['user_id']))
			{	
				$notificationArray['type'] = 'Failed';
				$notificationArray['message'] = showmsg('user','dup','username');
				$data['userVariables']=$userVariables;
			}
			else
			{
				if($_POST['edit_id']!=='')
				{					
					$userPassword = $userVariables['user_password'];
					unset($userVariables['user_password']);
					$previousPass = $userObject->getOne($userObject->tb1_name,'user_password',"user_id='".$userVariables['user_id']."'");				
					$sha1_currentpass = sha1($userPassword);
					if(!($sha1_currentpass==$previousPass)  && !($sha1_currentpass==sha1('********')))
					{
						$userVariables['user_password'] = $sha1_currentpass;						
					}					
					$userVariables['modified_by']=$_SESSION['user_id'];
					$userVariables['modified_date']=date('Y-m-d H:i:s');
					$userObject->update($userObject->tb1_name,$userVariables,'user_id');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] =  showmsg('user','update'); 				
				}
				else
				{				
					$userVariables['user_password']=sha1($userVariables['user_password']);
					$user_id=$userObject->insert($userObject->tb1_name,$userVariables);
					$userVariables['added_by']=$_SESSION['user_id'];
					$userVariables['added_date']=date('Y-m-d H:i:s');
					$notificationArray['type'] = 'Success';
					$notificationArray['message'] = showmsg('user','add');					
				}
			}			
			$str='';
			foreach($arr_grp as $val)
			{ $str.=$val.",";}
			$str=trim($str,",");
            $data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
			$data['allUsers'] = $userObject->getAll($userObject->tb1_name,'*','user_group<>'.EMPLOYEE_GRP_ID.' and user_group not in ('.$str.')',$data['show_status']);
			$data['allGroups']=$groupObject->getAll($groupObject->tb1_name,'*','group_id not in ('.$str.')');
			$data['rec_counts'] = $userObject->getRecordCountsUsers($arr_grp);
            $page="manage_users.php";
        break;
		
	case "delete":
		$userObject->delete($userObject->tb1_name,'user_id',$_POST['edit_id']);
		$notificationArray['type'] = 'Success';
		$notificationArray['message'] = showmsg('user','delete');
		$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
		$str='';
		foreach($arr_grp as $val)
		{ $str.=$val.",";}
		$str=trim($str,",");
		$data['allUsers'] = $userObject->getAll($userObject->tb1_name,'*','user_group<>'.EMPLOYEE_GRP_ID.' and user_group not in ('.$str.')',$data['show_status']);
		$data['allGroups']=$groupObject->getAll($groupObject->tb1_name,'*','group_id not in ('.$str.')');
		$data['rec_counts'] = $userObject->getRecordCountsUsers($arr_grp);
		$page="manage_users.php"; 
	break;
		
	case "restore":
		$userObject->restore($userObject->tb1_name,'user_id',$_POST['edit_id']);
		$notificationArray['type'] = 'Success';
		$notificationArray['message'] = showmsg('user','restore');	
		$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
		/*$arr_grp = unserialize (ARR_GRP);*/
		$str='';
		foreach($arr_grp as $val)
		{ $str.=$val.",";}
		$str=trim($str,",");
		$data['allUsers'] = $userObject->getAll($userObject->tb1_name,'*','user_group<>'.EMPLOYEE_GRP_ID.' and user_group not in ('.$str.')',$data['show_status']);
		$data['allGroups']=$groupObject->getAll($groupObject->tb1_name,'*','group_id not in ('.$str.')');
		$data['rec_counts'] = $userObject->getRecordCountsUsers($arr_grp);
        $page="manage_users.php";
	break;
}
?>