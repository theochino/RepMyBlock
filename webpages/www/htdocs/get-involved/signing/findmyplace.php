<?php 
	$GoogleMapKeyID = "AIzaSyDDYjTlFL3rPZMZN6TGFqWBGrp2aRxoO5c"; 
	$GeoCodeID = $_GET["GeoCodeID"];	
?><HTML>
	<HEAD>
		<style>
	  	/* Always set the map height explicitly to define the size of the div
	  	 * element that contains the map. */
	    #floating-panel {
	      position: absolute;
	      top: 10px;
	      left: 25%;
	      z-index: 5;
	      background-color: #fff;
	      padding: 5px;
	      border: 1px solid #999;
	      text-align: center;
	      font-family: 'Roboto','sans-serif';
	      line-height: 30px;
	      padding-left: 10px;
	    }

	    #map {
	      height: 700;
	      width: 100%;
	    }
	    
	    /* Optional: Makes the sample page fill the window. */
	    html, body {
	      height: 100%;
	      margin: 0;
	      padding: 0;
	    }
	  </style>
	</head>
	
	<BODY>
	  <script src="https://maps.googleapis.com/maps/api/js?key=<?= $GoogleMapKeyID ?>"></script>

	  <script>
	    // In the following example, markers appear when the user clicks on the map.
	    // Each marker is labeled with a single alphabetical character.
	    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    var labelIndex = 0;
	    var togglemarker = 0;
	    var markers = [];
	    var LockMarker = 0;

	    function initialize() {
	      var CenterMap = { lat: 40.74, lng: -73.83 };
	      var map = new google.maps.Map(document.getElementById('map'), {
	        zoom: 11,
	        center: CenterMap
	      });

	      // This event listener calls addMarker() when the map is clicked.
	      google.maps.event.addListener(map, 'click', function(event) {
	      	document.getElementById("RESULT").innerHTML = map.getZoom();
	      	if ( map.getZoom() > 16) { addMarker(event.latLng, map); }
	     	});
	    }
	    
	    function LockMarkers() { 
	    	LockMarker = 1; 
	    }
	    
	     function GetInfo() { 
	    	LockMarker = 1; 
	    	document.getElementById("GoogleBlad").innerHTML = "This is the information from the thing. What are the LAT";
	    }
	    
      function UnlockMarkers() { setMapOnAll(map); }
      
      function DeleteMarkers() { setMapOnAll(map); }
      
	    // Adds a marker to the map.
	    function addMarker(location, map) {
	      // Add the marker at the clicked location, and add the next-available label
	      // from the array of alphabetical characters.
	      var marker = new google.maps.Marker({
	        position: location,
	        label: labels[labelIndex++ % labels.length],
	        map: map,
	        draggable: true
	      });
	      markers.push(marker);
	    }
	    
	    // Deletes all markers in the array by removing references to them.
	    function deleteMarkers() {
	      markers[0].setMap(map);
	      // markers = [];
	    }
      google.maps.event.addDomListener(window, 'load', initialize);
	  </script>
		
		<IMG SRC="https://www.outrageddems.nyc/word/wp-content/uploads/2018/01/cropped-OD-Logo_3.png">

  	<div id="floating-panel">
      <input onclick="LockMarkers();" type=button value="Lock Marker">
      <input onclick="UnlockMarkers();" type=button value="Unlock Marker">
      <input onclick="DeleteMarkers();" type=button value="Delete Markers">
      <input onclick="GetInfo();" type=button value="Get Info">
    </div>

		<P><div id="map"></div></P>
		<P><DIV ID="RESULT">This is where REsult goes.</DIV></P>
		<P><DIV ID="GoogleBlad">This is the Info</DIV></P>
  </body>
</HTML>