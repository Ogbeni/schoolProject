<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
</head>
<link rel="stylesheet" href="css/main.css">
<body>
	<div class="col-8 col-offset-4" style="text-align:center;">
	    <div class="col-12 header" id="header_title" >
	      Login
	    </div>
      	<input type="text" id="h_name" placeholder="Hospital Name" class="col-12">
      	<input type="password" id="h_password" placeholder="Password" class="col-12">
      	<button type="submit" name="submit" onclick="h_login()" class="col-12">Login</button>
 	</div>
</body>
</html>
<script type="text/javascript">
	
	function h_login() {
		var request;
		var header_title = document.getElementById("header_title");
		var h_name = document.getElementById("h_name");
		var h_password = document.getElementById("h_password");
		var all = true;
		if(!h_name.value.length > 0){
			all = all && false;
			h_name.focus();
			return;
		}
		if( h_password.value.length < 8 ){
			all = all && false;
			h_password.focus();
			return;
		}
		var formData = new FormData();
		formData.append('h_name', h_name.value);
		formData.append('h_password', h_password.value);
		if (window.XMLHttpRequest) {
	          request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
	      } else {
	          request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
	      }
	      request.onreadystatechange = function() {
	          if (request.readyState == 4 && request.status == 200) {
	              console.log(request.responseText);
	              if(request.responseText === "Invalid Username"){
	              	header_title.innerHTML = request.responseText;
	              	header_title.style.backgroundColor = "#ff000090";
	              	h_name.focus();
					return;
	              }else if(request.responseText === "Incorrect password or username"){
	              	header_title.innerHTML = request.responseText;
	              	header_title.style.backgroundColor = "#ff000090";
	              	h_password.focus();
	              }else{
	              	eval(request.responseText);
	              }
	          }
	      }
	      request.open("POST", "./php_files/login_process.php", true);
	      request.send(formData);
	}
</script>