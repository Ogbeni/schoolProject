<?php
	session_start();
	require('./DbUtils.php');
	$db = new DbUtils();
	$logged_in = isset($_POST['json_text']);
	if(!$logged_in){
		echo "Invalid Access";
		exit();
	}
	$hosp = json_decode( $_POST['json_text']);
	$result = $db->registerHosp($hosp);
	echo $result;


	
	// echo $lat = mysqli_real_escape_string($conn, $_POST['lat']);
	// echo $lng = mysqli_real_escape_string($conn, $_POST['lng']);
	// echo $issue_date = mysqli_real_escape_string($conn, $_POST['issue_date']);
	// echo $result= mysqli_query($conn, "insert into locations (name, description, lat, lng, issue_date) value ('{$title}','{$desc}',$lat,$lng,'{$issue_date}')");
	
 ?>