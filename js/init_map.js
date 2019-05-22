var current_coord ={};
        var map;

        var center = new google.maps.LatLng(9.9304261, 8.9160833);

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
				document.querySelector("a#view_more").href="./home.php?lat="+position.coords.latitude+"&lng="+position.coords.longitude;
				current_coord.lat = position.coords.latitude;
				current_coord.lng = position.coords.longitude;
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
            var position = new google.maps.LatLng(9.9304261, 8.9160833);
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
