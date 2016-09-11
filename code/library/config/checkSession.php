<?php  
if(isset($_SESSION['user_login']) && $_SESSION['user_login']!=true)
{	
	callheader("index.php");
	exit;
}

if(!isset($_SESSION['user_login']) || !($_SESSION['user_login'] == true))
{
	callheader("index.php");
	/* echo "
				<script type='text/javascript'>
					alert(\"Please Log into the application to use this feature\");
					window.location = 'index.php';
				</script>
		 ";*/
	exit;
}
?>
