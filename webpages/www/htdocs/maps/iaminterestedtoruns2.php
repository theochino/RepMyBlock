<?php 
	date_default_timezone_set('America/New_York'); 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	
	$GoogleMapKeyID = "AIzaSyDDYjTlFL3rPZMZN6TGFqWBGrp2aRxoO5c"; 
	
	$ElectionDistrict = $_GET["ED"];
	$AssemblyDistrict = $_GET["AD"];
	$UserEmail = $_GET["EMAIL"];
	$FirstName = $_GET["FN"];
	$LastName = $_GET["LN"];
	$DateOfBirth = $_GET["DOB"];	
	$DatedFiles = "20170515";

	$r = new OutragedDems();
	$result = $r->SearchVoterDB($DatedFiles, $FirstName, $LastName, $DateOfBirth);

	if ( count ($result) == 0) {
		$URL = "iaminterestedtorunnotfound.php?ED=" . $_GET["ED"] . "&AD=" . $_GET["AD"] . "&Email=" . $_GET["Email"] .
								 "&FN=" . $_GET["FN"] . "&LN=" . $_GET["LN"] . "&DOB=" . $_GET["DOB"];
		header("Location: $URL");
		exit();
	}
		
	if ( count ($result) > 1) {
		$URL = "iaminterestedtorunmorethanone.php?ED=" . $_GET["ED"] . "&AD=" . $_GET["AD"] . "&Email=" . $_GET["Email"] .
								 "&FN=" . $_GET["FN"] . "&LN=" . $_GET["LN"] . "&DOB=" . $_GET["DOB"];
		header("Location: $URL");
		exit();
	}
	
	if ( $result[0]["Raw_Voter_EnrollPolParty"] != "DEM") {
		$URL = "iaminterestedtorunbutnotdem.php?ED=" . $_GET["ED"] . "&AD=" . $_GET["AD"] . "&Email=" . $_GET["Email"] .
								 "&FN=" . $_GET["FN"] . "&LN=" . $_GET["LN"] . "&DOB=" . $_GET["DOB"];
		header("Location: $URL");
		exit();
	}
	
	$URL = "getedinfo.php?ED=" . $result[0]["Raw_Voter_ElectDistr"] . "&AD=" . $result[0]["Raw_Voter_AssemblyDistr"] .
															"&RawVoterID=" . $result[0]["Raw_Voter_ID"] . "&DatedFiles=" . $DatedFiles;
	header("Location: $URL");
	exit();
		
?>