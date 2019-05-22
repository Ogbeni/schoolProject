<?php 

	if(isset($_POST['s_value'])){
		require('./DbUtils.php');

		$s_value = $_POST['s_value'];
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];

		if($s_value==""){
			$s_value = "none";
		}
		$dbUtils = new DbUtils();
		$data = $dbUtils->getHospitalsResults($s_value, $lat, $lng);
		header('Content-Type: application/json');
		echo json_encode($data);
		die();
		exit();
	}
 ?>