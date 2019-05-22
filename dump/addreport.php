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
    	.signin:active{
    		cursor: pointer;
    		border-width: 1px;
    		box-shadow: 0 0 2px #146941,0 0 2px magenta;
    	}
    	.navbar{
            text-align: center;
            background-color: #146941;
            box-shadow:0 0 5px #146941;
            margin-bottom: 0.5%;
        }
        .logo{
            width: 30%;
            height: auto;
        }
    	body{
    		color: black;
    		/*background-image: url("images/1.jpeg");
    		background-repeat: no-repeat;
    		background-size: cover;*/
    		background-color: rgba(30, 0, 30, 0.5);
    	}
    	input, textarea, .span{
    		height: 40px;
    		border-style: solid;
    		border-width: 1px;
    		border-color: black;
    		text-align: center;
    		width: 80%;
    		margin: 5px;
    		color: white;
    		transition: 2s;
    		color: black;

    	}
    	textarea{
    		height: 80px;
    	}
    	.panel{
    		border-radius: 0 0 5px 5px;
    		background-color: rgba(255, 255, 255, 0.6);
    	}
    	.header{
    		text-align: center;
    		background-color: #146941;
    		color: #fff;
    	}
    	.nav{
    		text-align: center;
    		background-color: #146941;
    		border-radius: 10px 10px 0 0;
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
			.tip{
				position: absolute;
				border-color: white;
				color: white;
				box-shadow: 0 0 20px white;
				margin-top: 20px;
			}
			.tip_close{
				position: absolute;
				right: 5px;
				top: 5px;
				color: red;
			}
    	input:focus, textarea:focus, .span:focus{
    		border-color: #146941;
    		box-shadow:0 0 5px #146941;
    		background-color: #146941;
    		color: white;
    	}
    	.mbutton{
    		background-color: #146941;
    		color: white;
    	}
    	.mbutton:hover{
    		cursor: pointer;
    		box-shadow:0 0 5px #146941;

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
	<input type="title" id="title" id="title" placeholder="Title">
	<textarea id="desc" placeholder="Description"></textarea>
	<div class="span" id="span" style="background-color: white">Loading location...</div>
	<input value="REPORT" class="mbutton" value="REPORT" onclick="submitform()">
</body>
</html>
<script type="text/javascript">
	var loc = {};
	var formData = new FormData();
	var cont = document.getElementById("span");
	if(navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
              	loc.lat=position.coords.latitude;
              	loc.lng=position.coords.longitude;
              	cont.innerHTML = "Location Obtained";
              	cont.style.backgroundColor="green";
              	cont.style.color="white";
              	
          }, function (){
          	cont.innerHTML = "Location Not Obtained";
	      	cont.style.backgroundColor="red";
	      	cont.style.color="white";
          });
      }
    function submitform() {
    	
    	var form_title = document.getElementById('title').value;
	    var form_desc = document.getElementById('desc').value;
	    var today = new Date();
		today = today.getDate() + '/' + (today.getMonth()+1) + '/' + today.getFullYear()+" "+today.getHours()+":"+today.getMinutes();
		
    	formData.append('title', form_title);
    	formData.append('desc', form_desc);
    	formData.append('lat', loc.lat);
    	formData.append('lng', loc.lng);
    	formData.append('issue_date', today);
    	console.log(form_title);
    	console.log(form_desc);
    	console.log(loc.lat);
    	console.log(loc.lng);
    	console.log(today);
    	if (window.XMLHttpRequest) {
              request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
          } else {
              request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
          }
          request.onreadystatechange = function() {
              if (request.readyState == 4 && request.status == 200) {
                  console.log(request.responseText);
                  window.location = "./index.html";
              }
          }
          request.open("POST", "./addtodb.php", true);
          request.send(formData);
    }
</script>