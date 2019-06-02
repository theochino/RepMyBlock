&nbsp;<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php"; 	
?>	

<script>	
var map;
var infoWindow;	

function myMap() {
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Data/CityADEDPoly.txt"; ?>     	       
	infoWindow = new google.maps.InfoWindow;
}

function polygonClickHandler(polygon, contentString) {
  var boxText = document.createElement("div");
  boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: #89A2F5; padding: 5px 10px; border-radius: 5px; font-size: 18px !important; color: #000000;";
  boxText.innerHTML = contentString;
  
  var myOptions = {
    content: boxText,
    disableAutoPan: false,
    maxWidth: 1000,
    pixelOffset: new google.maps.Size(-10, 10),
    zIndex: null,
    boxStyle: {opacity: 1.0,width: "2000px"},
    closeBoxMargin: "2px 2px 2px 2px",
    closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
    infoBoxClearance: new google.maps.Size(1, 1),
    isHidden: false,
    pane: "floatPane",
    enableEventPropagation: false
  };
  
  polygon.addListener('click', function(evt) {
    infoWindow.setOptions(myOptions);
    infoWindow.setPosition(evt.latLng);
    infoWindow.open(map);
  });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $GoogleMapKeyID ?>&callback=myMap"></script>

<div class="main">
	<P>
		Click on a particular district to check the requirements.
	</P>

	<P><div style="width:100%;height:70%" id="NYCmap"></div></P>

</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>