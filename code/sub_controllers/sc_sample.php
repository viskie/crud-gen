<?php include_once('library/sampleManager.php');
					 $sampleObject= new SampleManager();
switch($function){
case 'default':
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allsample'] = $sampleObject->getAll($sampleObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $sampleObject->getRecordCounts($sampleObject->tb1_name);							
						$page='manage_sample.php';						
					break;
case 'showform':
						if($_POST['edit_id']!==''){  
						   $primary_key = $sampleObject->getPrimaryKey($sampleObject->tb1_name);        
						   $data['sampleVariables']=$sampleObject->getRow($sampleObject->tb1_name,'*',$primary_key.'= "'.$_POST['edit_id'].'"');
						}$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allsample'] = $sampleObject->getAll($sampleObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $sampleObject->getRecordCounts($sampleObject->tb1_name);									
						$page='manage_sample.php';break;
case 'save':
						$sampleVariables =  $sampleObject->getVariables($_POST);
						$primary_key = $sampleObject->getPrimaryKey($sampleObject->tb1_name);        
						$sampleVariables[$primary_key] = $_POST['edit_id']; 						
						if($_POST['edit_id']!=='')
						{
							$sampleVariables['modified_by']=$_SESSION['user_id'];
							$sampleVariables['modified_date']=date('Y-m-d H:i:s');							
							$sampleObject->update($sampleObject->tb1_name,$sampleVariables,$primary_key);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] =  showmsg('sample','update');
						}
						else
						{							
							$sampleVariables['added_by']=$_SESSION['user_id'];							
							$sampleVariables['is_active']=1;
							$primary_key=$sampleObject->insert($sampleObject->tb1_name,$sampleVariables);
							$notificationArray['type'] = 'Success';
							$notificationArray['message'] = showmsg('sample','add');
						}
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allsample'] = $sampleObject->getAll($sampleObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $sampleObject->getRecordCounts($sampleObject->tb1_name);									
						$page='manage_sample.php';						
					break;
case 'delete':
						$primary_key = $sampleObject->getPrimaryKey($sampleObject->tb1_name); 
						$sampleObject->delete($sampleObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('sample','delete');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allsample'] = $sampleObject->getAll($sampleObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $sampleObject->getRecordCounts($sampleObject->tb1_name);								
						$page='manage_sample.php';						
					break;
case 'restore':
						$primary_key = $sampleObject->getPrimaryKey($sampleObject->tb1_name); 
						$sampleObject->restore($sampleObject->tb1_name,$primary_key,$_POST['edit_id']);
						$notificationArray['type'] = 'Success';
						$notificationArray['message'] = showmsg('sample','restore');
						$data['show_status']=isset($_POST['show_status'])?$_POST['show_status']:1;		
						$data['allsample'] = $sampleObject->getAll($sampleObject->tb1_name,'*','',$data['show_status']);		
						$data['rec_counts'] = $sampleObject->getRecordCounts($sampleObject->tb1_name);								
						$page='manage_sample.php';						
					break;
}?>