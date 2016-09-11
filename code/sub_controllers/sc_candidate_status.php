<?php include_once('library/candidate_statusManager.php');
					 $candidate_statusObject= new Candidate_statusManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);							
						$page='manage_candidate_status.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name);        
						   $data['candidate_statusVariables']=$candidate_statusObject->getRow($candidate_statusObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);									
						$page='manage_candidate_status.php';break;
case 'save':
						$candidate_statusVariables =  $candidate_statusObject->getVariables($_POST);
						$primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name);        
						$candidate_statusVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$candidate_statusVariables['modified_by']=$_SESSION['user_id'];
							$candidate_statusVariables['modified_date']=date('Y-m-d H:i:s');							
							$candidate_statusObject->update($candidate_statusObject->tb1_name,$candidate_statusVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('candidate_status','update');
						}
						else
						{							
							$candidate_statusVariables['added_by']=$_SESSION['user_id'];							
							$candidate_statusVariables['is_active']=1;
							$primary_key=$candidate_statusObject->insert($candidate_statusObject->tb1_name,$candidate_statusVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('candidate_status','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);									
						$page='manage_candidate_status.php';						
					break;
case 'delete':
						$primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name); 
						$candidate_statusObject->delete($candidate_statusObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate_status','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);								
						$page='manage_candidate_status.php';						
					break;
case 'restore':
						$primary_key = $candidate_statusObject->getPrimaryKey($candidate_statusObject->tb1_name); 
						$candidate_statusObject->restore($candidate_statusObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidate_status','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidate_status'] = $candidate_statusObject->getAll($candidate_statusObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $candidate_statusObject->getRecordCounts($candidate_statusObject->tb1_name);								
						$page='manage_candidate_status.php';						
					break;
}?>