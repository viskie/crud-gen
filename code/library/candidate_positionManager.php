<?php
			if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
			{
				callheader("index.php");
				exit();
			}
			
			class Candidate_positionManager extends CommonManager
			{
				public $tb1_name;
				public $tb1_fields; 
				function __construct()
				{
					$this->tb1_name = "candidate_position";
					$this->tb1_fields = $this->getTableColms($this->tb1_name);
					$primary_key = $this->getPrimaryKey($this->tb1_name);					
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
}?>