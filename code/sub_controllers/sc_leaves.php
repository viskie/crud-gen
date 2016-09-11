<?php include_once('library/leavesManager.php');
					 $leavesObject= new LeavesManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);							
						$page='manage_leaves.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name);        
						   $data['leavesVariables']=$leavesObject->getRow($leavesObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);									
						$page='manage_leaves.php';break;
case 'save':
						$leavesVariables =  $leavesObject->getVariables($_POST);
						$primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name);        
						$leavesVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$leavesVariables['modified_by']=$_SESSION['user_id'];
							$leavesVariables['modified_date']=date('Y-m-d H:i:s');							
							$leavesObject->update($leavesObject->tb1_name,$leavesVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('leaves','update');
						}
						else
						{							
							$leavesVariables['added_by']=$_SESSION['user_id'];
							$leavesVariables['added_date']=date('Y-m-d H:i:s');
							$leavesVariables['is_active']=1;
							$primary_key=$leavesObject->insert($leavesObject->tb1_name,$leavesVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('leaves','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);									
						$page='manage_leaves.php';						
					break;
case 'delete':
						$primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name); 
						$leavesObject->delete($leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leaves','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);								
						$page='manage_leaves.php';						
					break;
case 'restore':
						$primary_key = $leavesObject->getPrimaryKey($leavesObject->tb1_name); 
						$leavesObject->restore($leavesObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('leaves','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allleaves'] = $leavesObject->getAll($leavesObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $leavesObject->getRecordCounts($leavesObject->tb1_name);								
						$page='manage_leaves.php';						
					break;
}?>