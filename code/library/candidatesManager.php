<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
	exit();
}

class CandidatesManager extends CommonManager
{
	public $tb1_name;
	public $tb1_fields; 
	function __construct()
	{
		$this->tb1_name = "candidates";
		$this->tb1_fields = $this->getTableColms($this->tb1_name);
		$primary_key = $this->getPrimaryKey($this->tb1_name);					
		$edit_except = array($primary_key,"added_by","added_date","modified_by","modified_date","is_active");
		$this->edit_fields = getFields($this->tb1_fields,$edit_except); 
	}
	
	function getAllCandidates($show='1')
	{
		if($show == 0)
			$arr_orders =  $this->getData("SELECT candidates.*, STATUS.status_name, POSITION.position_name From candidates LEFT JOIN (SELECT status_id,status_name FROM candidate_status) AS STATUS ON candidates.status =STATUS.status_id LEFT JOIN (SELECT position_id, position_name FROM candidate_position) AS POSITION ON candidates.position = POSITION.position_id WHERE candidates.is_active=0 order by is_active DESC");
		elseif($show == 1)
			$arr_orders =  $this->getData("SELECT candidates.*, STATUS.status_name, POSITION.position_name From candidates LEFT JOIN (SELECT status_id,status_name FROM candidate_status) AS STATUS ON candidates.status =STATUS.status_id LEFT JOIN (SELECT position_id, position_name FROM candidate_position) AS POSITION ON candidates.position = POSITION.position_id WHERE candidates.is_active=1");
		elseif($show == 2)
			$arr_orders =  $this->getData("SELECT candidates.*, STATUS.status_name, POSITION.position_name From candidates LEFT JOIN (SELECT status_id,status_name FROM candidate_status) AS STATUS ON candidates.status =STATUS.status_id LEFT JOIN (SELECT position_id, position_name FROM candidate_position) AS POSITION ON candidates.position = POSITION.position_id WHERE 1");
		return $arr_orders;
	}
	function getAllpositions()
	{
		$arr_positions =  $this->getData("SELECT * From candidate_position WHERE is_active = 1");
		return $arr_positions;
	}
	
	function getAllstatus()
	{
		$arr_status =  $this->getData("SELECT * From candidate_status WHERE is_active = 1");
		return $arr_status;
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
}
?>