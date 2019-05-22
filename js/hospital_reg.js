var map;
var url = new URL(window.location.href);
var center = new google.maps.LatLng(9, 8);

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
    

}
function calculateRoute(elem) {
	document.querySelector("div#map_container").style.display = "block";
	
	var d_position = new google.maps.LatLng(9, 8);
	if(d_marker!=null){
    	return;
	}
	console.log(lat );
	d_marker = new google.maps.Marker({
        map: map,
        position: d_position,
        title: "destination",
        icon:'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
        draggable:true,
        animation: google.maps.Animation.BOUNCE
    });
    
}
	init();
	var tmp_hosp_name = document.querySelector("#tmp_hosp_name");
	var hosp_name = document.querySelector("#hosp_name");
	hosp_name.onkeyup = (e)=>{
		tmp_hosp_name.innerHTML = hosp_name.value;
		if(e.value == ""){
			tmp_hosp_name.innerHTML = "Hospital";
		}
	}
	var lat = "";
	var lng = "";
	if(navigator.geolocation) {
    	navigator.geolocation.getCurrentPosition(function(position) {
	      	lat = position.coords.latitude;
	      	lng = position.coords.longitude;
	      	map.setCenter(new google.maps.LatLng(lat, lng));
			var d_position = new google.maps.LatLng(lat,lng);
			if(d_marker!=null){
		    	d_marker.setPosition(d_position);
		    	return;
			}
			d_marker = new google.maps.Marker({
		        map: map,
		        position: d_position,
		        title: "destination",
		        icon:'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
		        draggable:true,
		        animation: google.maps.Animation.BOUNCE
		    });
		    google.maps.event.addListener(d_marker, 'dragend', function() {
			    // console.log(d_marker.getPosition().lng());
			    lat = d_marker.getPosition().lat();
	      		lng = d_marker.getPosition().lng();
			});
	      	displayNotePane("Location Obtained", true);
        }, function (){
	      	displayNotePane("Location Not Obtained");
	    });
     }


	var hosp_details = {};
	var dept_container = document.getElementById("dept_container");
	var dept_container_button = document.getElementById("dept_container_button");
	var spec_container_button = document.getElementById("spec_container_button");
	var init_dept = document.getElementById("init_dept");
	var init_spec = document.getElementById("init_spec");
	var default_dept_text = init_dept.innerHTML;
	var default_spec_text = init_spec.innerHTML;
	function defaultdept(a, b){
		var mdiv = document.createElement("div");
		mdiv.className = "col-6 "+b;
		mdiv.innerHTML=a;
		return mdiv;
	}
	function addSpec(e){
		var spec_container = e.parentNode;
		spec_container.appendChild(defaultdept(default_spec_text, "spec_item"));
		spec_container.lastElementChild.scrollIntoView();
	}
	dept_container_button.addEventListener('click', function (e) {
		dept_container.appendChild(defaultdept(default_dept_text, "dept_item"));
		dept_container.lastElementChild.scrollIntoView();
	});
	function registerHosp(tra){
		var all = true;
		var tranv = tra.parentNode.firstElementChild;
		hosp_details.name = tranv.firstElementChild.value.trim();
		hosp_details.address = tranv.firstElementChild.nextElementSibling.value.trim();
		hosp_details.profile = tranv.firstElementChild.nextElementSibling.nextElementSibling.value.trim();
		hosp_details.password = tranv.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.value;
		hosp_details.lat = lat;
		hosp_details.lng = lng;
		if(hosp_details.lat.length < 1){
			all = all && false;
			displayNotePane("Location has not been Obtained yet <br><i><b>try Reloading the page</b></i>");
			return;
		}
		if(!hosp_details.name.length > 0){
			all = all && false;
			tranv.firstElementChild.focus();
			displayNotePane("Hospital Name is Empty");
			return;
		}
		
		if(!hosp_details.address.length > 0){
			all = all && false;
			tranv.firstElementChild.nextElementSibling.focus();
			displayNotePane("Address is Empty");
			return;
		}
		if(!hosp_details.profile.length > 0){
			displayNotePane("Profile is Empty");
			all = all && false;
			tranv.firstElementChild.nextElementSibling.nextElementSibling.focus();
			return;
		}
		if(hosp_details.password.length < 7){
			all = all && false;
			tranv.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.focus();
			displayNotePane("Password is less than 8");
			return;
			
		}else{
			if(! (hosp_details.password === tranv.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.value)){
				all = all && false;
				tranv.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.focus();
				displayNotePane("Passwords do not tally");
				return;
			}
		}
		
		tranv = tranv.parentNode.getElementsByClassName("dept_item");
		
		var dept_item = [];
		for (var i = 0; i < tranv.length; i++) {
			var dept_d = {};
			dept_d.name = tranv[i].firstElementChild.value.trim();
			dept_d.profile = tranv[i].firstElementChild.nextElementSibling.nextElementSibling.value.trim();
			if(!dept_d.name.length > 0){
				all = all && false;
				tranv[i].firstElementChild.focus();
				displayNotePane("Department name is Empty");
				tranv[i].firstElementChild.scrollIntoView();
				return;
			}
			if(!dept_d.profile.length > 0){
				all = all && false;
				tranv[i].firstElementChild.nextElementSibling.focus();
				displayNotePane("Department profile is Empty");
				tranv[i].firstElementChild.nextElementSibling.scrollIntoView();
				return;
			}
			var spec_d = tranv[i].getElementsByClassName("spec_item");
			var spec_item = [];
			for (var j = 0; j < spec_d.length; j++) {
				var spec_d_d = {};
				spec_d_d.name = spec_d[j].firstElementChild.value;
				spec_d_d.profile = spec_d[j].firstElementChild.nextElementSibling.nextElementSibling.value;
				spec_d_d.start_date = spec_d[j].lastElementChild.value;
				spec_item[j] = spec_d_d;
				if(!spec_d_d.name.length > 0){
					all = all && false;
					spec_d[j].firstElementChild.focus();
					displayNotePane("Specialization name is Empty");
					spec_d[j].firstElementChild.scrollIntoView();
					return;
				}
				if(!spec_d_d.profile.length > 0){
					all = all && false;
					spec_d[j].firstElementChild.nextElementSibling.focus();
					displayNotePane("specializations profile is Empty");
					spec_d[j].firstElementChild.nextElementSibling.scrollIntoView();
					return;
				}
				if(!spec_d_d.start_date > 0){
					all = all && false;
					spec_d[j].lastElementChild.focus();
					displayNotePane("specializations start date not set");
					spec_d[j].lastElementChild.scrollIntoView();
					return;
				}
			}
			dept_d.spec = spec_item;
			dept_item[i] = dept_d;
		}
		hosp_details.dept = dept_item;
		if(all){
			displayNotePane("Data is correctly filled", true);
			displayNotePane("Loading", true);
			var formData = new FormData();
			formData.append('json_text', JSON.stringify(hosp_details));
			if (window.XMLHttpRequest) {
		          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
		      } else {
		          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
		      }
		      request.onreadystatechange = function() {
		          if (request.readyState == 4 && request.status == 200) {
		              console.log(request.responseText);
		              if(request.responseText ==  'successfully'){
		              	eval(window.location.href = 'index.php#login');
		              }else{
		              	displayNotePane("Name has been used already");
		              }
		          }
		      }
		      request.open("POST", "./php_files/addtodb.php", true);
		      request.send(formData);
		}

	}
	function displayNotePane(message, ab=false){
		var note_pane = document.querySelector("div.note-pane");
		var reg_hosp = document.querySelector(".reg_hosp");
		note_pane.style.marginTop = "5%";
		note_pane.innerHTML = message;
		if(ab){
			note_pane.style.backgroundColor = "green";
		}else{
			note_pane.style.backgroundColor = "#ff0060";
			reg_hosp.style.boxShadow="0 0 10px #ff0060";
		}
		setTimeout(()=>{note_pane.style.marginTop = "-100%";}, 5000);
		document.body.scrollIntoView();
    }
    var close_it = (e)=>{
    	console.log(e);
		var p = e.parentElement.parentElement;
		p.removeChild(e.parentElement);
	}
	var closeMap = (e)=>{
		e.parentNode.style.display = "none";
	}
    var tNav = document.querySelector("div.nav-bar");
    document.querySelector("div.input-body").style.marginTop = tNav.clientHeight+"px";
    