<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$BigMenu = "represent";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( $SystemUser_ID > 0 ) {
	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
		
		echo "Does it dies here?<BR>";
		echo "<A HREF=\"/get-involved/\">Back to the next test</A><BR>";
		
		$r = new voterlist();
	
		// Before we start we need to create a candidate ID.
		$result = $r->FindSystemUserDetails_ID($SystemUser_ID, $DatedFiles);
		$r->PrepDisctictCCVoters($result["Candidate_ID"], $SystemUser_ID, $DatedFiles, $result["Raw_Voter_ElectDistr"],	$result["Raw_Voter_AssemblyDistr"]);
		
		$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID;
		header("Location: /get-involved/list/?k=" . EncryptURL($URLToEncrypt));
			
		exit();
	}		
?>