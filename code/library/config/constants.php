<?PHP
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
}

define('EARNED_TYPE','2');

define('DEVELOPER_GRP_ID','1');
define('EMPLOYEE_GRP_ID','31');
define('FRANCHISE_GRP_ID','35');
define('FRANCHISE_USER_GRP_ID','4');

//define('ARR_GRP',array('1'));
$arr_grp = array('1');
$SUPER_LEVEL_ACCESS = array('1','2');
$arr_const_priority = array(1,2,3,4);

// for changing msgs for add, edit, delete, make changes in function of name 'showmsg' written in commonFunction.php
$arr_msg = array(
			'group' => array(
						'delpermission' => "You do not have permission to delete this group!"				
						),
			'reimbursement' => array(
						'paid' => "Reimbursement paid successfully!"						
						),
			'attendance' => array(
						'login' => "User login successfully!",						
						'loggedin' => "You are already logged In!",						
						'innote_save' => "In note saved successfully!",						
						'logout' => "User logout successfully!",						
						'loggedout' => "You are already logged out!",						
						'note_update' => "Notes updated successfully!",						
						'put_ note' => "Put some notes to update!",						
						'selemployee' => "Please select atleast one employee !"						
						),
			'leave' => array(
						'apply' => "'Leave applied successfully!",						
						'date_valid' => "End date greater than start date!"						
						),
			'order' => array(
						'restore' => "Order restored successfully!"						
						),
			'account' => array(
						'expense_logged' => "Expense logged successfully!",	
						'expense_paid' => "Expected expense marked as a paid!"	
						),
			'setting' => array(
						'upload_error' => "file can not be uploaded!",						
						'upload' => "file Uploaded successfully!",						
						'file_type' => "check file format or size of file!",						
						'file_select' => "File not selected!",
						'file_exist' => "already exist!",
						'function_exist' => "Function already exist!",
						'status_restore' => "Status restored successfully!",	
						'status_name_exist' => "Status name already exist!",	
						'status_order_exist' => "Status order already exist!",	
						'status_exist' => "Status name and order already exist!",	
						'mandatory' => "Please fill mandatory fields.",
						'financial_month' => "Date should be number between 2 to 28. If you want to set financial date as 1 then please select defalut date.",
						'browser_upgrade' => "Please upgrade your browser to latest version (or IE9) for better user experience!"	,
						'menu_order' => "Menu order already exist!",
						'priority_order' => "Priority Order already exist!",
						),
			);