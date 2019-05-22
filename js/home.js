'use strict'
	var data;
	document.querySelector("div#dept_container").style.marginTop = document.querySelector("div.nav-bar").clientHeight+"px";
	document.querySelector("div#map_container").style.marginTop =(document.querySelector("div.nav-bar").clientHeight)+"px";
	init();
	var closeMap = (e)=>{
		e.parentNode.style.display = "none";
	}
	function getHospitals(){
		var s_value = document.querySelector("input#s_value").value;
		displayNotePane("Searching...",true);
		var formData = new FormData();
		formData.append('s_value', s_value);
		formData.append('lat', marker.getPosition().lat());
		formData.append('lng', marker.getPosition().lng());
		// console.log(marker.getPosition().lat());
		var request;
		if (window.XMLHttpRequest) {
	          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
	      } else {
	          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
	      }
	      request.onreadystatechange = function() {
	          if (request.readyState == 4 && request.status == 200) {
	          	// console.log(request.responseText);
				  	data = JSON.parse(request.responseText);
				  	bindResult(data);
	              
	          }
	      }
	      request.open("POST", "./php_files/hospital_result.php", true);
	      request.send(formData);
	}
	function bindResult(jsonData){
		// console.log(jsonData[0].length);
		var dept_container = document.querySelector("div#dept_container");
		if(jsonData == "" ){
			
			displayNotePane("Soory No result... ");
			return;
		}
		dept_container.innerHTML = "";
		for (var i = 0; i< jsonData[0].length; i++) {
			var url_l = "./hospital_page.php?hosp_id="+jsonData[0][i]+"&hosp_name="+jsonData[1][i];
			var outterLink = document.createElement("a");
			outterLink.href = url_l;
			
			var hosp_name = document.createElement("div");
			hosp_name.className = "col-8 hosp_name";
			hosp_name.innerHTML = jsonData[1][i];
			var hosp_var = document.createElement("div");
			hosp_var.className = "col-4 distance_kg";
			hosp_var.onclick =  (e)=>{calculateRoute(e.target);};
			hosp_var.id = jsonData[3][i] +' '+jsonData[4][i];
			hosp_var.innerHTML = jsonData[6][i]+" km";
			var hosp_profile = document.createElement("p");
			hosp_profile.innerHTML = jsonData[5][i];
			hosp_profile = document.createElement("div").appendChild(hosp_profile);
			hosp_profile.className = "col-12";
			
			outterLink.appendChild(hosp_name);
			
			
			var hosp_container = document.createElement("div");
			hosp_container.className = "col-12 hosp_container";
			hosp_container.appendChild(outterLink);
			hosp_container.appendChild(hosp_var);
			hosp_container.appendChild(hosp_profile);
			
			
			dept_container.appendChild(hosp_container);
		}
	}
	function displayNotePane(message, ab=false){
		var note_pane = document.querySelector("div.note-pane");
		note_pane.style.marginTop = "5%";
		note_pane.innerHTML = message;
		if(ab){
			note_pane.style.backgroundColor = "green";
		}else{
			note_pane.style.backgroundColor = "#ff0060";
		}
		setTimeout(()=>{note_pane.style.marginTop = "-100%";}, 3000);
		document.body.scrollIntoView();
    }