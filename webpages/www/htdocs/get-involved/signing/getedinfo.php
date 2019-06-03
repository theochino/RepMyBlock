<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";

	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	$ElectionDistrict = $ED;
	$AssemblyDistrict = $AD;
	
	if ( empty ($DatedFiles)) {
		$DatedFiles = "20170515";
	}
	
	if (! empty ($RawVoterID) ) {
		$p = new OutragedDems();
		$ResultCandidates = $p->SearchCandidateInArea($DatedFiles, $RawVoterID);		
		$resultVoter = $ResultCandidates[0];
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
	$PicURL = $FrontEndStatic . "/maps/" . $PictureDir . "/Img-" . $PictureID . ".jpg";	
	
	if ($RawVoterID > 0) {
		$PDFURL = $FrontEndPDF . "/petitions/?k=" . EncryptURL("ED=" . $ElectionDistrict . "&AD=" . $AssemblyDistrict . 
							"&RAW=" . $RawVoterID . "&DatedFiles=" . $DatedFiles);
	} else {
		$PDFURL = "/get-involved/iaminterestedtorun.php?k=" . EncryptURL("ED=" . $ElectionDistrict . "&AD=" . $AssemblyDistrict);
	}
	
	$URLAction = "k=" . EncryptURL("RawVoterID=" . $RawVoterID . "&DatedFiles=" . $DatedFiles . 
								"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
								"&FirstName=" . ucwords(strtolower($resultVoter["Raw_Voter_FirstName"])) . 
								"&LastName=" . ucwords(strtolower($resultVoter["Raw_Voter_LastName"])));
								
	
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
			

			
				<div class="row">
			  <div class="column" style="background-color:#fff;">
			   
					<P>
						<B><?= $resultVoter["Raw_Voter_FirstName"] ?>
						<?= $resultVoter["Raw_Voter_MiddleName"] ?>
						<?= $resultVoter["Raw_Voter_LastName"] ?>
					<?= $resultVoter["Raw_Voter_Suffix"] ?></B>
					<BR>
						<?= $resultVoter["Raw_Voter_ResHouseNumber"] ?>
						<?= $resultVoter["Raw_Voter_ResFracAddress"] ?>
						<?= $resultVoter["Raw_Voter_ResPreStreet"] ?>
						<?= $resultVoter["Raw_Voter_ResStreetName"] ?>
						<?= $resultVoter["Raw_Voter_ResPostStDir"] ?>
						<?= $resultVoter["Raw_Voter_ResApartment"] ?><BR>
						<?= $resultVoter["Raw_Voter_ResCity"] ?>, NY
						<?= $resultVoter["Raw_Voter_ResZip"] ?>
					</P>
											
					<p><a target="_blank" class="district" href="showdistrict.php?GeoCodeID=<?= $PictureID ?>">
				  	<img id="myimage" src="<?= $PicURL ?>" alt="District">
					</a>
					</p>
			  </div>
			  
			  <div class="column" style="background-color:#fff;">
			  	<P><a href="moved.php?<?= $URLAction ?>" class="btn warning">This is not my address</a></P>	
			  </div>
			</div>
			
			
			<h2>This is the list of candidate running in your area that need a petition signed</H2>

			<FORM ACTION="" METHOD="POST">			
			<TABLE WIDTH=100% BORDER=1>
				
				<?php 
					if ( ! empty ($ResultCandidates)) { 
						foreach($ResultCandidates as $var) {
							if ( ! empty ($var)) {
								?>
						<TR>
							<TD><INPUT TYPE="CHECKBOX" VALUE="<?= $var["CandidatePetition_ID"] ?>"></TD>
		        	<TD><?= $var["Candidate_ID"] ?></TD>
            	<TD><?= $var["Candidate_DispName"] ?></TD>
            	<TD><?= $var["Candidate_DispPosition"] ?></TD>
            </TR>
				<?php
				     }
				    }
				  }
				  ?>
			</TABLE>
			
			<INPUT TYPE="SUBMIT" VALUE="Get a Petition Ready">
			</FORM>
			
			
		</UL>
	</BODY>
</HTML>
		
