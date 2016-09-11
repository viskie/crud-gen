<?php
	$host="localhost";
	$user="vishak_hrm";
	$pass="hR{mBv_Wtx$(";
	$database="vishak_HRM";
	
	/*$host="localhost";
	$user="root";
	$pass="";
	$database="vishakhrm";*/
	
	include_once('library/commonManager.php');
	include_once('library/commonFunctions.php');	
	
	CommonManager::initDb(new mysqli($host,$user,$pass,$database));
	 
	include_once('library/dashboardManager.php');
	$dashboardObject= new dashboardManager();	
	include_once('library/hrmManager.php');
	$hrmObject= new HrmManager();
	
									
	$result1 = $dashboardObject->getAll('emp_total_leaves','id,total_leaves,leave_type_id',$condition="`leave_type_id` in (SELECT `id` FROM `leave_type` WHERE `leave_type` in ('sick','earned'))");
	
	$primary_key = $dashboardObject->getPrimaryKey('emp_total_leaves'); 
	
	foreach($result1 as $key1 => $value1)
	{
		$var[$primary_key] = $value1[$primary_key];
		$var['total_leaves'] = $value1['total_leaves'] + 0.5;
		$dashboardObject->update('emp_total_leaves',$var,$primary_key);
	}
	
	$result2 = $dashboardObject->getAll('employee','id,employee_name,personal_email',$condition="",$is_active=1,$is_join=0,$showQuery=false,$is_getRow=false);
	
	$data['leave_type']	= $dashboardObject->getleavetypes();
	
	foreach($result2 as $key2 => $value2)
	{
		$emp_array = array();
		array_push($emp_array,$value2['id']);
		
	$data['total_leaves'] = $dashboardObject->getleaves($emp_array);
	$data['leaves_taken'] = $dashboardObject->getleavestaken($emp_array);
	$data['employee_details'] = $hrmObject->getAll('employee left join  (select id,employee_id,leave_type,leave_from,leave_to,comment from leaves) as leaves  on leaves.employee_id = employee.id left join (select id,leave_type from leave_type) as leave_type  on leaves.leave_type = leave_type.id','*',' employee.id='.$value2['id'],$isactive=1,$is_join=1,0);
	
	
	$to = $value2['company_email'];
	
	$subject = "Leave Tracker of ".date('M Y');
	
	$message = "Leaves till date ".date('j-M-Y')."\n\n";
	$message.='<table cellpadding="6" cellspacing="0" align="center" style="width:90%" border="1" class="tbl_leaves">
				<tr>
					<th>&nbsp;</th><th>Total Leaves</th><th>Taken Leaves</th><th>Remaining Leaves</th>
				</tr>';
			   foreach($data['leave_type'] as $key=>$value)
				{	$remaining = ($data['total_leaves'][$value2['id']][$value['leave_type']] - $data['leaves_taken'][$value2['id']][$value['leave_type']]);
					$message.= "<tr>
							<th align='center'>".$value['leave_type']."</th>
							<td align='center'>".$data['total_leaves'][$value2['id']][$value['leave_type']]."</td>
							<td align='center'>".$data['leaves_taken'][$value2['id']][$value['leave_type']]."</td>
							<td align='center'>".$remaining."</td>
						 </tr>";
				}
     $message .= "</table>";
	
	$header = "From:admin@vishak.com \r\n"."Content-Type: text/html; charset=UTF-8 \r\n";
	$retval = mail ($to,$subject,$message,$header);
	
	}
?>