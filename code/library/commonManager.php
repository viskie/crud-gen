<?php
class CommonManager 
{	
	static private $db;
	
	static public function initDb($db){
		/* emulating __construct() */
		self::$db = $db;
		if (!$db->set_charset("utf8")) {
			$this->alert("Error loading character set utf8: ".$db->error); 
		}
	}
	static public function closeDb()
	{
		self::$db->close(); 
	}
	/**
		* myQuery - only for internal use
		* @param $sql - query to execute
		* return resultset	
	**/
	private function myQuery($sql)
	{	
		if($result = self::$db->query($sql))	
		{ 	
			return $result;			
		}
		else
		{
			echo self::$db->error;	
			exit;				
		}
	} 
	/**
		* getArray - only for internal use
		* @param $result - resultset
		* return associative array from mysql resultset
	**/	
	private function getArray($result)
	{
		$result_arr = array();	
		 while ($row = $result->fetch_assoc()) {
			$result_arr[] = $row;
		}
		$result->free(); 		
		return ($result_arr);
	}
	/**
		* logHistory 
		* @param $type - type of fired query link insert, update, delete
		* @param $query - query which is fired
		* return - doesn't retuen anything
	**/	
	function logHistory($type,$query)
	{
		$query=self::$db->real_escape_string($query);
		$user_id="0";
		if(isset($_SESSION['user_id'])){
			$user_id=$_SESSION['user_id'];
		}
		//self::$db->query("INSERT INTO `user_history`(`user_id`, `type`, `Description`) VALUES ('".$user_id."','".$type."','".$query."')") or die(self::$db->error);		
	}
	function alert($msg)
	{
		echo $msg; exit;
	}
	function purifyInputs()
	{
		foreach($_REQUEST as $key=>$value)
		{
			if(is_array($value)){	//The function is giving error when passed array of checkboxes in query string.
				foreach($value as $keySub => $valueSub){
					if(is_array($valueSub)){
						foreach($valueSub as $key_sub_sub => $val_sub_sub){
							$value[$key_sub_sub] = self::$db->real_escape_string(trim($val_sub_sub));	
						}
					}
					else{
						$value[$keySub] = self::$db->real_escape_string(trim($valueSub));
					}
				}
			}else{
				$_REQUEST[$key] = self::$db->real_escape_string(trim($value));
			}
		}
	}	
	/**
		* Insert
		* @param $Table string - table names 
		* @param $data array - table fields accosicated with values. e.g. tbFields=>'value' 
		* @param optinal $showQuery - if is true, it shows mysql query for debugging using phpmyadmin		
		* return affected row int
	**/			
	function insert($table,$data,$showQuery=false)
	{	
		if(count($data) > 0)
		{
			/*$arr_fields = array_keys($data);
			$pfield = $this->getPrimaryKey($table);
			if (($key = array_search($pfield, $arr_fields)) !== false) {
				unset($arr_fields[$key]);
			}
			$field_list = implode(',',$arr_fields);
			//printr($data); printr($fields); exit;
			
			$prepared_values = str_repeat("?,", count($arr_fields));
			$prepared_values = trim($prepared_values,',');
			$sql = "INSERT INTO " . $table . " ( ".$pfield.",".$field_list." ) VALUES (NULL,".$prepared_values.")";
			$stmt = self::$db->prepare($sql);
			$stmt->bind_param('sssd', $code, $language, $official, $percent);
			echo $sql;
			$stmt->execute();
			$stmt->affected_rows;
			$stmt->close();
			echo "here"; exit;*/
						
			$str = "";
			foreach($data as $key => $values)
			{
				$str.= "`".$key."`='".$values."'";	//self::$db->real_escape_string($values)
				$str.= ",";
			}
			$str = trim($str,',');
			$sql = "INSERT INTO  ".$table." SET ".$str;	
			if($showQuery)
			{
				echo $sql; exit;
			}
			else
			{
				if($err = $this->myQuery($sql))
				{
					$this->logHistory('insert',$sql);
					return self::$db->insert_id;
				}
				else
				{
					return false;
				}
			}
			
		}else
		{
			$this->alert("Data array is empty!"); 
		}		
	}
	function getPrimaryKey($table)
	{
		$key = $this->getData("SHOW KEYS FROM ".$table." WHERE Key_name = 'PRIMARY'"); 
		return $key[0]['Column_name'];
	}
	
	/**
		* Update
		* @param $table string - table names 
		* @param $data array - table fields accosicated with values. e.g. fields=>'value' 
		* @param optinal $field_name - update using this fieldname.
		* @param optinal $condition string - query condition,joins.
		* @param required - atleast one field is required in $field_name and $condition;
		* @param optinal $showQuery - if is true, it shows mysql query for debugging using phpmyadmin	
		* return affected row int
	**/
	function update($table,$data,$field_name="",$condition="",$showQuery=false)
	{
       if($field_name == "" && $condition== "")
		{
			$this->alert("Please send atleast one field to update!"); 
		}
		else
		{
			if(count($data) > 0)
			{
				$str = "";
				foreach($data as $key => $values)
				{
					if($key!=$field_name)
					{
						$str.= "`".$key."`='".$values."'";
						$str.= ",";
					}
				}
				$str = trim($str,',');
				$sql = "UPDATE ".$table." SET ".$str." WHERE ";
				if($field_name != "")
				{
					$sql .= $field_name."='".$data[$field_name]."'";
				}			
				if($condition != "")
				{
					$sql .= " AND ".$condition;
				}
				else
					$sql = trim($sql,'AND');

                if($showQuery)
				{
					echo $sql; exit;
				}
				else
				{
					$this->myQuery($sql);
					$this->logHistory('update',$sql);
					return self::$db->affected_rows;					
				}				
			}else
			{
				$this->alert("Data array is empty!");
			}
		}
	}
	/**
		* Delete 
		* @param $table string - table names 
		* @param optinal $field_name, $id - delete using this fieldname and id.
		* @param optinal $is_permdel - default is false, if its true it permenently delete from the table.
		* @param optinal $condition string - query condition,joins.
		* @param required - atleast one field is required in $field_name and $condition;
		* @param optinal $showQuery - if is true, it shows mysql query for debugging using phpmyadmin	
		* return affected row int
	**/
	function delete($table,$field_name="",$id="",$condition="",$is_permdel=false,$showQuery=false)
	{
		if($field_name == "" && $condition== "")
		{
			$this->alert("Please send atleast one field to delete!");
		}
		elseif(($field_name != "" && $id == "") || ($id != "" && $field_name == ""))
		{
			$this->alert("field_name and id both are required!");
		}
		else
		{			
			if($is_permdel == true)
				$sql = "DELETE FROM ".$table." WHERE ";
			else
				$sql = "UPDATE ".$table." SET is_active = '0' WHERE ";
			if($field_name != "")
			{
				$sql .= $field_name."='".$id."' AND";
			}	
			
			if($condition!="")
			{
				$sql .= $condition;
			}
			else
			{
				
				$sql = rtrim($sql,'AND');
				
			}
			
			if($showQuery)
			{
				echo $sql; exit;
			}
			else
			{
				$this->myQuery($sql);
				$this->logHistory('delete',$sql);
				return self::$db->affected_rows;				
			}
		}
	}
	/**
		* getAll
		* @param $table string - table names seperated by ,(comma)'. e.g.'name1,name2'.
		* @param $fields string - table fields seperated by ,(comma)'. e.g.'fields1,fields2'.
		* @param optinal $condition string - query condition,joins.
		* @param optinal $showQuery int - required true. => return string 
		* @param optinal $is_getRow int - is only for internal use i.e useed for getRow and getOne functions
		* return array
	**/
	function getAll($table,$fields,$condition="",$is_active=1,$is_join=0,$showQuery=false,$is_getRow=false)
	{	
		$sql = "SELECT ".$fields." From ".$table." WHERE 1 AND "; 
		if($is_active != 2 && $is_join == 0)
			$sql .= " is_active = '".$is_active."' AND ";		
		if($condition != "")
		{
			$sql .= $condition;						
		}
		$sql = trim($sql,'AND ');
		if($is_getRow == true)
		{
			$sql .= " limit 0,1";  
		}
		if($showQuery)
		{
			echo $sql; exit;
		}
		$result = $this->myQuery($sql);	
		$result_arr = $this->getArray($result);
		$this->logHistory('select',$sql);
		return $result_arr;		
	}	
	/**
		* getRow (function to retrive 1 row from the database)
		* @param $table string - table names seperated by ,(comma)'. e.g.'name1,name2'.
		* @param $fields string - table fields seperated by ,(comma)'. e.g.'fields1,fields2'.
		* @param optinal $condition string - query condition,joins.
		* @param optinal $showQuery int - required true. => return string 		
		* return array
	**/	
	function getRow($table,$fields,$condition="",$is_active=1,$is_join=0,$showQuery=false) 
	{	
		$result_arr = $this->getAll($table,$fields,$condition,$is_active,$is_join,$showQuery,true);
		if(count($result_arr) > 0)
		{
			if(!is_array($result_arr))
				return $result_arr;
			else
				return $result_arr[0];
		}
	}
	/**
		* getRow (Function to Get single value from the database)
		* @param $table string - table names
		* @param $fields string - table fields
		* @param optinal $condition string - query condition
		* @param optinal $showQuery int - required true. => return string 		
		* return array
	**/		
	function getOne($table,$field,$condition="",$is_join=0,$showQuery=false,$is_active=1)
	{	
		$result_arr = $this->getAll($table,$field,$condition,$is_active,$is_join,$showQuery,'1',true);
		if(count($result_arr) > 0)
			return $result_arr[0][$field];	
		else
			return false;
	}
	/**
		* getData 
		* @param $query string - query which u want to execute
		* return data from the database directly using query
	**/
	function getData($query) 
	{
		$query=trim($query); 		
		$result = $this->myQuery($query);		
		$result_arr = $this->getArray($result);	
		return $result_arr;
	}
	/**
		* Restore 
		* @param $table string - table names .
		* @param $field_name string - table field_name for restore 
		* @param $field_value string - table field_value of field_name for restore 
		* @param optinal $condition string - query condition,joins.
		* @param optinal $showQuery int - required true. => return string 		
		* return array
	**/	
	function restore($table,$field_name,$field_value,$condition="",$showQuery=false)
	{		
		$data = array(
					'is_active' => 1,
					$field_name => $field_value
					);
		$result = $this->update($table,$data,$field_name,$condition,$showQuery);
		return $result;
	}
	/**
		* getRecordCounts 
		* @param $table string - table names .	
		* @param optinal $showQuery int - required true. => return string		
		* return array of count of all, active and deleted
	**/	
	function getRecordCounts($table,$showQuery=false)
	{		
		$result = $this->getAll($table,"COUNT(*) as cnt, is_active"," 1 group by is_active",'',2,$showQuery); 
		$array_count = array('all'=>0,'active'=>0,'deleted'=>0);
		$all=0;
		foreach($result as $record){
			if($record['is_active']==0){
				$array_count['deleted']=$record['cnt'];
			}else if($record['is_active']==1){
				$array_count['active']=$record['cnt'];
			}
			$all+=$record['cnt'];
		}
		$array_count['all']=$all;
		return $array_count;
	}
	/** getTableColms 
		* @param $table string - table name
		* return all coloums of the table
	**/
	function getTableColms($table)
	{
		$arr_colms = $this->getData("SHOW columns FROM ".$table);
		$arr_colm_names = array();
		foreach($arr_colms as $k=>$v)
		{
			$arr_colm_names[] = $v['Field'];
		}
		return $arr_colm_names;
	}
	
}

?>