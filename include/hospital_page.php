<?php 
	session_start();
	require('./php_files/DbUtils.php');
	$dbUtils = new DbUtils();
	$guest = true;
	$hosp_id = -1;
	if(isset($_GET['android']) && isset($_GET['hosp_id'])){
		$data = $dbUtils->getDept($_GET['hosp_id']);
		header('Content-Type: application/json');
		
		echo json_encode($data);
		die();
		exit();
	}

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
		$data = $dbUtils->getDept(isset($_GET['hosp_id'])?$_GET['hosp_id']:$_SESSION['hosp_id']);
		if(isset($_GET['hosp_id']) && !($_GET['hosp_id'] === $_SESSION['hosp_id']) ){
			$guest = true;
			$hosp_id = $_GET['hosp_id'];
			$data['hosp_name'] = $_GET['hosp_name'];
		}else{
			$guest = false;
			$hosp_id = $_SESSION['hosp_id'];
			$data['hosp_name'] = $_SESSION['hosp_name'];
		}

	}else if(isset($_GET['hosp_id'])){
		$data = $dbUtils->getDept($_GET['hosp_id']);
		$guest = true;
		$hosp_id = $_GET['hosp_id'];
		$data['hosp_name'] = $_GET['hosp_name'];
	}else{
		$_SESSION['error_message'] = "Bad Access";
		echo $_SESSION['error_message'];
		exit();
	}
	
 ?>