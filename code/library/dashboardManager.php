<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
}

class dashboardManager extends CommonManager
{
	public $tb1_name;
	public $tb1_fields; 
    function __construct()
    {
		$this->tb1_name = 'employee';
        $this->tb1_fields = $this->getTableColms($this->tb1_name);
		$this->tb2_name = 'leave_type';
    }	
	function getleavetypes()
	{
		$arr_ltype = $this->getAll($this->tb2_name,'id,leave_type');		
		return $arr_ltype;
	}
	function getleaves($emp) 
	{	
		$arr_ltype = $this->getleavetypes();
		$arr_leaves = array();
		for($i=0;$i<count($emp); $i++)
		{
			foreach($arr_ltype as $k=>$v)
			{
				$get_leaves = $this->getAll('emp_total_leaves','total_leaves',' emp_id= "'.$emp[$i]['id'].'" and leave_type_id = "'.$v['id'].'" ');
				$leaves = count($get_leaves)>0?$get_leaves[0]['total_leaves']:0; 
				$arr_leaves[$emp[$i]['id']][$v['leave_type']] = $leaves;					
			}			
		}
		//printr($arr_leaves); exit;
		return $arr_leaves;
	}
	function getleavestaken($emp)
	{
		$arr_ltype = $this->getleavetypes();
		$arr_leaves = array();
		$arr_remaining_leaves = array();
		for($i=0;$i<count($emp); $i++)
		{
			foreach($arr_ltype as $k=>$v)
			{
				$get_leaves = $this->getAll('leaves','SUM(total_days) AS total_days',' employee_id= "'.$emp[$i]['id'].'" and leave_type = "'.$v['id'].'" ');
				$total_leaves = ($get_leaves[0]['total_days'] != "")?$get_leaves[0]['total_days']:0; 
				$arr_leaves[$emp[$i]['id']][$v['leave_type']] = $total_leaves;								
			}			
		}
		//printr($arr_leaves); exit;
		return $arr_leaves;
	}	
	
}
?>