<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
	exit();
}

class HrmManager extends CommonManager
{
	public $tb1_name;
	public $tb1_fields; 
	function __construct()
	{
		$this->tb1_name = "employee";
		$this->tb2_name = 'leave_type';
		$this->tb3_name = 'emp_total_leaves';
		$this->tb1_fields = $this->getTableColms($this->tb1_name);
		$primary_key = $this->getPrimaryKey($this->tb1_name); 
		//$view_except = array($primary_key,"identity_proof","address_proof","photo","ssc","hsc","graduation","post_graduation","salary_slip","appoinment_letter","relieving_letter","employee_status","per_address","cur_address","personal_phone2","parent_phone","landline","personal_email","date_of_birth","sign_img","photo_img","added_by","added_date","modified_by","modified_date","is_active");
		$this->view_fields = array("employee_name","designation","department","joining_date","personal_phone1","company_email","personal_email");				
		$edit_except = array($primary_key,"added_by","added_date","modified_by","modified_date","is_active");
		$this->edit_fields = getFields($this->tb1_fields,$edit_except);		
	}
	function getVariables($arr_post)
	{						
		$fields = $this->edit_fields;
		$arr_variable = array();
		foreach($fields as $k=>$v)
		{	
			if(array_key_exists($v,$arr_post))
				$arr_variable[$v] = $arr_post[$v];
		}
		return $arr_variable;		
	}
	function getleavetypes()
	{
		$arr_ltype = $this->getAll($this->tb2_name,'id,leave_type');		
		return $arr_ltype;
	}
	function getleaves($emp_id) 
	{	
		$arr_ltype = $this->getleavetypes();
		$arr_leaves = array();		
		foreach($arr_ltype as $k=>$v)
		{
			$get_leaves = $this->getAll('emp_total_leaves','total_leaves',' emp_id= "'.$emp_id.'" and leave_type_id = "'.$v['id'].'" ');
			$leaves = count($get_leaves)>0?$get_leaves[0]['total_leaves']:0; 
			$arr_leaves[$v['id']] = $leaves;					
		}	
		//printr($arr_leaves); exit;
		return $arr_leaves;
	}
	function getEarnedLeavesRecord($emp_id)
	{
		//return getRow("select * from ".$this->tb3_name. "where emp_id=".$emp_id." and leave_type_id=".EARNED_TYPE);
		return $this->getRow($this->tb3_name,'*','emp_id='.$emp_id.' and leave_type_id='.EARNED_TYPE,$is_active=1,$is_join=0,$showQuery=false) ;
	}
}?>