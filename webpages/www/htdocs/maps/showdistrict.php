<?php 
	$GoogleMapKeyID = "AIzaSyDDYjTlFL3rPZMZN6TGFqWBGrp2aRxoO5c"; 
	$GeoCodeID = $_GET["GeoCodeID"];	
	
	if ( ! empty ($_GET["ZoomID"])) {
		$ZoomID = $_GET["ZoomID"];
	}
	
	
?>


<HTML>
	<BODY>
			<P>

			<div id="map" style="width:100%;height:800px"></div>

			<script>
				
var map;
var infoWindow;	

function myMap() {


<?php $GeoCodeID = $GeoCodeID; ?>
<?php include "TriangleCord.php"; ?>     	       
	infoWindow = new google.maps.InfoWindow;
}

function showArrays(event) {
	// Since this polygon has only one path, we can call getPath() to return the
	// MVCArray of LatLngs.
	var vertices = this.getPath();
	var contentString = '<b>We need to define the info</b><br>' + 'Clicked location: <br>' + 
						event.latLng.lat() + ',' + event.latLng.lng() +  '<br>';

	// Iterate over the vertices.
	//for (var i =0; i < vertices.getLength(); i++) {
	//	var xy = vertices.getAt(i);
  //		contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' + xy.lng();
  //	}

	// Replace the info window's content and position.
	infoWindow.setContent(contentString);
	infoWindow.setPosition(event.latLng);

	infoWindow.open(map);
}
			</script>

			<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $GoogleMapKeyID ?>&callback=myMap"></script>
			<!--
			To use this code on your website, get a free API key from Google.
			Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
			-->
	</P>

	</BODY>
</html>