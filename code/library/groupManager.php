<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
	exit();
}

class GroupManager extends CommonManager
{
	public $tb1_name;
	public $tb1_fields; 
    function __construct()
    {
		$this->tb1_name = 'user_groups';
        $this->tb1_fields = $this->getTableColms($this->tb1_name);
    }	
}
?>