<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($k)) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

		$DateOfBirth = preg_replace('/-/', '', $DOB);
		$DateOfBirth = $DOB;
	
		$r = new OutragedDems();
		#echo "$DatedFiles, $FirstName, $LastName, $DateOfBirth\n";

		$result = $r->SearchVoterDB($FirstName, $LastName, $DateOfBirth, $DatedFilesID);		
		$CountResult = count($result);
		if ( $CountResult > 1 ) {
			$NYSIDVoter = "Found " . $CountResult;
		}
		
		$r->SaveVoterRequest($FirstName, $LastName, $DateOfBirth, $DatedFilesID, $Email, 
													$result[0]["VotersIndexes_UniqNYSVoterID"], $_SERVER["REMOTE_ADDR"]);

		if ( $CountResult == 0) {
			$URL = "iaminterestedtorunnotfound.php?ED=" . $_GET["ED"] . "&AD=" . $_GET["AD"] . "&Email=" . $_GET["Email"] .
									 "&FN=" . $_GET["FN"] . "&LN=" . $_GET["LN"] . "&DOB=" . $_GET["DOB"];
			header("Location: $URL");
			exit();
		}
			
		if ( $CountResult > 1) {
			$MyRawVoterInList = $result[0][Raw_Voter_ID];
			
			if ( ! empty ($result)) {
				foreach ($result as $var) {
					if ( ! empty ($var)) {
						if ($MyRawVoterInList == $var["Raw_Voter_ID"]) {
							$IamOkForOne = 1;
						} else {
							$IamOkForOne++;
						}
					}
				}
			}
			
			if ( $IamOkForOne == 1) {
				$URL = "/get-involved/nominate/getedinfo/?k=" . encryptURL("UniqNYSID=" . $var["Raw_Voter_UniqNYSVoterID"]);
				header("Location: $URL");
				exit();
			}
			
			$URL = "iaminterestedtorunmorethanone.php?ED=" . $_GET["ED"] . "&AD=" . $_GET["AD"] . "&Email=" . $_GET["Email"] .
									 "&FN=" . $_GET["FN"] . "&LN=" . $_GET["LN"] . "&DOB=" . $_GET["DOB"];
			header("Location: $URL");
			exit();
		}
		
		if ( $result[0]["Raw_Voter_RegParty"] != "DEM") {
			$URL = "iaminterestedtorunbutnotdem.php?k=" . encryptURL("VotersIndexes_UniqNYSVoterID=" . $result[0]["VotersIndexes_UniqNYSVoterID"]);
			header("Location: $URL");
			exit();
		}
						
		$URL = "/get-involved/nominate/getedinfo/?k=" . encryptURL("UniqNYSID=" . $result[0]["VotersIndexes_UniqNYSVoterID"]);
		header("Location: $URL");
		exit();
	}
		
?>