<?php
	class DbUtils{
		private $conn ;
		// function DbUtils($l="localhost", $u="id7671610_dephizee", $p="schoolschool", $d="id7671610_schoolprojectdb"){
		function DbUtils($l="localhost", $u="root", $p="", $d="projectdb"){
			$this->conn = mysqli_connect($l, $u, $p, $d);
		}
		function getConn(){
			return $this->conn;
		}
		function getHospitalsResults( $value="er", $lat=9.0, $lng=8.0, $limit=-1){
			// die($value . $lat. $lng);
			$data = array();
			$lon = $lng;
			// Using Google's algorithm:
			$query = "select *, 
			( 3959 * acos( cos( radians('$lat') ) * 
			cos(  hosp_lat  ) * 
			cos(  hosp_lng  - 
			radians('$lon') ) + 
			sin( radians('$lat') ) * 
			sin( hosp_lat ) ) ) 
			AS distance from hospitals";
			if($value!="none"){
				$query .= " left join departments on hospitals.hosp_id = departments.dept_hosp_no where hosp_name like '%{$value}%' or dept_name like '%{$value}%' group by hosp_id ";
			}
			 
			 $query .= " ORDER BY distance ASC";
			if($limit != -1){
				$query .= " limit ".$limit;
			}
			if($result = mysqli_query($this->conn, $query)){
			    if(mysqli_num_rows($result) > 0){
			    	$id_arr = array();
			    	$name_arr = array();
			    	$profie_arr = array();
			    	$addr_arr = array();
					$lat_arr = array();
					$lng_arr = array();
					$lat_distance = array();
			    	while ($arr = mysqli_fetch_assoc($result)) {
			    		$id_arr[] = $arr['hosp_id'];
				    	$name_arr[] = $arr['hosp_name'];
				    	$profie_arr[] = $arr['hosp_profile'];
				    	$addr_arr[] = $arr['hosp_address'];
				    	$lat_arr[] = $arr['hosp_lat'];
				    	$lng_arr[] = $arr['hosp_lng'];
				    	$lat_distance[] = $arr['distance']*1.609344;
						// $lat_distance[] = $this->getDistanceFromLatLonInKm($arr['hosp_lat'], $arr['hosp_lng'], deg2rad($lat), deg2rad($lng));  
				    	// $lat_arr[] = (($arr['hosp_lat']+0) * 180 * 7) /22;
				    	// $lng_arr[] = (($arr['hosp_lng']+0) * 180 * 7) /22;
			   //  		$data[$t++][$ii] = $arr['hosp_id'];
						// $data[$t][$ii++] = $arr['hosp_name'];
			    	}
			    	$data[] = $id_arr;
			    	$data[] = $name_arr;
			    	$data[] = $addr_arr;
			    	$data[] = $lat_arr;
			    	$data[] = $lng_arr;
			    	$data[] = $profie_arr;
			    	$data[] = $lat_distance;
			    }
			}else{
				echo "failed". mysqli_error($this->conn);
			}
			return $data;
			
		}
		function getHospitals($lat=9.0, $lng=8.0, $limit=-1){
			$data = array();
			$lon = $lng;
			// Using Google's algorithm:
			$query = "select *, 
			( 3959 * acos( cos( radians('$lat') ) * 
			cos(  hosp_lat  ) * 
			cos(  hosp_lng  - 
			radians('$lon') ) + 
			sin( radians('$lat') ) * 
			sin( hosp_lat ) ) ) 
			AS distance from hospitals ORDER BY distance ASC";
			if($limit != -1){
				$query .= " limit ".$limit;
			}
			if($result = mysqli_query($this->conn, $query)){
			    if(mysqli_num_rows($result) > 0){
			    	$id_arr = array();
			    	$name_arr = array();
			    	$profie_arr = array();
			    	$addr_arr = array();
					$lat_arr = array();
					$lng_arr = array();
					$lat_distance = array();
			    	while ($arr = mysqli_fetch_assoc($result)) {
			    		$id_arr[] = $arr['hosp_id'];
				    	$name_arr[] = $arr['hosp_name'];
				    	$profie_arr[] = $arr['hosp_profile'];
				    	$addr_arr[] = $arr['hosp_address'];
				    	$lat_arr[] = $arr['hosp_lat'];
				    	$lng_arr[] = $arr['hosp_lng'];
				    	$lat_distance[] = $arr['distance']*1.609344;
						// $lat_distance[] = $this->getDistanceFromLatLonInKm($arr['hosp_lat'], $arr['hosp_lng'], deg2rad($lat), deg2rad($lng));  
				    	// $lat_arr[] = (($arr['hosp_lat']+0) * 180 * 7) /22;
				    	// $lng_arr[] = (($arr['hosp_lng']+0) * 180 * 7) /22;
			   //  		$data[$t++][$ii] = $arr['hosp_id'];
						// $data[$t][$ii++] = $arr['hosp_name'];
			    	}
			    	$data[] = $id_arr;
			    	$data[] = $name_arr;
			    	$data[] = $addr_arr;
			    	$data[] = $lat_arr;
			    	$data[] = $lng_arr;
			    	$data[] = $profie_arr;
			    	$data[] = $lat_distance;
			    }
			}else{
				echo "failed". mysqli_error($this->conn);
			}
			return $data;
		}

		function getDept($hosp_id=-1){
			$data = array();
			$query = "select * from departments where dept_hosp_no = '{$hosp_id}'";
			if($result = mysqli_query($this->conn, $query)){
			    if(mysqli_num_rows($result) > 0){
			    	$t_arr = array();
			    	$t = 0;
			    	while ($arr = mysqli_fetch_assoc($result)) {
			    		$in_arr = array();
			    		$in_arr['dept_id'] = $arr['dept_id'];
			    		$in_arr['dept_name'] = $arr['dept_name'];
			    		$in_arr['dept_profile'] = $arr['dept_profile'];
			    		$in_arr['dept_spec'] = array();
			    		$query_spec = "select * from specialization where spec_dept_no = '{$in_arr['dept_id']}'";
			    		if($result_spec = mysqli_query($this->conn, $query_spec)){
						    if(mysqli_num_rows($result_spec) > 0){
						    	$s_arr = array();
						    	$s = 0;
						    	while ($c_arr = mysqli_fetch_assoc($result_spec)) {
						    		$inner_arr = array();
						    		$inner_arr['spec_id'] = $c_arr['spec_id'];
						    		$inner_arr['spec_name'] = $c_arr['spec_name'];
						    		$inner_arr['spec_profile'] = $c_arr['spec_profile'];
						    		$inner_arr['spec_start_date'] = $c_arr['spec_start_date'];
						    		$s_arr[$s] = $inner_arr;
						    		$s++;
						    	}
						    	$in_arr['dept_spec'] = $s_arr;
						    }else{
						    	
						    }
						}else{
							echo "failed". mysqli_error($conn);
						}
						$t_arr[$t++] = $in_arr;
			    	}
			    	$data['dept'] = $t_arr;
			    }else{
			    	// 
			    }
			}else{
				echo "failed". mysqli_error($this->conn);
			}
			return $data;
		}
		function registerHosp($hosp){
			$name = mysqli_real_escape_string($this->conn, $hosp->name);
			$address = mysqli_real_escape_string($this->conn, $hosp->address);
			$lat = mysqli_real_escape_string($this->conn, $hosp->lat);
			$lng = mysqli_real_escape_string($this->conn, $hosp->lng);
			$profile = mysqli_real_escape_string($this->conn, $hosp->profile);
			$password = mysqli_real_escape_string($this->conn, $hosp->password);
			$password = password_hash($password, PASSWORD_BCRYPT);
			$dept = $hosp->dept;
			$result= mysqli_query($this->conn, "insert into hospitals (hosp_name, hosp_profile, hosp_address, hosp_lat, hosp_lng, password) value ('{$name}','{$profile}','{$address}',radians('{$lat}'),radians('{$lng}'), '{$password}')");
			if($result){
				$hosp_id = mysqli_insert_id($this->conn);
				for ($i=0; $i < sizeof($dept) ; $i++) { 
					$name1 = mysqli_real_escape_string($this->conn, $dept[$i]->name);;
					$profile1 = mysqli_real_escape_string($this->conn, $dept[$i]->profile);
					$result_dept = mysqli_query($this->conn, "insert into departments (dept_name, dept_profile, dept_hosp_no) value ('{$name1}','{$profile1}','{$hosp_id}')");
					if($result_dept){			
						$dept_no = mysqli_insert_id($this->conn);
						$spec = $dept[$i]->spec;
						for ($j=0; $j < sizeof($spec) ; $j++) { 
							$name2 = mysqli_real_escape_string($this->conn, $spec[$j]->name);
							$profile2 = mysqli_real_escape_string($this->conn, $spec[$j]->profile);
							$start_date2 = mysqli_real_escape_string($this->conn, $spec[$j]->start_date);
							$result_spec = mysqli_query($this->conn, "insert into specialization 
								(spec_name, spec_profile, spec_start_date, spec_dept_no) value ('{$name2}','{$profile2}','{$start_date2}','{$dept_no}')");
							if($result_spec){			
								
							}else {
								return mysqli_error($this->conn);
							}
						}
					}else {
						return mysqli_error($this->conn);
					}
				}
				return "successfully";
			}else {
				return mysqli_error($this->conn);
			}
		}
		function login($username, $password){
			$username = mysqli_real_escape_string($this->conn, $username);
			$password = mysqli_real_escape_string($this->conn, $password);
			$query = "select * from hospitals where hosp_name  = '{$username}'";
			if($result = mysqli_query($this->conn, $query)){
			    if(mysqli_num_rows($result) > 0){
			    	$arr = mysqli_fetch_assoc($result);
			    	if(password_verify($password, $arr['password'])){
			    		$_SESSION['logged_in'] = "true";
			    		$_SESSION['hosp_name'] = $arr['hosp_name'];
			    		$_SESSION['hosp_id'] = $arr['hosp_id'];
			    		return "window.location.href='hospital_page.php'"; 
			    	}else{
			    		$_SESSION['error_message'] = "Incorrect password or username";
			    		return $_SESSION['error_message'];
			    	}
			    }else{
			    	session_destroy();
			    	$_SESSION['error_message'] = "Incorrect password or username";
			    	return $_SESSION['error_message'];
			    }
			}else{
				return "failed". mysqli_error($this->conn);
			}
		}
		function deg2rad($deg){
		  return $deg * (PI/180);
		}
		function deleteAccount($hosp_id){
			
			if($result = mysqli_query($this->conn, "select * from departments where dept_hosp_no = $hosp_id ")){
			    
		    	while ($arr = mysqli_fetch_assoc($result)) {
			    		$spec_dept_no = $arr['dept_id'];
				    	if(!mysqli_query($this->conn, "delete from specialization where spec_dept_no = $spec_dept_no ")){
							return "failed". mysqli_error($this->conn);
						}
		    	}
			}else{
				return "failed". mysqli_error($this->conn);
			}
			if(!mysqli_query($this->conn, "delete from departments where dept_hosp_no = $hosp_id ")){
				return "failed". mysqli_error($this->conn);
			}

			if(!mysqli_query($this->conn, "delete from hospitals where hosp_id = $hosp_id ")){
				return "failed". mysqli_error($this->conn);
			}
			
			
			return "successfully";
			
		}
		function getDistanceFromLatLonInKm($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000){
		  // convert from degrees to radians
		  $latFrom = $latitudeFrom;
		  $lonFrom = $longitudeFrom;
		  $latTo = $latitudeTo;
		  $lonTo = $longitudeTo;
		
		  $latDelta = $latTo - $latFrom;
		  $lonDelta = $lonTo - $lonFrom;
		
		  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		  return $angle * $earthRadius;
		}
	}
?>