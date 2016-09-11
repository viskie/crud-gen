<?php include_once('library/candidate_positionManager.php');
					 $candidate_positionObject= new Candidate_positionManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);							
						$page='manage_candidate_position.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name);        
						   $data['candidate_positionVariables']=$candidate_positionObject->getRow($candidate_positionObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);									
						$page='manage_candidate_position.php';break;
case 'save':
						$candidate_positionVariables =  $candidate_positionObject->getVariables($_POST);
						$primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name);        
						$candidate_positionVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$candidate_positionVariables['modified_by']=$_SESSION['user_id'];
							$candidate_positionVariables['modified_date']=date('Y-m-d H:i:s');							
							$candidate_positionObject->update($candidate_positionObject->tb1_name,$candidate_positionVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('candidate_position','update');
						}
						else
						{							
							$candidate_positionVariables['added_by']=$_SESSION['user_id'];							
							$candidate_positionVariables['is_active']=1;
							$primary_key=$candidate_positionObject->insert($candidate_positionObject->tb1_name,$candidate_positionVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('candidate_position','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);									
						$page='manage_candidate_position.php';						
					break;
case 'delete':
						$primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name); 
						$candidate_positionObject->delete($candidate_positionObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate_position','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);								
						$page='manage_candidate_position.php';						
					break;
case 'restore':
						$primary_key = $candidate_positionObject->getPrimaryKey($candidate_positionObject->tb1_name); 
						$candidate_positionObject->restore($candidate_positionObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate_position','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_position'] = $candidate_positionObject->getAll($candidate_positionObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_positionObject->getRecordCounts($candidate_positionObject->tb1_name);								
						$page='manage_candidate_position.php';						
					break;
}?>