<?php require('./include/'.basename(__FILE__, '.php').'.php');?>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBFRvuZOGZ0F0iGeMCUwpgwykVMRQsMlHA"></script>
<script type="text/javascript">
//<![CDATA[
var map;
var marker;
var url = new URL(window.location.href);
var my_current_location = url.searchParams.get("lat")+" "+url.searchParams.get("lng");
var center = new google.maps.LatLng(url.searchParams.get("lat"), url.searchParams.get("lng"));

var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();

var d_marker = null;
var directionsService = new google.maps.DirectionsService();
var directionsDisplay = new google.maps.DirectionsRenderer();

function init() {

    var mapOptions = {
        zoom: 13,
        center: center,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('directions_panel'));
    var position = new google.maps.LatLng(url.searchParams.get("lat"), url.searchParams.get("lng"));
    marker = new google.maps.Marker({
        map: map,
        position: position,
        title: location.name,
        draggable: true,
        icon:'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        animation: google.maps.Animation.DROP
    });
    google.maps.event.addListener(marker, 'dragend', function() {
		map.setCenter(new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng() ));
	});

}
function calculateRoute(elem) {
	document.querySelector("div#map_container").style.display = "block";
	if(elem==null){
		return;
	}
	var destination = elem.id.split(" ");
	console.log((destination[0] * 180)/Math.PI );
	var d_position = new google.maps.LatLng((destination[0] * 180)/Math.PI,(destination[1] * 180)/Math.PI);
	if(d_marker!=null){
    	d_marker.setPosition(d_position);
    	return;
	}
	d_marker = new google.maps.Marker({
        map: map,
        position: d_position,
        title: "destination",
        icon:'https://maps.google.com/mapfiles/ms/icons/hospitals.png',
        animation: google.maps.Animation.BOUNCE
    });
    
}



//]]>
</script>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		.nav-bar, .hosp_name {
			margin: 0;
			color: #fff;
			background-color: #001160;
			transition: 2s;
		}
		.hosp_container {
			 padding: 0; margin:0; margin-bottom:2%; background-color: #ebecfe;
			 box-shadow:0 0 5px #001160;
		}
		.distance_kg{
			background-color: #a58efb;
		}
		.close_map{
			text-align: center;
		}
		.close_map:hover{
			cursor: pointer;
		}
		@media only screen and (max-width: 850px){
    		input{
    			width: 80%;
    			margin-left: 10%;
    			border:1;
    		}
    		.nav-bar,.hosp_container, .main_div, #dept_container, .hosp_name, #map_container, #map_canvas{
    			width: 100%;
    			margin: 0;
    		}
    		.hosp_container{
    			margin-bottom: 2%
    		}
    		.main_div{
    			margin: 0;
    			padding: 0;
    		}
    		.mao
    		#spec_container_out{
    			padding-left: 0;
    			padding-right: 0;
    		}
    		.logo{
    			margin-left: 40%;
    		}
		}
	</style>
</head>
<body id="main_div" style="padding: 0; margin:0; background-color: #cacbfa;" >
<div class="col-6 col-offset-6 note-pane">
		Errr
	</div>		
		<div class="col-12 nav-bar" style="text-align: center; margin:0;">
			<a href="."><img class="col-2 col-offset-2 logo" src="./img/logo.png" style="max-width: 100px;"></a>
			<h2 class="col-4">Hospitals</h2>
			<div class="col-4">
				<div class="col-8">
					<input id="s_value" type="text" placeholder="search"/>
				</div>
				<div class="col-4">
					<button onclick="getHospitals()">Search</button>
				</div>
			</div>
		</div>
		<div class="col-offset-4 col-8" id="map_container">
			<div class="col-12 close_map" style="background-color: red;" onclick="closeMap(this)">
				CLOSE
			</div>
			<div class="col-12" id="map_canvas" style="height: 400px; left: 0;position: fixed;">
			
			</div>	
		</div>
		
		<div class="col-offset-4 col-8" id="dept_container">
			
				<?php 
				for ($i = 0; $i < sizeof($data[1]);$i++) {
					$url_l = "./hospital_page.php?hosp_id=".$data[0][$i]."&hosp_name=".$data[1][$i];
					
					echo '<div class="col-12 hosp_container" >';
					echo '<a href="'.$url_l.'" onclick="layout_dept(this)" >';
					echo '<div class="col-8 hosp_name">';
					echo $data[1][$i];
					echo '</div></a>';
					echo '<div class="col-4 distance_kg" id= "'.$data[3][$i] .' '.$data[4][$i]. '" onclick="calculateRoute(this)">';
					echo $data[6][$i]." km";
					echo '</div>';
					echo '<div class="col-12"><p>';
					echo $data[5][$i];
					echo '</p></div>';
					echo '</div>';
					;
				}
				
				 ?>
		</div>
		<img class="map_icon" src="./img/map_icon.png" onclick="calculateRoute(null)">
</body>
</html>	
<script type="text/javascript" src="./js/home.js?2"></script>