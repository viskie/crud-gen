<?php
	switch($function)
		{			
			case "logout": 
				 session_unset();
				 session_destroy();	
				 callheader("index.php");
				 exit;				 
			break;
			
		}
?>
