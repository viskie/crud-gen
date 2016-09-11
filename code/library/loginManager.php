<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
}

class loginManager extends CommonManager
{
	public $tb1_name;
	//public $tb1_fields; 
    function __construct()
    {
		$this->tb1_name = 'users';
        //$this->tb1_fields = $this->getTableColms($this->tb1_name);
    }	
	function checkLogin($user,$pass) 
	{	
		$chk_user = $this->getAll($this->tb1_name,'*'," user_name='".addslashes($user)."' AND user_password = sha1('".addslashes($pass)."')"); 
		if(count($chk_user) > 0) return true;
		else return false;
	}
	
	function setUserDetails($user)
	{	
		if(is_array($user) && isset($user['user_name']) && isset($user['name'])){ 
			$_SESSION['user_name'] = $user['user_name'];
			$_SESSION['name'] = $user['name']; 
		}else{			
			$userDetails = $this->getAll($this->tb1_name,'*',"user_name='".addslashes($user)."'");			
			if(sizeof($userDetails)>0)
			{
				 $_SESSION['user_id'] = $userDetails[0]['user_id'];
				 $_SESSION['user_name'] = $userDetails[0]['user_name'];
				 $_SESSION['user_main_group'] = $userDetails[0]['user_group'];
				 $_SESSION['name'] = $userDetails[0]['name'];
				 $_SESSION['user_login'] = true;
			}
		}
	}
}
?>