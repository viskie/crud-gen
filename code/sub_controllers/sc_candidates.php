<?php include_once('library/candidatesManager.php');
					 $candidatesObject= new CandidatesManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidates'] = $candidatesObject->getAllCandidates($data['show_status']);		
						$data['rec_counts'] = $candidatesObject->getRecordCounts($candidatesObject->tb1_name);
						$data['allposition'] = $candidatesObject->getAllpositions();
						$data['allstatus'] = $candidatesObject->getAllstatus();						
						$page='manage_candidates.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $candidatesObject->getPrimaryKey($candidatesObject->tb1_name);        
						   $data['candidatesVariables']=$candidatesObject->getRow($candidatesObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}
						$data['allposition'] = $candidatesObject->getAllpositions();
						$data['allstatus'] = $candidatesObject->getAllstatus();
						$page='add_edit_candidates.php';
						break;
case 'save':
						$candidatesVariables =  $candidatesObject->getVariables($_POST);
						$primary_key = $candidatesObject->getPrimaryKey($candidatesObject->tb1_name);        
						$candidatesVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$candidatesVariables['modified_by']=$_SESSION['user_id'];
							$candidatesVariables['modified_date']=date('Y-m-d H:i:s');							
							$candidatesObject->update($candidatesObject->tb1_name,$candidatesVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('candidates','update');
						}
						else
						{							
							$candidatesVariables['added_by']=$_SESSION['user_id'];
							$candidatesVariables['added_date']=date('Y-m-d H:i:s');
							$candidatesVariables['is_active']=1;
							$primary_key=$candidatesObject->insert($candidatesObject->tb1_name,$candidatesVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('candidates','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidates'] = $candidatesObject->getAllCandidates($data['show_status']);		
						$data['rec_counts'] = $candidatesObject->getRecordCounts($candidatesObject->tb1_name);
						$data['allposition'] = $candidatesObject->getAllpositions();
						$data['allstatus'] = $candidatesObject->getAllstatus();							
						$page='manage_candidates.php';						
					break;
case 'delete':
						$primary_key = $candidatesObject->getPrimaryKey($candidatesObject->tb1_name); 
						$candidatesObject->delete($candidatesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidates','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidates'] = $candidatesObject->getAllCandidates($data['show_status']);	
						$data['rec_counts'] = $candidatesObject->getRecordCounts($candidatesObject->tb1_name);
						$data['allposition'] = $candidatesObject->getAllpositions();
						$data['allstatus'] = $candidatesObject->getAllstatus();								
						$page='manage_candidates.php';						
					break;
case 'restore':
						$primary_key = $candidatesObject->getPrimaryKey($candidatesObject->tb1_name); 
						$candidatesObject->restore($candidatesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('candidates','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allcandidates'] = $candidatesObject->getAllCandidates($data['show_status']);	
						$data['rec_counts'] = $candidatesObject->getRecordCounts($candidatesObject->tb1_name);	
						$data['allposition'] = $candidatesObject->getAllpositions();
						$data['allstatus'] = $candidatesObject->getAllstatus();							
						$page='manage_candidates.php';						
					break;
}?>