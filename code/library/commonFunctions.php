<?PHP
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php"); 
}

function showError($error)
{
	echo  $error;
}
function formatDate($date)
{
	if($date=="0000-00-00"){
		return "-";
	}else{
		return date("d-M-Y", strtotime($date));
	}
}	
function formatDateTime($date)
{
	if($date=="0000-00-00 00:00:00"){
		return "-";
	}else{
		return date("d-M-Y h:i A", strtotime($date));
	}
}
/*function purifyInputs()
{
	foreach($_REQUEST as $key=>$value)
	{
		if(is_array($value)){	//The function is giving error when passed array of checkboxes in query string.
			foreach($value as $keySub => $valueSub){
				if(is_array($valueSub)){
					foreach($valueSub as $key_sub_sub => $val_sub_sub){
						$value[$key_sub_sub] = mysqli_real_escape_string(trim($val_sub_sub));	
					}
				}
				else{
					$value[$keySub] = mysqli_real_escape_string(trim($valueSub));
				}
			}
		}else{
			$_REQUEST[$key] = mysqli_real_escape_string(trim($value));
		}
	}
}*/
function setPage()
{
	$page = $_POST['page'];
	if($page == 'home')
		$page = "home.php";
	else	
		$page = "manage_".$page.".php";	
	
	return $page;
}	
function setFunction()
{
	$function = $_POST['function'];		
	return $function;
}	
function setModule()
{
	$module = $_POST['page'];		
	return $module;
}
function callheader($file_name)
{
	ob_end_clean();
	header("Location: ".$file_name);
	exit;
}
function createComboBox($name,$value,$display, $data, $blankField=false, $selectedValue="",$display2="",$firstFieldValue='Please Select', $otherParameters = "")
{
	echo "<select id='".$name."' name = '".$name."' ".$otherParameters." >";
	if($blankField){
		echo "<option value=''>".$firstFieldValue."</option>";
	}
	for($d=0;$d<sizeof($data);$d++)
	{
		$selectedString = "";
		$selectedValue = trim($selectedValue);
		if($data[$d][$value] == $selectedValue)
		{
			$selectedString = " selected = 'selected' ";
		}
		
		echo "<option value='".$data[$d][$value]."' ".$selectedString.">".$data[$d][$display];
		if($display2!=""){
			echo " (".$data[$d][$display2].")";
		}
		echo "</option>";
	}
	echo "</select>";
}
function secondsToTime($seconds,$is_hms_padded=false)
{
	// extract hours
	$hours = floor($seconds / (60 * 60));
 
	// extract minutes
	$divisor_for_minutes = $seconds % (60 * 60);
	$minutes = floor($divisor_for_minutes / 60);
 
	// extract the remaining seconds
	$divisor_for_seconds = $divisor_for_minutes % 60;
	$seconds = ceil($divisor_for_seconds);
	
	// return the final array
	if($is_hms_padded==true)
	{	$obj = array(
			"h" => str_pad((int) $hours,2,"0",STR_PAD_LEFT),
			"m" => str_pad((int) $minutes,2,"0",STR_PAD_LEFT),
			"s" => str_pad((int) $seconds,2,"0",STR_PAD_LEFT)
		);
		
	}
 
	else
		{$obj = array(
			"h" => (int) $hours,
			"m" => (int) $minutes,
			"s" => (int) $seconds,
		);
	}
	return $obj;
}
function getDateTimeDiff($date1,$date2,$is_hms=false,$is_hms_padded=false)
{
	$seconds = strtotime($date1) - strtotime($date2); 
	if($is_hms==true)	
	{
		if($is_hms_padded==true)
		{	
			$diff = secondsToTime($seconds,true);
		}
		else
		{	$diff = secondsToTime($seconds);
		}
		
		return $diff;
	}
	else
	{
		return ($seconds);   // returns diff in seconds
	}
	
}	
function showmsg($field, $action, $matchwith='')
{
	if($action == 'add')
		$msg = ucfirst(strtolower($field))." added successfully !";
	elseif($action == 'update')
		$msg = ucfirst(strtolower($field))." updated successfully!";
	if($action == 'delete')
		$msg = ucfirst(strtolower($field))." deleted successfully!";
	if($action == 'dup')
		$msg = "Duplicate ".strtolower($field)." with same ".$matchwith." found!";
	if($action == 'restore')
		$msg = ucfirst(strtolower($field))." restored successfully!";
	return $msg;
}
function multi_in_array($needle, $haystack, $strict = false) 
{
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && multi_in_array($needle, $item, $strict))) {
			return true;
		}
	}
	return false; 	
} 
function shownlInjs($text)
{
	return preg_replace('/(\r?\n)+/', '\\n', $text);
}
function populateNotification($notificationArray=array())
{
	if(array_key_exists('type',$notificationArray)) {
		if($notificationArray['type'] == "Success") {
			echo "<div class='msg-ok enable-close' style='cursor: pointer;'>".$notificationArray['message']."</div>";
		} else if($notificationArray['type'] == "Failed") {
			echo "<div class='msg-error enable-close' style='cursor: pointer;'>".$notificationArray['message']."</div>";
		}
	}
}
function sendMail($from,$reply_to,$to,$subject,$field_array,$data_array,$function,$user_name)
{
	$headers = "From: " . $from . "\r\n";
	//$headers .= "Bcc: ".BCC_EMAIL. "\r\n";
	$headers .= "Reply-To: ". $reply_to . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$message = '';
	if($function == "add_task")
		$message='<span style="font-weight:bold;font-size: 13px;">'.$user_name.' added this task on </span>';
	else
		$message='<span style="font-weight:bold;font-size: 13px;">'.$user_name.' updated this task on </span>';
	
	$message.=' <span style=color:#838181;font-size:13px;white-space:nowrap>'.date("d-M-Y h:i A").'</span>';	
	$message.='<br><span style="font-weight:bold;font-size: 13px;">Task Details :</span>';
	$message.='<table cellspacing="0" cellpadding="1px" style="font-size:14px;border:1px solid #DDD;margin:10px 0;">';
	$message.='<tr>';
	foreach($field_array as $field)
	{
		$message.='<th style="border:1px solid #DDD;padding:7px 21px 7px 7px;">'.$field.'</th>';	
	}
	$message.='</tr><tr>';
	foreach($data_array as $data)
	{
		$message.='<td style="border:1px solid #DDD;padding:7px 21px 7px 7px;">'.$data.'</td>';
	}
	$message.='</tr></table>';
	if(mail($to,$subject,$message,$headers)){
		//echo "Mail send!";
	}else{
		//echo "Mail not send!";
	}		
}
function getFields($arr,$except_arr)
{
	$arr_fields = array();
	foreach($arr as $k=>$v)
	{
		if(!in_array($v,$except_arr))
			$arr_fields[] = $v;
	}
	return $arr_fields;
}
// this function is only for internal use or for printing predefined array in debugging
function printr($arr)
{
	echo "<pre>"; print_r($arr); 
}
?>
