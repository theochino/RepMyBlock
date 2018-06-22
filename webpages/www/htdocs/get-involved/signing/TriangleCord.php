<?php

	if ( ! isset ($ZoomID) ) {
		$ZoomID = 16;
	}

	function PrintGeoCordinates($ID) {
		print "];\n";
		
		print "\tvar GeoCoordinates_" . $ID . " = new google.maps.Polygon({\n";
    print "\t\tpaths: PolyCoordinates_". $ID . ",\n";
    print "\t\tstrokeColor: '#FF0000',\n";
	  print "\t\tstrokeOpacity: 0.8,\n";
 	  print "\t\tstrokeWeight: 2,\n";
 	  print "\t\tfillColor: '#FF0000',\n";
 		print "\t\tfillOpacity: 0.35\n";
 		print "\t});\n";
		print "\tGeoCoordinates_" . $ID . ".setMap(map);\n";
	  print "\tGeoCoordinates_" . $ID . ".addListener('click', showArrays);\n";
	}
	
	// This is to load the menus groupping
	date_default_timezone_set('America/New_York'); 

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_geocoding.php";
	$r = new geocoding();
	
	$result = $r->ExtractGeoCenter($GeoCodeID);
	
	print "\tvar CenterMapTo = new google.maps.LatLng(" . $result["latitude"] . "," . $result["longitude"] . ");\n";
			  
	print "\tvar mapCanvas = document.getElementById(\"map\");\n";
	print "\tvar mapOptions = {center: CenterMapTo, zoom: " . $ZoomID . "};\n";
	print "\tmap = new google.maps.Map(mapCanvas,mapOptions);\n";

	
	$result = $r->ExtractGeo($GeoCodeID);
	$first_time  = 0;
	$print_end_toggle = 0;
	
	$prev_major = 0;
	$prev_minor = 1;

	if (! empty ($result)) {
		foreach ($result as $var) {
			if (! empty ($var)) {
				if ($prev_major != $var["GeoDescCordsMajOrd"]) {	
					if ($print_end_toggle == 1) {	
						PrintGeoCordinates($prev_major);
						$print_end_toggle = 0;
					}
					print "\tvar PolyCoordinates_" . $var["GeoDescCordsMajOrd"] . " = [";
					$print_end_toggle = 1;
				}
				$prev_major = $var["GeoDescCordsMajOrd"];
				print "{lat:" . rtrim($var["GeoCord_Lat"], '0') . ",lng:" . rtrim($var["GeoCord_Long"], '0') . "},";
				// print "// PREV_MAJOR: $prev_major - " . $var["GeoDescCordsMajOrd"] . " - Minor: " . $var["GeoDescCordsMinOrd"] . "\n";							
			}
		}
	}
	
	PrintGeoCordinates($prev_major);
?>


