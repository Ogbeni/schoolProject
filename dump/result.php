<!DOCTYPE html>
<html>
<head>
	<title>Add Report</title>
</head>
<style type="text/css">
	    *{
	    	box-sizing: border-box;
	    }
	    .row::after{
	    	content: "";
		    clear: both;
		    display: block;
	    }
    	[class*=col-]{
    		float: left;
		    padding: 15px;
		    border: 1px solid #146941;
    	}
    	.bar{
    		color: black;
    		transition: 2s;
    		background-color: white;
    	}
    	.bar:hover{
    		cursor: pointer;
    		box-shadow: 0 0 6px black;
    	}
    	.col-1 {width: 8.33%;}
		.col-2 {width: 16.66%;}
		.col-3 {width: 25%;}
		.col-4 {width: 33.33%;}
		.col-5 {width: 41.66%;}
		.col-6 {width: 50%;}
		.col-7 {width: 58.33%;}
		.col-8 {width: 66.66%;}
		.col-9 {width: 75%;}
		.col-10 {width: 83.33%;}
		.col-11 {width: 91.66%;}
		.col-12 {width: 100%;}

		.col-offset-1 {margin-left: 4.16%;}
		.col-offset-2 {margin-left: 8.33%;}
		.col-offset-3 {margin-left: 12.5%;}
		.col-offset-4 {margin-left: 16.66%;}
		.col-offset-5 {margin-left: 20.83%;}
		.col-offset-6 {margin-left: 25%;}
		.col-offset-7 {margin-left: 29.16%;}
		.col-offset-8 {margin-left: 33.33%;}
		.col-offset-9 {margin-left: 37.5%;}
		.col-offset-10 {margin-left: 41.66%;}
		.col-offset-11 {margin-left: 45.5%;}
		.col-offset-12 {margin-left: 50%;}

		@media only screen and (max-width: 768px){
			[class*=col-]{
    		width: 80%;
    		margin-left: 10%;
    		}
    		input, textarea, .span{
    			width: 80%;
    			margin-left: 10%;
    			border:1;
    		}
		}
    </style>
<body>
	<div class="col-8 col-offset-4">
        <div class="Result col-12">
            Closest Care Center
        </div>
        <div class="col-12" style="text-align: center;padding: 0;" id="spa">
            LOADING...
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
	var loc = {};
	var formData = new FormData();
	var cont = document.getElementById("spa");
	if(navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
              	loc.lat=position.coords.latitude;
              	loc.lng=position.coords.longitude;
              	cont.innerHTML = "Location Obtained";
              	cont.style.backgroundColor="green";
              	cont.style.color="white";
                getHospitals(position.coords.latitude, position.coords.longitude);         	
          }, function (){
          	cont.innerHTML = "Location Not Obtained";
	      	cont.style.backgroundColor="red";
	      	cont.style.color="white";
          });
      }
    function getHospitals(lat, lng) {
	    var today = new Date();
		today = today.getDate() + '/' + (today.getMonth()+1) + '/' + today.getFullYear()+" "+today.getHours()+":"+today.getMinutes();
    	formData.append('lat', lat);
    	formData.append('lng', lng);
    	console.log(lat);
    	console.log(lng);
    	console.log(today);
    	if (window.XMLHttpRequest) {
              request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
          } else {
              request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
          }
          request.onreadystatechange = function() {
              if (request.readyState == 4 && request.status == 200) {
                  var rsp = JSON.parse(request.responseText);
                  updateLocations(rsp);
                  console.log(rsp);
              }
          }
          request.open("POST", "./php_files/get_locations.php", true);
          request.send(formData);
    }
    function updateLocations( arr ) {
        for (var i = 0; i< arr.length; i++) {
            var newNode = document.createElement("div");
            newNode.classList.add("col-12");
            newNode.innerHTML = arr[i][1];
            cont.parentElement.append(newNode);
        }
    }
</script>