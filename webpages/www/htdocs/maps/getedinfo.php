<?php 
	date_default_timezone_set('America/New_York'); 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	
	$GoogleMapKeyID = "AIzaSyDDYjTlFL3rPZMZN6TGFqWBGrp2aRxoO5c"; 
	$ElectionDistrict = $_GET["ED"];
	$AssemblyDistrict = $_GET["AD"];
	
	if (! empty ($_GET["RawVoterID"]) ) {
		$RawVoterID = $_GET["RawVoterID"];
	}
	
	if ( ! empty ($_GET["DatedFiles"])) {
		$DatedFiles=$_GET["DatedFiles"];
	} else {
		$DatedFiles = "20170515";
	}
	
	$r = new maps();
	$result = $r->CountRawVoterbyADED($DatedFiles, $ElectionDistrict, $AssemblyDistrict);
	
	$GeoDescAbbrev = sprintf("%'.02d%'.03d", $AssemblyDistrict, $ElectionDistrict);
	$PicID = $r->FindGeoDiscID($GeoDescAbbrev);

	$NumberOfElectors = $result["TotalVoters"];
	$NumberOfSignatures = intval($NumberOfElectors * .05) + 1;
	$NumberOfAddressesOnDistrict = 0;
	$PictureID = $PicID["GeoDesc_ID"];
	$PictureDir = intval( $PictureID /100);
	$PicURL = "https://dev-frontend-static.outrageddems.nyc/maps/" . $PictureDir . "/Img-" . $PictureID . ".jpg";	
	
	if ($RawVoterID > 0) {
		$PDFURL = "https://dev-frontend-pdf.outrageddems.nyc/petitions/?ED=" . $ElectionDistrict . "&AD=" . $AssemblyDistrict . 
							"&RAW=" . $RawVoterID . "&DatedFiles=" . $DatedFiles;
	} else {
		$PDFURL = "/maps/iaminterestedtorun.php?ED=" . $ElectionDistrict . "&AD=" . $AssemblyDistrict;
	}
?>
<HTML>
	<BODY>
		<IMG SRC="https://www.outrageddems.nyc/word/wp-content/uploads/2018/01/cropped-OD-Logo_3.png">
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
		<UL>
			<A HREF="showdistrict.php?GeoCodeID=<?= $PictureID ?>"><IMG SRC="<?= $PicURL ?>" WIDTH=300></A>
			<BR><BR>
			
			Number of Democrat Electors: <?= $NumberOfElectors ?><BR>
			Number of Required Signatures: <?= $NumberOfSignatures ?><BR>
		
			Number of Addresses in that District: <?= $NumberOfAddressesOnDistrict ?><BR>
			Current Elected District: 
			<BR><BR>
		
			<A HREF="<?= $PDFURL ?>">Download a petition</A>
		</UL>
	</BODY>
</HTML>
		