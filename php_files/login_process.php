<?php 
session_start();
require('./DbUtils.php');
$db = new DbUtils();
if(isset($_POST['h_name'])){
	$result = $db->login($_POST['h_name'], $_POST['h_password']);
	echo $result;
}else{
	$_SESSION['error_message'] = "Bad Access";
	echo $_SESSION['error_message'];
}

 ?>