<?php 
	session_start();
	require('./DbUtils.php');
    $db = new DbUtils();
    $conn = $db->getConn();
    
	$logged_in = $_SESSION['logged_in'];
	if(!$logged_in){
		echo "Invalid Access";
		exit();
	}
	$hosp_id = $_SESSION['hosp_id'];
	$dept = json_decode( $_POST['json_text']);
	
	$name = mysqli_real_escape_string($conn, $dept->name);
	$profile = mysqli_real_escape_string($conn, $dept->profile);
	$spec = $dept->spec;

	$result= mysqli_query($conn, "insert into departments (dept_name, dept_profile, dept_hosp_no) value ('{$name}','{$profile}','{$hosp_id}')");
	if($result){
		$dept_id = mysqli_insert_id($conn);
		for ($i=0; $i < sizeof($spec) ; $i++) { 
			$name1 = mysqli_real_escape_string($conn, $spec[$i]->name);
			$profile1 = mysqli_real_escape_string($conn, $spec[$i]->profile);
			$start_date1 = mysqli_real_escape_string($conn, $spec[$i]->start_date);
			$result_spec = mysqli_query($conn, "insert into specialization 
						(spec_name, spec_profile, spec_start_date, spec_dept_no) value ('{$name1}','{$profile1}','{$start_date1}','{$dept_id}')");
			if($result_spec){			
				$spec[$i]->name ." Spec was added\n";
			}else {
				echo mysqli_error($conn);
			}
		}
		echo "successfully";
	}else {
		echo mysqli_error($conn);
	}

	
 ?>