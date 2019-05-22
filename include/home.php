<?php 
	session_start();
	require('./php_files/DbUtils.php');
	$dbUtils = new DbUtils();
	
	if(isset($_GET['android'])){
		$data ="";
		if(isset($_GET['s']) && strlen($_GET['s']) != 0 ){
			$data = $dbUtils->getHospitalsResults($_GET['s'], $_GET['lat'], $_GET['lng']);
		}else{
			$data = $dbUtils->getHospitalsResults("none", $_GET['lat'], $_GET['lng']);
		}
		// $data = $dbUtils->getHospitalsResults($_GET["s"], $_GET['lat'], $_GET['lng']);
		header('Content-Type: application/json');
		// var_dump($data);
		echo json_encode($data);
		die();
		exit();
	}
	if(isset($_GET['lat'])){
		$data = $dbUtils->getHospitals($_GET['lat'], $_GET['lng']);
	}else{		
		$data = $dbUtils->getHospitals();
	}
	
 ?>