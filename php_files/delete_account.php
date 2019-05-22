<?php 
session_start();
if(!isset($_SESSION['logged_in'])){
	echo "Invalid Access";
	exit();
}
require('./DbUtils.php');
$db = new DbUtils();

$logged_in = $_SESSION['logged_in'];
if(!$logged_in){
	echo "Invalid Access";
	exit();
}
if(isset($_GET['hosp_id'])){
	$result = $db->deleteAccount($_GET['hosp_id']);
	if($result == "successfully"){
		session_start();
		session_destroy();
		header("location: ./../#login");
	}else{
		echo $result;
	}
	
}else{
	$_SESSION['error_message'] = "Bad Access";
	echo $_SESSION['error_message'];
}

 ?>