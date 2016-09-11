<?php
session_start();
ob_start();
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
}

include_once('constants.php');

error_reporting(E_ALL); ini_set('display_errors', 'On'); 
//error_reporting(0);

$host = "";
$user= "";
$pass= "";
$database = "";

include_once('library/commonFunctions.php');
include_once('library/commonManager.php'); 

CommonManager::initDb(new mysqli($host,$user,$pass,$database));
if (mysqli_connect_errno()) 
{
	showError("Connect failed: ".mysqli_connect_error());   
}
//CommonManager::$db->query("SELECT * FROM `users`"); 

/// Procedural way of mysqli
/*$db = mysqli_connect($host,$user,$pass,$database);
CommonManager::initDb($db);
$res = mysqli_query($db, "SELECT * FROM users limit 0, 1");
$row = mysqli_fetch_assoc($res);
mysqli_close($db)*/


//CommonManager::initDb(new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8', $user, $pass)); 
//$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); 

/*$stmt = $db->query("SELECT * FROM users limit 0, 1");
$test =  $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>"; print_r($test);
var_dump($db); exit;*/

/*mysql_connect($host,$user,$pass,TRUE) or die("could not connect");
mysql_select_db($database) or die("could not select database".$database);
mysql_set_charset("utf8");*/

?>
