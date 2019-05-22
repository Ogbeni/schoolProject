<?php require('./include/'.basename(__FILE__, '.php').'.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Online Hospital Directory Management System</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/icon.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBFRvuZOGZ0F0iGeMCUwpgwykVMRQsMlHA"></script>
	<script type="text/javascript" src="./js/init_map.js"></script>
</head>
<body id="top" onscroll="scrollTerm(this)" style="margin: 0;" onload="replacePage()">
	<div class="col-12 nav-bar">
		<span class="col-2 header-menu-toggle">
			MENU
		</span>

		<div class="col-8 main-nav-wrap" id="main-nav-wrap">
			<ul class="main-navigation">
				<a href="#home"><li class="current">Home</li></a>
				<a href="#about"><li>About</li></a>
				<a href="#features"><li>Features</li></a>
				<a href="#reg_hosp"><li>Registered Hostpitals</li></a>
				<a href="#login"><li>Login</li></a>
			</ul> 
			
		</div>
		<div class="col-2 download-app" style="float: right;border: 1px solid #146941;">
			<span> Download App</span>
		</div>
	</div>
	<div class="col-12 current section" id="home" >
		<div class=" col-offset-2 col-10 main-container">
			<div class="col-6" style="background-color: #00116050;">
				<h5 style="word-spacing: 10px;">Welcome To the Online Hospital Management System</h5>
				<h1 class="here">Here We Connect our users to the their closest hospital</h1>
				<div class="col-6 col-offset-6" style="margin-top: 30px;background-color: #001160;">
					<span> Download App</span>
				</div>
			</div>
			<div class="col-4 col-offset-2" style="	padding: 0;">
				<img src="./img/app.png"/ style="width: 100%; height: auto; margin: 0; max-height: 700px; max-width: 300px;">
			</div>
			<div class="col-5 col-offset-2" style="	padding: 0;">
				
			</div>
		</div>
	</div>
	<div class="col-12 section" id="about">
		<div class=" col-offset-1 col-11 main-container" style="margin-top: 50px;">
			<div class="col-offset-6 col-6" style="text-align: center; font-family: monospace;">	
				<h1>ABOUT</h1>
			</div>
			<div class="col-11 col-offset-1" style="background-color: #00116040; border-radius: 15px; font-family: monospace;">
				<p>The goal of this platform is to guides it users to the closest health care and in turn saves life that would have been lost due to lack information that this system would have readily available to its users at all time and place. The goal of this system is to help make informed decisions at user's convenience and provide alternatives to them.</p>
				<p>This system illustrate the use of web development tools to provide a hospital repository with geolocation features to bridge an information gap in the system and help avoid deaths due to the absence of information. This system allows user to find the closest hospitals to their vicinities.</p>
				<p>This System would be the “go to” platform for making informed decisions about which heath care center would be most appropriate for a user’s need at every point in time. </p>
			</div>
			
		</div>
	</div>
	<div class="col-12 section" id="features" style="text-align: center; background-color: #00116050;">
		<div class="col-offset-4 col-8 main-container" text-align: center;">
			<div class="col-offset-4 col-8">	
				<h1>Loaded With Features You Would Absolutely Love.</h1>
				<p>The system provides a list of the closest hospitals in the vicinity of the user making use of the system. This list of result depends of the person’s current location with added features</p>
			</div>
		</div>
		<div class="col-4">
				<i class="icono-imac" style="font-size: 12px; color: #001160;"></i>
				<h1>Simple User Interface</h1>
				<p>The sytem privides a simple and straight forward interface which would make users get familiar with platform much faster.</p>
			</div>
			<div class="col-4">
				<i class="icono-support" style="font-size: 12px; color: #001160;"></i>
				<h1>Descriptive Map Features</h1>
				<p>The system provides a Web Map that is used to display the closest route from current location to the selected hospital location.	</p>
			</div>
			<div class="col-4">
				<i class="icono-pin" style="font-size: 12px; color: #001160;"></i>
				<h1>GPS<br> Tracking</h1>
				<p>This system provides an app for accessing the service it provides at great ease. Note: services can be accessed through any GPS enabled devices.</p>
			</div>
			<div class="col-4">
				<i class="icono-locationArrow" style="font-size: 12px; color: #001160;"></i>
				<h1>Guidence System</h1>
				<p>The system provides a Web Map that is used to display the closest route from current location to the selected hospital location.</p>
			</div>
			<div class="col-4">
				<i class="icono-commentEmpty" style="font-size: 12px; color: #001160;"></i>
				<h1>Users Rating</h1>
				<p>After using the system, the hospital recommended can be rated and others would see the rating of the hospital week searching for hospital next time.</p>
			</div>
	</div>
	<div class="col-12 section" id="reg_hosp" style="position: relative;">
		<!-- <div class="col-1 left-arrow">
			<i class="icono-rewind"></i>
		</div> -->
		<div class="col-12 main-container flexslider">
			<?php 
			for ($i = 0; $i < sizeof($data[1]);$i++) {
				$url_l = "./hospital_page.php?hosp_id=".$data[0][$i]."&hosp_name=".$data[1][$i];
				echo '<a href="'.$url_l.'" onclick="layout_dept(this)" >';
				echo '<div class="col-12 hosp_container" id="my_hosp_container">';
				echo '<div class="col-12" style="text-transform: uppercase; font-size: 30px;">';
				echo $data[1][$i];
				echo '</div><div class="col-12" style="text-transform: uppercase; font-size: 13px;">';
				echo $data[2][$i];
				echo '</div><p class="col-12">';
				echo $data[5][$i];
				echo '</p></div>';
				echo '</a>';
			}
			
			 ?>
			 <div class="col-12" id="map_canvas">
			 </div>
		</div>
		<!-- <div class="col-1 right-arrow">
			<i class="icono-forward"></i>
		</div> -->
		<div class="col-12" style="position: relative; text-align: center;">
			<div class="col-2"></div>
			<?php 	
				for ($i=0; $i <sizeof($data[1]) ; $i++) { 
					echo '<div class="col-offset-1 col-1 hos_pointer" style="text-transform: uppercase;">';
					
					echo '</div>';
				}
			 ?>
			 <a id="view_more" href="./home.php"><div class="col-1">
			 	view more
			 </div></a>
		</div>
	</div>
	<div class="col-12 section" id="login">
		<div class=" col-offset-4 col-8 main-container" style="height: 500px; text-align: center;text-transform: uppercase;"	>
			<h1 id="header_title">
		      Login
		    </h1>
	      	<input type="text" id="h_name" placeholder="Hospital Name" class="col-12">
	      	<input type="password" id="h_password" placeholder="Password" class="col-12">
	      	<button type="submit" name="submit" onclick="h_login()" class="col-12" style="background-color: #001160; color: #fff;">Login</button>
	      	<label style="text-transform: lowercase;">Don't have an Account <a href="./hospital_registration.php" style="text-transform: uppercase;">Sign Up</a> </label>
		</div>
	</div>
</body>
</html>
<script type="text/javascript" src="./js/index.js?2"></script>
<script type="text/javascript">
	document.querySelector("div#map_canvas").style.height =document.querySelector("div#my_hosp_container").clientHeight+"px";

</script>
