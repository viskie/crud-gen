<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
}
include_once('library/dashboardManager.php');
$dashboardObject= new dashboardManager();

switch($function){
case "default":
			$data['allemp'] = $dashboardObject->getAll($dashboardObject->tb1_name,'*');
			$data['leave_type']	= $dashboardObject->getleavetypes();
			$data['total_leaves'] = $dashboardObject->getleaves($data['allemp']);
			$data['leaves_taken'] = $dashboardObject->getleavestaken($data['allemp']);
			$page = "manage_dashboard.php";
		break;
}
?>