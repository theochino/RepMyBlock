<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( $SystemUser_ID > 0 ) {
	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
		
		$r = new voterlist();

		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		$result = $r->CheckRawVoterID($SystemUser_ID);
		
		if ( empty ($result)) {
			// We did not find anything so we are creating it.
			echo "I am here to create the Voter File.";
			$result = $r->AddVoterRawVoterID($SystemUser_ID, $RawVoterID);
			
		} else if (! empty ($result["Raw_Voter_ID"])) {			
			// That mean we did the stuff before so we need to jump to another screen
			$result = $r->PrepDisctictVoterRoll($SystemUser_ID, $result["Raw_Voter_ID"], $DatedFiles);		
		}
		
		
		$EncryptURL = EncryptURL("SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName .
										"&Candidate_ID=" . $result["Candidate_ID"]);

		

	}

?>
<HTML>
	<BODY>
		
		<link rel="stylesheet" type="text/css" href="../maps.css">

		<div class="header">
		  <a href="#default" class="logo"><IMG SRC="/pics/OutragedDemLogo.png"></a>
		  <div class="header-right">
		    <a class="active" href="#home">Home</a>
		    <a href="#contact">Contact</a>
		    <a href="#about">About</a>
		  </div>
		</div> 

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<UL>
		<H3><?= $FirstName ?></H3>

			We are now going to present the list of voters in your area. <BR>
			Prep has been done ... let's look at it.
		</UL>
		
		
		
		
		<A HREF="/maps/list/?k=<?= $EncryptURL ?>">Return to previous screen</A>
	</BODY>
</HTML>
