<?php 
include_once('library/hrmManager.php');
$hrmObject= new HrmManager();
include_once('library/leavesManager.php');
$leavesObject= new LeavesManager();
include_once('library/leave_typeManager.php');
$leave_typeObject= new Leave_typeManager();
include_once('library/extra_earned_leavesManager.php');
$extra_earned_leavesObject= new Extra_earned_leavesManager();

switch($function){
		case 'default':
			$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
			$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);
			$data['leave_type']	= $hrmObject->getleavetypes();	
			$data['rec_counts'] = $hrmObject->getRecordCounts($hrmObject->tb1_name);	
			$data['fields'] = 	$hrmObject->view_fields;
			$data['edit_fields'] = 	$hrmObject->edit_fields;		
			$page='manage_hrm.php';						
		break;
		case 'showform':
			if($_POST['edit_id']!==''){  
			   $primary_key = $hrmObject->getPrimaryKey($hrmObject->tb1_name);        
			   $data['hrmVariables']=$hrmObject->getRow($hrmObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
			}
			$data['leave_type']	= $hrmObject->getleavetypes();
			$data['total_leaves'] = $hrmObject->getleaves($_POST['edit_id']);			
			$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
			$data['fields'] = 	$hrmObject->view_fields;				
			$page='add_edit_employee.php';						
		break;
		case 'save':
		//echo $_POST['edit_id'];exit;
			$hrmVariables =  $hrmObject->getVariables($_POST);
			$hrmVariables['joining_date'] = $_POST['joining_date_alt'];
			$hrmVariables['date_of_birth'] = $_POST['dob_alt'];
			//printr($_POST); printr($hrmVariables); exit;
			
			$upload_dir = "uploads";
			if(!is_dir($upload_dir."/photo")){
				mkdir($upload_dir."/photo");
			}
			if(!is_dir($upload_dir."/cv")){
				mkdir($upload_dir."/cv");
			}
			foreach($_FILES as $key=>$value){
				if($value['tmp_name'] == ""){
					$notificationArray['type'] = 'Failed';
					$notificationArray['message'] = "Please select file";
				}else{
					//if($value['type'] == ""){}
					if($key =='photo_img'){
						if(!move_uploaded_file($value['tmp_name'],$upload_dir."/photo/".$value['name'])){
							echo "Failed to upload =>".$value['name'];
						}else { $hrmVariables['photo_img']=$upload_dir."/photo/".$value['name']; }
					}else{
						if(!move_uploaded_file($value['tmp_name'],$upload_dir."/cv/".$value['name'])){
							echo "Failed to upload =>".$value['name'];
						}else { $hrmVariables['sign_img']=$upload_dir."/cv/".$value['name']; }
					}
				}
			}	
			$data['leave_type']	= $hrmObject->getleavetypes();		
			if($_POST['edit_id']!=='')
			{
				$primary_key = $hrmObject->getPrimaryKey($hrmObject->tb1_name);        
				$hrmVariables[$primary_key] = $_POST['edit_id'];
				$hrmVariables['modified_by']=$_SESSION['user_id'];
				$hrmVariables['modified_date']=date('Y-m-d H:i:s');							
				$hrmObject->update($hrmObject->tb1_name,$hrmVariables,$primary_key);
				$hrmObject->delete($hrmObject->tb3_name,'emp_id',$_POST['edit_id'],'',true);
				foreach($data['leave_type'] as $k=>$v)
				{
					$arr_total_leaves = array(
										'emp_id' => $_POST['edit_id'],
										'leave_type_id' => $v['id'],
										'total_leaves' => $_POST['total_'.$v['id']],
										'year_id' => $current_year,
										'modified_by'=> $_SESSION['user_id'],
										'modified_date'=> date('Y-m-d H:i:s')
										);
					$hrmObject->insert($hrmObject->tb3_name,$arr_total_leaves);
				}
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] =  showmsg('hrm','update');
			}
			else
			{
				$hrmVariables['added_by']=$_SESSION['user_id'];
				$hrmVariables['added_date']=date('Y-m-d H:i:s');
				$hrmVariables['is_active']=1;
				$emp_id=$hrmObject->insert($hrmObject->tb1_name,$hrmVariables);
				foreach($data['leave_type'] as $k=>$v)
				{
					$arr_total_leaves = array(
										'emp_id' => $_POST['edit_id'],
										'leave_type_id' => $v['id'],
										'total_leaves' => $_POST['total_'.$v['id']],
										'year_id' => $current_year,
										'added_by'=> $_SESSION['user_id']										
										);
					$hrmObject->insert($hrmObject->tb3_name,$arr_total_leaves);
				}
				$hrmVariables['id']=$emp_id;	
				$notificationArray['type'] = 'Success';
				$notificationArray['message'] = showmsg('hrm','add');
			}			
				
			$data['hrmVariables']=$hrmVariables;			
			$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
			$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);		
			$data['rec_counts'] = $hrmObject->getRecordCounts($hrmObject->tb1_name);
			$data['fields'] = 	$hrmObject->view_fields;
			$data['save_emp'] = $_POST['save_emp'];
			if(isset($_POST['save_emp']) && $_POST['save_emp'] == 3)
			{				
				$page='manage_hrm.php';	
			}
			else
			{
				$data['total_leaves'] = $hrmObject->getleaves($_POST['edit_id']);
				$page='add_edit_employee.php';					
			}
		break;
		case 'delete':
			$primary_key = $hrmObject->getPrimaryKey($hrmObject->tb1_name); 
			$hrmObject->delete($hrmObject->tb1_name,$primary_key,$_POST['edit_id']);
			$notificationArray['type'] = 'Success';
			$notificationArray['message'] = showmsg('hrm','delete');
			$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
			$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);		
			$data['rec_counts'] = $hrmObject->getRecordCounts($hrmObject->tb1_name);	
			$data['fields'] = 	$hrmObject->view_fields;			
			$page='manage_hrm.php';						
		break;
		case 'restore':
			$primary_key = $hrmObject->getPrimaryKey($hrmObject->tb1_name); 
			$hrmObject->restore($hrmObject->tb1_name,$primary_key,$_POST['edit_id']);
			$notificationArray['type'] = 'Success';
			$notificationArray['message'] = showmsg('hrm','restore');
			$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
			$data['leave_type']	= $hrmObject->getleavetypes();		
			$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);		
			$data['rec_counts'] = $hrmObject->getRecordCounts($hrmObject->tb1_name);	
			$data['fields'] = 	$hrmObject->view_fields;			
			$page='manage_hrm.php';						
		break;
		
		case 'view_employee_leaves':
		
			include_once('library/dashboardManager.php');
			$dashboardObject= new dashboardManager();
		
			$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
			$employee_id = $_POST['edit_id'];
			$data['employee_id'] = $employee_id;  
			$emp_array[] = array('id' =>$employee_id);
			//array_push($emp_array,$employee_id); //printr($emp_array); exit;
			$data['leave_type']	= $dashboardObject->getleavetypes();
			$data['total_leaves'] = $dashboardObject->getleaves($emp_array);
			$data['leaves_taken'] = $dashboardObject->getleavestaken($emp_array);
			$data['employee_details'] = $hrmObject->getAll($hrmObject->tb1_name.' left join  (select id,employee_id,leave_type,leave_from,leave_to,comment from leaves) as leaves  on leaves.employee_id = employee.id left join (select id,leave_type from leave_type) as leave_type  on leaves.leave_type = leave_type.id','*',' employee.id='.$employee_id,$data['show_status'],$is_join=1,0);
			$page='view_employee_leaves.php';
		break;
		
		// manage Leaves
		case 'default_leaves':
						
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = 'leaves.is_active='.$data['show_status'];
						}
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name.' left join (select id as leave_type_id,leave_type from leave_type ) as leave_type on leaves.leave_type = leave_type.leave_type_id left join (select id as emp_id ,employee_name from employee) as employee on leaves.employee_id = employee.emp_id','leaves.*,leave_type.*,employee.*',$cond,$data['show_status'],$is_join=1,0);
						
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);
						//printr($data['allleaves']);echo "<br/>";
						//printr($data['rec_counts']);
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);	
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);							
						$page='manage_leaves.php';						
					break;
		case 'showform_leaves':
						if($_POST['edit_id']!==''){  
						   $primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name);  
						   $data['leavesVariables']=$leavesObject->getRow($leavesObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = 'leaves.is_active='.$data['show_status'];
						}
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name.' left join (select id as leave_type_id,leave_type from leave_type ) as leave_type on leaves.leave_type = leave_type.leave_type_id left join (select id as emp_id ,employee_name from employee) as employee on leaves.employee_id = employee.emp_id','leaves.*,leave_type.*,employee.*',$cond,$data['show_status'],$is_join=1,0);
						
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);		
						
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);	
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);								
						$page='manage_leaves.php';break;
		case 'save_leaves':
						$leavesVariables =  $leavesObject->getVariables($_POST);
						$primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name);        
						$leavesVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$leavesVariables['modified_by']=$_SESSION['user_id'];
							$leavesVariables['modified_date']=date('Y-m-d H:i:s');
							
							$leavesVariables['employee_id']=$_POST['employee_id'];
							$leavesVariables['leave_type']=$_POST['leave_type'];
							$leavesVariables['leave_from']=$_POST['leave_from_alt'];
							$leavesVariables['leave_to']=$_POST['leave_to_alt'];
							$leavesVariables['total_days']=$_POST['total_days'];
							$leavesVariables['comment']=$_POST['comment'];
													
							$leavesObject->update($leavesObject->tb1_name,$leavesVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('leaves','update');
						}
						else
						{							
							$leavesVariables['added_by']=$_SESSION['user_id'];
							$leavesVariables['added_date']=date('Y-m-d H:i:s');
							$leavesVariables['is_active']=1;
							
							$leavesVariables['employee_id']=$_POST['employee_id'];
							$leavesVariables['leave_type']=$_POST['leave_type'];
							$leavesVariables['leave_from']=$_POST['leave_from_alt'];
							$leavesVariables['leave_to']=$_POST['leave_to_alt'];
							$leavesVariables['total_days']=$_POST['total_days'];
							$leavesVariables['comment']=$_POST['comment'];
							$leavesVariables['year_id']=$current_year;
							
							$primary_key=$leavesObject->insert($leavesObject->tb1_name,$leavesVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('leaves','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = 'leaves.is_active='.$data['show_status'];
						}
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name.' left join (select id as leave_type_id,leave_type from leave_type ) as leave_type on leaves.leave_type = leave_type.leave_type_id left join (select id as emp_id ,employee_name from employee) as employee on leaves.employee_id = employee.emp_id','leaves.*,leave_type.*,employee.*',$cond,$data['show_status'],$is_join=1,0);
						
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);	
						
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);	
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);								
						$page='manage_leaves.php';						
					break;
		case 'delete_leaves':
						$primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name); 
						$leavesObject->delete($leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leaves','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = 'leaves.is_active='.$data['show_status'];
						}
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name.' left join (select id as leave_type_id,leave_type from leave_type ) as leave_type on leaves.leave_type = leave_type.leave_type_id left join (select id as emp_id ,employee_name from employee) as employee on leaves.employee_id = employee.emp_id','leaves.*,leave_type.*,employee.*',$cond,$data['show_status'],$is_join=1,0);
						
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);	
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);								
						$page='manage_leaves.php';						
					break;
		case 'restore_leaves':
						$primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name); 
						$leavesObject->restore($leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leaves','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = 'leaves.is_active='.$data['show_status'];
						}
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name.' left join (select id as leave_type_id,leave_type from leave_type ) as leave_type on leaves.leave_type = leave_type.leave_type_id left join (select id as emp_id ,employee_name from employee) as employee on leaves.employee_id = employee.emp_id','leaves.*,leave_type.*,employee.*',$cond,$data['show_status'],$is_join=1,0);
						
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);	
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);	
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);							
						$page='manage_leaves.php';						
					break;
					
		// Extra earned leaves	
		case 'default_extra_earned_leaves':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);			
						//$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = $extra_earned_leavesObject->tb1_name.'.is_active='.$data['show_status'];
						}	
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name.' left join (select id,employee_name from employee ) as employee on employee.id = '.$extra_earned_leavesObject->tb1_name.'.employee_id','*',$cond,$data['show_status'],$is_join=1,0);						
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);							
						$page='manage_extra_earned_leaves.php';						
					break;
		case 'showform_extra_earned_leaves':
						if($_POST['edit_id']!==''){  
						   $primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name);        
						   $data['extra_earned_leavesVariables']=$extra_earned_leavesObject->getRow($extra_earned_leavesObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);		
						//$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = $extra_earned_leavesObject->tb1_name.'.is_active='.$data['show_status'];
						}	
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name.' left join (select id,employee_name from employee ) as employee on employee.id = '.$extra_earned_leavesObject->tb1_name.'.employee_id','*',$cond,$data['show_status'],$is_join=1,0);						
						
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);									
						$page='manage_extra_earned_leaves.php';break;
		case 'save_extra_earned_leaves':
						$extra_earned_leavesVariables =  $extra_earned_leavesObject->getVariables($_POST);
						$extra_earned_leavesVariables['date'] = $_POST['date_alt'];
						$primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name);        
						$extra_earned_leavesVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							//$hrmObject->update($hrmObject->tb3_name,$hrmVariables,$primary_key);
							
							$extra_earned_leavesVariables['modified_by']=$_SESSION['user_id'];
							$extra_earned_leavesVariables['modified_date']=date('Y-m-d H:i:s');							
							$extra_earned_leavesObject->update($extra_earned_leavesObject->tb1_name,$extra_earned_leavesVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('Extra Earned Leaves','update');
						}
						else
						{	//echo $_POST['employee_id'];exit;
							$primary_key = $hrmObject->getPrimaryKey($hrmObject->tb3_name);
							$record = $hrmObject->getEarnedLeavesRecord($_POST['employee_id']);
							//printr($record);exit;
							$changed_data = array(
									'id' => $record['id'],
									'total_leaves' => $record['total_leaves'] + 1
									);
							$hrmObject->update($hrmObject->tb3_name,$changed_data,$primary_key);
											
							$extra_earned_leavesVariables['added_by']=$_SESSION['user_id'];							
							$extra_earned_leavesVariables['is_active']=1;
							$primary_key=$extra_earned_leavesObject->insert($extra_earned_leavesObject->tb1_name,$extra_earned_leavesVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('Extra Earned Leaves','add');
						}
						
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						//$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);
						//printr($data['allextra_earned_leaves']);exit;	
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = $extra_earned_leavesObject->tb1_name.'.is_active='.$data['show_status'];
						}	
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name.' left join (select id,employee_name from employee ) as employee on employee.id = '.$extra_earned_leavesObject->tb1_name.'.employee_id','*',$cond,$data['show_status'],$is_join=1,0);						
								
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);										
						$page='manage_extra_earned_leaves.php';						
					break;
	case 'delete_extra_earned_leaves':
	
						$primary_key1 = $hrmObject->getPrimaryKey($hrmObject->tb3_name);
							$record = $hrmObject->getEarnedLeavesRecord($_POST['edit_id']);
							//printr($record);exit;
							$changed_data = array(
									'id' => $record['id'],
									'total_leaves' => $record['total_leaves'] - 1
									);
							$hrmObject->update($hrmObject->tb3_name,$changed_data,$primary_key1);
		
						$primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name); 
						$extra_earned_leavesObject->delete($extra_earned_leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Extra Earned Leaves','delete');
						
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						//$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = $extra_earned_leavesObject->tb1_name.'.is_active='.$data['show_status'];
						}	
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name.' left join (select id,employee_name from employee ) as employee on employee.id = '.$extra_earned_leavesObject->tb1_name.'.employee_id','*',$cond,$data['show_status'],$is_join=1,0);						
						
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);									
						$page='manage_extra_earned_leaves.php';						
					break;
	case 'restore_extra_earned_leaves':
						$primary_key1 = $hrmObject->getPrimaryKey($hrmObject->tb3_name);
							$record = $hrmObject->getEarnedLeavesRecord($_POST['edit_id']);
							//printr($record);exit;
							$changed_data = array(
									'id' => $record['id'],
									'total_leaves' => $record['total_leaves'] + 1
									);
							$hrmObject->update($hrmObject->tb3_name,$changed_data,$primary_key1);
						
						$primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name); 
						$extra_earned_leavesObject->restore($extra_earned_leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('Extra Earned Leaves','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						//$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$cond = '';
						if($data['show_status']!=2)
						{
							$cond = $extra_earned_leavesObject->tb1_name.'.is_active='.$data['show_status'];
						}	
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name.' left join (select id,employee_name from employee ) as employee on employee.id = '.$extra_earned_leavesObject->tb1_name.'.employee_id','*',$cond,$data['show_status'],$is_join=1,0);						
						
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);
						$data['allhrm'] = $hrmObject->getAll($hrmObject->tb1_name,'*','',$data['show_status']);									
						$page='manage_extra_earned_leaves.php';						
					break;
		
}?>