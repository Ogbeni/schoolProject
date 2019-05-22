<?php 
	session_start();
	require('./DbUtils.php');
	$logged_in = $_SESSION['logged_in'];
	if(!$logged_in){
		echo "Invalid Access";
		exit();
	}
	$hosp_id = $_SESSION['hosp_id'];
	
	$db = new DbUtils();
	$conn = $db->getConn();
	$updated_text = mysqli_real_escape_string($conn, $_POST['updated_text']);
	$dept = mysqli_real_escape_string($conn, $_POST['dept']);
	$table = mysqli_real_escape_string($conn, $_POST['table']);
	$col = mysqli_real_escape_string($conn, $_POST['col']);
	if(isset($_POST['spec'])){
		$spec = mysqli_real_escape_string($conn, $_POST['spec']);
		$result= mysqli_query($conn, "update $table set $col = '{$updated_text}' where spec_id = $spec");
	}else{
		$result= mysqli_query($conn, "update $table set $col = '{$updated_text}' where dept_id = $dept");
	}
	if($result){
		echo "successfully";
	}else {
		echo mysqli_error($conn);
	}

	
 ?>