<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$BigMenu = "represent";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	
	if ( $SystemUser_ID > 0 ) {
	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
		
		$r = new voterlist();
	
		if ( ! empty ($_POST)) {
			
			// Before we start we need to create a candidate ID.
			$result = $r->FindSystemUser_ID($SystemUser_ID);
			$result = $result[0];
			
			if ( empty ($result["Candidate_ID"])) {
				echo "RESULT: <PRE>" . print_r($result, 1) . "</PRE>";	
				
				if ( $result["SystemUser_EDAD"] > 0 ) {
					$result_Election = $r->FindElectionIDforEDAD($result["SystemUser_EDAD"]);
					
				} else {
					// Send to problem page.
					echo "We ran into a problem with this election. It doesn't exist. We'll contact you shorly.<BR>";
					echo "<BR>";
					exit(1);
				}
				
				echo "result_Election: <PRE>" . print_r($result_Election, 1) . "</PRE>";	
				$Candidate_ID = $r->ReturnCandidateIDForCCElection($result_Election["CandidateElection_ID"], $result["SystemUser_EDAD"], 
																														$SystemUser_ID,  $result["Raw_Voter_UniqNYSVoterID"],	$DatedFilesID, $DatedFiles);
																														
				echo "RESULT: <PRE>" . print_r($Candidate_ID, 1) . "</PRE>";	
				echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
				if ( $_POST["CommToReplace"] == "default" ) {
					echo "I selected the default committee<BR>";
					// Need to add that user in the candidates list.
					
					$r->AddCandidateWitnessID($Candidate_ID["Candidate_ID"], 1);
					$r->AddCandidateWitnessID($Candidate_ID["Candidate_ID"], 2);
					$r->AddCandidateWitnessID($Candidate_ID["Candidate_ID"], 3);
					
					// Last Piece is to prep all the Voters.
					$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID . "&Candidate_ID=" . $Candidate_ID["Candidate_ID"];
					header("Location: /get-involved/list/prepvoters/copyvoters.php?k=" . EncryptURL($URLToEncrypt));
					exit();
					
				}
				
				
			}
			
			exit();
		}
			
	
	
	
		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		
		//$result = $r->CheckRawVoterID($SystemUser_ID);	
		//$resultRaw = $r->FindLocalRawVoterFromDatedFile($result["Raw_Voter_ID"], $DatedFiles);
	
		//if ( empty ($result)) {
			// We did not find anything so we are creating it.
		//	$r->AddVoterRawVoterID($SystemUser_ID, $RawVoterID);			
		//}

		// find county code
		/*
		$FindVoterID = $r->FindRawVoterbyRawVoterID($DatedFiles, $resultRaw["Raw_Voter_TableDate_ID"]);			
		$County = $r->GetCountyFromNYSCodes($FindVoterID["Raw_Voter_CountyCode"]);
		
		$EDAD = str_pad($FindVoterID["Raw_Voter_AssemblyDistr"], 2, '0', STR_PAD_LEFT) . 
						str_pad($FindVoterID["Raw_Voter_ElectDistr"], 3, '0', STR_PAD_LEFT);
		$ResultElection = $r->FindElectionIDforEDAD($EDAD);			
		$result = $r->PrepDisctictVoterRoll($SystemUser_ID, $resultRaw["Raw_Voter_TableDate_ID"], $DatedFiles, 
																				$ResultElection["CandidateElection_ID"]);	

		$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID;
		//header("Location: /get-involved/list/displayvoters/?k=" . EncryptURL($URLToEncrypt));
		//exit();
		*/
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
	
?>

<div class="row">
   <div class="main">

		<FORM ACTION="" METHOD="POST">
		<h2>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H2>
			
		<UL>
			
			Before we can prepare the petitions you need to select a Committee to replace.<BR>
			<B>The computer does it for you so just click on the "Next Screen" button.</B>
			<?php /*
			You need to select a minimum 
			of three democrats that will meet. You can chose the default one which are the Outraged Dems fouders.
			*/ ?>
		</UL>
		
		<UL>
			<INPUT TYPE="HIDDEN" NAME="CommToReplace" VALUE="default" CHECKED> <?php /*Default committee<BR>
			
			<INPUT TYPE="RADIO" NAME="CommToReplace" VALUE="select"> Select my own committee<BR>
			<UL><FONT SIZE=-1><I>(The reason someone would select his own committee is in the event they belong to a club and they need to sync up the names.)</I></FONT></UL>
			*/ ?>
		</UL>
		
		<UL>
			<INPUT TYPE="SUBMIT" VALUE="Next Screen">
		</UL>
		
		</FORM>
	
		<A HREF="/get-involved/list/?k=<?= EncryptURL("SystemUser_ID=" . $SystemUser_ID) ?>">Return to previous screen</A>
	</div>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>