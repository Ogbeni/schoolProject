
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
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
    		input{
    			width: 80%;
    			margin-left: 10%;
    			border:1;
    		}
		}
        </style>        
        <script type="text/javascript" src="./config.js">

        </script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBFRvuZOGZ0F0iGeMCUwpgwykVMRQsMlHA"></script>
        <script type="text/javascript">
        //<![CDATA[

        var map;

        var center = new google.maps.LatLng(9.0802364 , 7.0802364);

        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();

        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();

        function init() {

            var mapOptions = {
                zoom: 6,
                center: center,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            if(navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {

                document.getElementById('start').value = position.coords.latitude+" "+ position.coords.longitude;
                  var userLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

                  geocoder.geocode( { 'latLng': userLocation }, function(results, status) {
                      if (status == google.maps.GeocoderStatus.OK) {
                      }
                  });

              }, function() {
                  alert('Geolocation is supported, but it failed');
              });
          }
            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(document.getElementById('directions_panel'));

            makeRequest('./php_files/get_location_hospital_location.php', function(data) {

               // var data = JSON.parse(data.responseText);
               var selectBox = document.getElementById('destination');
               // for (var i = data.length-1; i >= 0; i--) {
                //    displayLocation(data[i]);
                //    addOption(selectBox,data[i]['name'],data[i]['lat']+" "+data[i]['lng'] );
               // }
               displayLocation({
                   "name":"test_name",
                   "lat":<?php echo $_GET['lat'] ?>,"lng":<?php echo $_GET['lng'] ?>,
                   // "lat":"9.057894","lng":"7.458816",
                   "issue_date":"n/a",
                   "address":"n/a","description":"n/a"
               });
               var tlat = <?php echo $_GET['lat'] ?>;
               var tlng = <?php echo $_GET['lng'] ?>;
               addOption(selectBox,"test_name",tlat+ " "+tlng);
           });
            /*var marker = new google.maps.Marker({
                map: map,
                position: center,

            });*/

        }
        function makeRequest(url, callback) {
          var request;
          if (window.XMLHttpRequest) {
              request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
          } else {
              request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
          }
          request.onreadystatechange = function() {
              if (request.readyState == 4 && request.status == 200) {
                  callback(request);
              }
          }
          request.open("GET", url, true);
          request.send();
      }
      function displayLocation(location) {

        var content =   '<div class="infoWindow"><strong>'  + location.name + '</strong>'+'<br><span><i>'+ location.issue_date+'</i></span>'
                        + '<br/>'     + location.address
                        + '<br/>'     + location.description + '</div>';

        if (parseInt(location.lat) == 0) {
            // geocoder.geocode( { 'address': location.address }, function(results, status) {
            //     if (status == google.maps.GeocoderStatus.OK) {
            //
            //         var marker = new google.maps.Marker({
            //             map: map,
            //             position: results[0].geometry.location,
            //             title: location.name
            //         });
            //
            //         google.maps.event.addListener(marker, 'click', function() {
            //             infowindow.setContent(content);
            //             infowindow.open(map,marker);
            //         });
            //     }
            // });
        } else {
            var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lng));
            var marker = new google.maps.Marker({
                map: map,
                position: position,
                title: location.name,
                animation: google.maps.Animation.BOUNCE
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(content);
                infowindow.open(map,marker);
            });
        }
    }
    function addOption(selectBox, text, value) {
        var option = document.createElement("OPTION");
        option.text = text;
        option.value = value;
        selectBox.options.add(option);
    }
    function calculateRoute() {
        document.getElementById("sidebar").style.display = "block";
        var start = document.getElementById('start').value;
        var destination = document.getElementById('destination').value;

        if (start == '') {
            start = center;
        }

        var request = {
            origin: start,
            destination: destination,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }
        //]]>
        </script>
    </head>
    <body onload="init();">
    <div style="position: absolute; z-index:2; margin-left:25%; background-color:rgba(255,255,255,0.1);">
      <form id="services">
          <input type="text" id="start" style="display:none;"/>
          Outbreaks: <select id="destination" onchange="calculateRoute();"></select>
          <input type="button" value="Display Directions" onclick="calculateRoute();" />
      </form>




      <!-- <input type="text" id="fbval" value=""/>
      <button onclick="writeFb(this.value)">PUSH</button> -->
    </div>
    <div id="sidebar" style="position:absolute; z-index:3; right:0;height: 100%; overflow:scroll; background-color:rgba(0,0,0,0.1); display:none;">
        <span onclick="closeFuc()" id="close">X</span>
        <div id="directions_panel"></div>
    </div>
    <div id="map_canvas" class="col-10" style="height: 100vmin; overflow-y: hidden; z-index:1;"></div>

    </body>
<script type="text/javascript">
  function closeFuc() {
    document.getElementById("sidebar").style.display = "none";
  }

</script>
