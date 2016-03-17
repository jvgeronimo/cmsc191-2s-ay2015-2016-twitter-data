<!DOCTYPE html>
<html>
<?php
	$markerData = array();
    $con = new mysqli("localhost", "root", "", "googlemaps");
	
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }else{

        $sql = "SELECT lat, lng, type, name FROM markers";
        $result = $con->query($sql);
		
        if ($result->num_rows > 0) {
           
            while($row = $result->fetch_assoc()) {
                
                $markerData[] = array($row["lat"],$row["lng"],$row["type"], $row["name"]);
            }
        } else {
            echo "0 results";
        }
	}
    $con->close();
?>

    <head>
       <script src="http://maps.googleapis.com/maps/api/js?key=API_KEY"></script>
        <script>
			var mallPath = [];
			var smLatLng = [];
			var markersPath = [];
        	
            function initialize()
            {
                var center = new google.maps.LatLng(14.167525, 121.243368);//uplb

                var markers = <?php echo json_encode($markerData); ?>;
                var i,marker;
				
                var mapProp = {
                  center:center,
                  zoom:30,
                  mapTypeId:google.maps.MapTypeId.ROADMAP
                };
              
                var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
                
                
                 for (i = 0; i < markers.length; i++) {  
                     
					
					 
                    var myLatLng = new google.maps.LatLng(markers[i][0],markers[i][1]);
					var marker = new google.maps.Marker({
						  map: map,
						  center:center,
						  position: myLatLng,
						  title:markers[i][3],
						  icon:setColor(markers[i][2], myLatLng),
					});
					marker.setMap(map);
					markersPath.push(myLatLng);
					
                } 
				  
				var mallPaths = new google.maps.Polyline({
					path: mallPath,
					geodesic: true,
					strokeColor: '#FF0000',
					strokeOpacity: 1.0,
					strokeWeight: 2
				});
				
				var circlePath = new google.maps.Circle({
					center: {lat: 14.202888, lng: 121.155655}	,
					strokeColor: '#FF0000',
				    strokeOpacity: 0.8,
				    strokeWeight: 2,
				    fillColor: '#FF0000',
				    fillOpacity: 0.35,
				    map: map,
					radius: 250,
				});
				
				// Construct the polygon.
				  var markersPolygon = new google.maps.Polygon({
					paths: markersPath,
					strokeColor: '#007399',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#0086B3',
					fillOpacity: 0.35
				  });
				  
				
				
				
				markersPolygon.setMap(map);
				mallPaths.setMap(map);
				circlePath.setMap(map);
				  
            }
			
			function setColor(type, myLatLng)
			{
				switch(type){
					
					case "Amusement Park":
						return "http://www.googlemapsmarkers.com/v1/FFFFFF/";
						break;
					
					case "Auditorium":
						return "http://www.googlemapsmarkers.com/v1/B266FF/";
						break;
					
					case "Bank":
						return "http://www.googlemapsmarkers.com/v1/009999/";
						break;
					case "Inn":
						return "http://www.googlemapsmarkers.com/v1/FFFF99/";
						break;
					case "Mall":
						mallPath.push(myLatLng);
						return "http://www.googlemapsmarkers.com/v1/CC0066/";
						break;
					case "Municipal Hall":
						return "http://www.googlemapsmarkers.com/v1/FF99FF/";
						break;
					case "Resort":
						return "http://www.googlemapsmarkers.com/v1/3333FF/";
						break;
					case "Restaurant":
						return "http://www.googlemapsmarkers.com/v1/000000/";
						break;
					default:
						return "http://www.googlemapsmarkers.com/v1/003333/";
						break;
					
				}
			}
        google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>

    <body>
    <script>

    	
    </script>
    <div id="googleMap" style="width:1500px;height:1500px;">
    </div>
</body>
</html>
