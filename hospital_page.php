<?php require('./include/'.basename(__FILE__, '.php').'.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Register Hospital</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/hospital_page.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body id="main_div" style="padding: 0; margin:0;  background-color: #cacbfa;" >
	<div class="col-6 col-offset-6 note-pane">
		Errr
	</div>
	<div class="col-12 main_div_body" style="padding: 0; margin:0;">
		<?php 	
			if(!$guest){
				echo '
					<div class="col-offset-2 col-10 first_hidden" id="dept_container_hidden">
					<h3 id="dept_container_button_hidden" class="col-10 col-offset-2"> Add Department </h3>
					<input type="text" name="department_name" placeholder="Department Name">
					<textarea name="department_profile" placeholder="Department Profile"></textarea>
					<div class="col-12" id="spec_container_hidden" style="margin: 0;padding: 0;" >
						<button id="spec_container_button" class="col-12" onclick="addSpec(this)"> Add specialization </button>
						<div class="col-6 spec_item" id="init_spec">
							<input type="text" placeholder="Specialization Name">
							<textarea type="text" placeholder="Profile"></textarea>
							<input type="date" placeholder="Start Date">
							
						</div>
					</div>
					<button class="col-6 col-offset-6" onclick="addDepartment(this)"> Add Department </button>
					</div>
				';
			}
		 ?>
		<div class="col-offset-2 col-10 first_hidden" id="update_hidden">
		</div>
		<div class="col-12 nav-bar" style="text-align: center;">
			<h2><?php echo $data['hosp_name']; ?></h2>
			<?php 
				if(!$guest){
					echo '<a href="./php_files/logout_process.php"><div class="col-2 logout" style="margin: 0; float:right;"> logout </div></a>';
				}
			?>
			
		</div>
		<div class="col-12" id="dept_container">
				<div class="col-12 dept_container_head">
				<?php 	
					if($guest){
						echo '<div id="dept_container_button" class="col-12 add_dept add_dept_m" style="margin: 0;"> Departments </div>';
					}else{
						echo '<div id="dept_container_button" class="col-11 add_dept add_dept_m" style="margin: 0;"> Departments </div>';
						echo '<div class="col-1 add_dept_m" style="margin: 0;" id="add_new_dept"> ADD </div>';
					}
				 ?>
				</div>
			
				<?php 
				if(isset($data['dept'])){
					foreach ($data['dept'] as $v => $value) {
						echo '<div class="col-4 col-offset-1 dept">';
						echo '<a href="#spec_container_out" onclick="layout_dept(this)" id="'.$v.'" >'.$value["dept_name"].'</a>';
						echo '<div class="spec col-2">';
						foreach ($value["dept_spec"] as $s => $spec) {
							$tm = "{$v},{$s}";

							echo '<a href="#spec_container_out" onclick="layout_spec(this)" id="'.$tm.'">'.$spec["spec_name"].'</a>';
							
						}
						echo '</div>';
						echo '</div>';
					}
				}
				 ?>
				
		</div>
		<div class="col-offset-4 col-8" id="spec_container_out" style="display: none;">
			<h3 id="spec_container" class="col-12" ondblclick="update(this)"></h3>
			<div id="date_container" class="col-12" ondblclick="update(this)">
				
			</div>
			
			<div id="profile_container" class="col-12" ondblclick="update(this)">
				
			</div>
		</div>
		<?php 
			if(!$guest){
				// 
				$warning = "'Are you Sure you want to delete ".$data['hosp_name']."'";
				echo '<div class="col-3 reg_hosp" id="drop_button" style="background-color: brown; display: none;"> Drop </div>';
				echo '<a href="./php_files/delete_account.php?hosp_id='.$hosp_id.'" 
				onclick="return confirm('.$warning.')"><div class="col-2 reg_hosp" id="drop_button" style="background-color: red; z-index: -1"> Delete Account </div></a>';
			}
		 ?>
		
	</div>
</body>
</html>	
<script type="text/javascript">
	const entr ='<?php echo str_replace("'", "\'", str_replace("\\", "\\\\", json_encode($data) ) ); ?>';
	var guest = '<?php echo $guest; ?>' == '1';
	document.querySelector("div#dept_container").style.marginTop = document.querySelector("div.nav-bar").clientHeight+"px";
</script>
<script type="text/javascript" src="./js/hospital_page.js?1"></script>
