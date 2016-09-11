<?php include_once('library/leave_typeManager.php');
$leave_typeObject= new Leave_typeManager();
include_once('library/candidate_positionManager.php');
$candidate_positionObject= new Candidate_positionManager();
include_once('library/candidate_statusManager.php');
$candidate_statusObject= new Candidate_statusManager();

switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);							
						$page='manage_leave_type.php';						
					break;
case 'showform':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;	
						if($_POST['edit_id']!==''){  
						   $primary_key = $leave_typeObject->getPrimaryKey($leave_typeObject->tb1_name);        
						   $data['leave_typeVariables']=$leave_typeObject->getRow($leave_typeObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);	
						$page='manage_leave_type.php';
					break;
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
							$notificationArray['message'] =  showmsg('leave Type','update');
						}
						else
						{							
							$leave_typeVariables['added_by']=$_SESSION['user_id'];
							$leave_typeVariables['added_date']=date('Y-m-d H:i:s');
							$leave_typeVariables['is_active']=1;
							$primary_key=$leave_typeObject->insert($leave_typeObject->tb1_name,$leave_typeVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('leave Type','add');
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
						$notificationArray['message'] = showmsg('leave Type','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);								
						$page='manage_leave_type.php';						
					break;
case 'restore':
						$primary_key = $leave_typeObject->getPrimaryKey($leave_typeObject->tb1_name); 
						$leave_typeObject->restore($leave_typeObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leave Type','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleave_type'] = $leave_typeObject->getAll($leave_typeObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leave_typeObject->getRecordCounts($leave_typeObject->tb1_name);								
						$page='manage_leave_type.php';						
					break;
					
// candidate position
case 'default_position':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);							
						$page='manage_candidate_position.php';						
					break;
case 'showform_position':
						//echo "---------".$_POST['edit_id'];
						if($_POST['edit_id']!==''){  
						   $primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name);        
						   $data['candidate_positionVariables']=$candidate_positionObject->getRow($candidate_positionObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}
						//printr($data['candidate_positionVariables']);exit;
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);									
						$page='manage_candidate_position.php';break;
case 'save_position':
						$candidate_positionVariables =  $candidate_positionObject->getVariables($_POST);
						$primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name);        
						$candidate_positionVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$candidate_positionVariables['modified_by']=$_SESSION['user_id'];
							$candidate_positionVariables['modified_date']=date('Y-m-d H:i:s');							
							$candidate_positionObject->update($candidate_positionObject->tb1_name,$candidate_positionVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('candidate Position','update');
						}
						else
						{							
							$candidate_positionVariables['added_by']=$_SESSION['user_id'];							
							$candidate_positionVariables['is_active']=1;
							$primary_key=$candidate_positionObject->insert($candidate_positionObject->tb1_name,$candidate_positionVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('candidate Position','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);									
						$page='manage_candidate_position.php';						
					break;
case 'delete_position':
						$primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name); 
						$candidate_positionObject->delete($candidate_positionObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate Position','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);								
						$page='manage_candidate_position.php';						
					break;
case 'restore_position':
						$primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name); 
						$candidate_positionObject->restore($candidate_positionObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate Position','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);								
						$page='manage_candidate_position.php';						
					break;
					
			// candidate_status
case 'default_status':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);							
						$page='manage_candidate_status.php';						
					break;
case 'showform_status':
						if($_POST['edit_id']!==''){  
						   $primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name);        
						   $data['candidate_statusVariables']=$candidate_statusObject->getRow($candidate_statusObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);									
						$page='manage_candidate_status.php';break;
case 'save_status':
						$candidate_statusVariables =  $candidate_statusObject->getVariables($_POST);
						$primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name);        
						$candidate_statusVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$candidate_statusVariables['modified_by']=$_SESSION['user_id'];
							$candidate_statusVariables['modified_date']=date('Y-m-d H:i:s');							
							$candidate_statusObject->update($candidate_statusObject->tb1_name,$candidate_statusVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('candidate Status','update');
						}
						else
						{							
							$candidate_statusVariables['added_by']=$_SESSION['user_id'];							
							$candidate_statusVariables['is_active']=1;
							$primary_key=$candidate_statusObject->insert($candidate_statusObject->tb1_name,$candidate_statusVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('candidate Status','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);									
						$page='manage_candidate_status.php';						
					break;
case 'delete_status':
						$primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name); 
						$candidate_statusObject->delete($candidate_statusObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate Status','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);								
						$page='manage_candidate_status.php';						
					break;
case 'restore_status':
						$primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name); 
						$candidate_statusObject->restore($candidate_statusObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate Status','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);								
						$page='manage_candidate_status.php';						
					break;								
}?>