<?php include_once('library/leave_typeManager.php');
					 $leave_typeObject= new Leave_typeManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);							
						$page='manage_leave_type.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $leave_typeObject->getPrimaryKey($leave_typeObject->tb1_name);        
						   $data['leave_typeVariables']=$leave_typeObject->getRow($leave_typeObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$page='add_edit_leave_type.php';break;
case 'save':
						$leave_typeVariables =  $leave_typeObject->getVariables($_POST);
						$primary_key = $leave_typeObject->getPrimaryKey($leave_typeObject->tb1_name);        
						$leave_typeVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$leave_typeVariables['modified_by']=$_SESSION['user_id'];
							$leave_typeVariables['modified_date']=date('Y-m-d H:i:s');							
							$leave_typeObject->update($leave_typeObject->tb1_name,$leave_typeVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('leave_type','update');
						}
						else
						{							
							$leave_typeVariables['added_by']=$_SESSION['user_id'];
							$leave_typeVariables['added_date']=date('Y-m-d H:i:s');
							$leave_typeVariables['is_active']=1;
							$primary_key=$leave_typeObject->insert($leave_typeObject->tb1_name,$leave_typeVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('leave_type','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);									
						$page='manage_leave_type.php';						
					break;
case 'delete':
						$primary_key = $leave_typeObject->getPrimaryKey($leave_typeObject->tb1_name); 
						$leave_typeObject->delete($leave_typeObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leave_type','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);								
						$page='manage_leave_type.php';						
					break;
case 'restore':
						$primary_key = $leave_typeObject->getPrimaryKey($leave_typeObject->tb1_name); 
						$leave_typeObject->restore($leave_typeObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leave_type','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);								
						$page='manage_leave_type.php';						
					break;
}?>