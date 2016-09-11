<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
	exit();
}

class UserManager extends CommonManager
{
	public $tb1_name;
	public $tb1_fields; 	
    function __construct()
    {		
		$this->tb1_name = 'users';
        $this->tb1_fields = $this->getTableColms($this->tb1_name);
		$except = array('user_id','added_by','added_date','modified_by','modified_date','franchise_id','is_active');
		$this->view_fields = getFields($this->tb1_fields,$except); 
    }	
	function getUserVariables($arr_post)
	{		
		$fields = $this->view_fields;
		$arr_variable = array();
		foreach($fields as $k=>$v)
		{	
			if(array_key_exists($v,$arr_post))
				$arr_variable[$v] = $arr_post[$v];
		}
		return $arr_variable;		
	}
	function getRecordCountsUsers($arr_grp)
	{		
		$str='';
		foreach($arr_grp as $val)
		{ $str.=$val.",";}
		$str=trim($str,","); 
		$result = $this->getAll($this->tb1_name,'count(*) as cnt, is_active',"user_group<>".EMPLOYEE_GRP_ID." and user_group not in (".$str.") group by is_active",2);		
		$array_count = array('all'=>0,'active'=>0,'deleted'=>0);
		$all=0;
		foreach($result as $record){
			if($record['is_active']==0){
				$array_count['deleted']=$record['cnt'];
			}else if($record['is_active']==1){
				$array_count['active']=$record['cnt'];
			}
			$all=$array_count['deleted']+$array_count['active'];
		}
		$array_count['all']=$all;
		return $array_count;
	}
	function isUserExist($user_name,$user_id='')
	{
		$cond = " user_name='".$user_name."'";
		if($user_id!=''){
			$cond .=" AND user_id!=".$user_id; 
		}
		$resultSet = $this->getAll($this->tb1_name,'*',$cond);		
        if(sizeof($resultSet)>0){
			return true;
		}else{
			return false;
		}
	}
	
		
}