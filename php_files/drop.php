<?php 
	session_start();
	require('./DbUtils.php');
	$db = new DbUtils();
	$conn = $db->getConn();
	$logged_in = $_SESSION['logged_in'];
	if(!$logged_in){
		echo "Invalid Access";
		exit();
		die();
	}
	if( !(isset($_GET['dept_id']) && isset($_GET['spec_id']) ) ){
		echo "Invalid Access";
		exit();
		die();
	}
	$result= "";
	if($_GET['spec_id'] == -1){
		$dept = $_GET['dept_id'];
		$result= mysqli_query($conn, "delete from departments  where dept_id = $dept");
	}else{
		$spec = $_GET['spec_id'];
		$result= mysqli_query($conn, "delete from specialization  where spec_id = $spec");
	}

	if($result){
		echo "successfully";
	}else {
		echo mysqli_error($conn);
	}
	

	
 ?>