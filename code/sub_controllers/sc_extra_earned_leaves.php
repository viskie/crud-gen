<?php include_once('library/extra_earned_leavesManager.php');
					 $extra_earned_leavesObject= new Extra_earned_leavesManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);							
						$page='manage_extra_earned_leaves.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name);        
						   $data['extra_earned_leavesVariables']=$extra_earned_leavesObject->getRow($extra_earned_leavesObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);									
						$page='manage_extra_earned_leaves.php';break;
case 'save':
						$extra_earned_leavesVariables =  $extra_earned_leavesObject->getVariables($_POST);
						$primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name);        
						$extra_earned_leavesVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$extra_earned_leavesVariables['modified_by']=$_SESSION['user_id'];
							$extra_earned_leavesVariables['modified_date']=date('Y-m-d H:i:s');							
							$extra_earned_leavesObject->update($extra_earned_leavesObject->tb1_name,$extra_earned_leavesVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('extra_earned_leaves','update');
						}
						else
						{							
							$extra_earned_leavesVariables['added_by']=$_SESSION['user_id'];							
							$extra_earned_leavesVariables['is_active']=1;
							$primary_key=$extra_earned_leavesObject->insert($extra_earned_leavesObject->tb1_name,$extra_earned_leavesVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('extra_earned_leaves','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);									
						$page='manage_extra_earned_leaves.php';						
					break;
case 'delete':
						$primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name); 
						$extra_earned_leavesObject->delete($extra_earned_leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('extra_earned_leaves','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);								
						$page='manage_extra_earned_leaves.php';						
					break;
case 'restore':
						$primary_key = $extra_earned_leavesObject->getPrimaryKey($extra_earned_leavesObject->tb1_name); 
						$extra_earned_leavesObject->restore($extra_earned_leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('extra_earned_leaves','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allextra_earned_leaves'] = $extra_earned_leavesObject->getAll($extra_earned_leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $extra_earned_leavesObject->getRecordCounts($extra_earned_leavesObject->tb1_name);								
						$page='manage_extra_earned_leaves.php';						
					break;
}?>