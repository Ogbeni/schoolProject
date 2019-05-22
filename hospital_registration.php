<!DOCTYPE html>
<html>
<head>
	<title>Register Hospital</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/hospital_registration.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBFRvuZOGZ0F0iGeMCUwpgwykVMRQsMlHA"></script>
<script type="text/javascript">
//<![CDATA[




//]]>
</script>
<body style="margin: 0;  background-color: #cacbfa;">
	<div class="col-6 col-offset-6 note-pane">
		Errr
	</div>
	<div class="col-12 nav-bar">
		<a href="."><img class="col-2 col-offset-2 logo" src="./img/logo.png" style="max-width: 100px;"></a>
		
		<div id="tmp_hosp_name" class="col-8" style="text-transform: uppercase; text-align: center;">
			<h2>Hospital Setup</h2>
		</div>
		<div id="dept_container_button" class="col-2 add-department" style="float: right;border: 1px solid #146941;">
			<span> Add Department</span>
		</div>
	</div>
	
	<div class="col-12 input-body" style="margin: 0; padding: 0;">
		<div class="col-offset-4 col-8 hosp_container">
			<input type="text" id="hosp_name" placeholder="Hospital Name">
			<input type="text" id="hosp_address" placeholder="Hospital Address">
			<textarea id="hosp_profile" value="Hospital Profile"/></textarea>
			<input type="password" id="password" placeholder="Password">
			<input type="password" id="repeat_password" placeholder="Repeat Password">
		</div>
		<div class="col-12" id="dept_container">
			<div class="col-6 dept_item" id="init_dept">
				
				<input class="col-11" type="text" name="department_name" placeholder="Department Name">
				<span class="col-1 close_it" onclick="close_it(this)">X</span>
				<textarea name="department_profile" placeholder="Department Profile"></textarea>
				<div class="col-12" id="spec_container" style="padding: 0;">
					<button id="spec_container_button" class="col-12" onclick="addSpec(this)"> Add specialization </button>
					<div class="col-6 spec_item" id="init_spec">
						<input class="col-10" type="text" name="spec_name" placeholder="Specialization Name">
						<span class="col-2 close_it" onclick="close_it(this)">X</span>
						<textarea name="spec_profile" placeholder="Profile"></textarea>
						<input type="date" placeholder="Start Date">
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 reg_hosp" onclick="registerHosp(this)"> Register Hospital</div>
		<img class="map_icon" src="./img/map_icon.png" onclick="calculateRoute(null)">
		<div class="col-offset-4 col-8" id="map_container" style="top: 20%;">
				<div class="col-12 close_map" style="background-color: red;" onclick="closeMap(this)">
					CLOSE
				</div>
				<div class="col-12" id="map_canvas" style="height: 400px; left: 0;position: fixed;">
				
				</div>	
			</div>
	</div>
</body>
</html>	
<script type="text/javascript" src="./js/hospital_reg.js"></script>