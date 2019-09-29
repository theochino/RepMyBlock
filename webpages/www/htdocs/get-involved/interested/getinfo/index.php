<?php 
	$BigMenu = "represent";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";

	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	// $DatedFilesID from var.
	
	if ( empty ($DatedFiles)) {
		print "<FONT COLOR=\"RED\">We have an issue with the NYS Voter File and we can't continue.</FONT>";
		exit(1);
	}
	
	
	if (! empty ($UniqNYSID)) {
		$p = new OutragedDems();
		$ResultVoter = $p->SearchVoterDBbyNYSID($UniqNYSID, $DatedFiles);
		$ResultVoter = $ResultVoter[0];
		
		// I also need to find the Regular Raw Voter 
		$ResultVoterMyTable = $p->SearchLocalRawDBbyNYSID($UniqNYSID, $DatedFilesID);
		$ResultVoterMyTable = $ResultVoterMyTable[0];
	}
	
	$ElectionDistrict = $ResultVoter["Raw_Voter_ElectDistr"];
	$AssemblyDistrict = $ResultVoter["Raw_Voter_AssemblyDistr"];
	
	$r = new maps();
	$result = $r->CountRawVoterbyADED($DatedFiles, $AssemblyDistrict, $ElectionDistrict, $ResultVoter["Raw_Voter_EnrollPolParty"]);
	$RawVoterID = $ResultVoter["Raw_Voter_ID"];
	
	$GeoDescAbbrev = sprintf("%'.02d%'.03d", $AssemblyDistrict, $ElectionDistrict);
	$PicID = $r->FindGeoDiscID($GeoDescAbbrev);

	$NumberOfElectors = $result["TotalVoters"];
	$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
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

	$URLAction = "k=" . EncryptURL("UniqNYSID=" . $UniqNYSID . 
								"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
								"&FirstName=" . ucwords(strtolower($ResultVoter["Raw_Voter_FirstName"])) . 
								"&LastName=" . ucwords(strtolower($ResultVoter["Raw_Voter_LastName"])));
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";							
	$PartyEnrolled = NewYork_PrintParty($ResultVoter["Raw_Voter_EnrollPolParty"]);
	
?>

<div class="main">

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
		<h2><?= $ResultVoter["DataCounty_Name"] ?> County</H2>

		
		<div class="row" style="display:inline-block;">
			  <div class="column" style="background-color:#fff;text-align: center;">
			   
					<P>
						<B><?= $ResultVoter["Raw_Voter_FirstName"] ?>
							 <?= $ResultVoter["Raw_Voter_MiddleName"] ?>
							 <?= $ResultVoter["Raw_Voter_LastName"] ?>
							 <?= $ResultVoter["Raw_Voter_Suffix"] ?></B>
					<BR>
						<?= $ResultVoter["Raw_Voter_ResHouseNumber"] ?>
						<?= $ResultVoter["Raw_Voter_ResFracAddress"] ?>
						<?= $ResultVoter["Raw_Voter_ResPreStreet"] ?>
						<?= $ResultVoter["Raw_Voter_ResStreetName"] ?>
						<?= $ResultVoter["Raw_Voter_ResPostStDir"] ?>
						<?= $ResultVoter["Raw_Voter_ResApartment"] ?><BR>
						<?= $ResultVoter["Raw_Voter_ResCity"] ?>, NY
						<?= $ResultVoter["Raw_Voter_ResZip"] ?>
					</P>
											
					<p><a target="_blank" class="district" href="/get-involved/interested/showdistrict.php?GeoCodeID=<?= $PictureID ?>">
				  	<img id="myimage" src="<?= $PicURL ?>" alt="District">
					</a>
					</p>
			  </div>
			  
			  <?php if (
									  $ResultVoter["Raw_Voter_CountyCode"] == 31 || $ResultVoter["Raw_Voter_CountyCode"] == 43 ||   // New York County and Richmond County
									  $ResultVoter["Raw_Voter_CountyCode"] == 3 || $ResultVoter["Raw_Voter_CountyCode"] == 24 || $ResultVoter["Raw_Voter_CountyCode"] == 41 // Bronx, Brooklyn, and Queens 
							) { ?>
							  	
							  	 
			  <div class="column" style="background-color:#aaa;">
			  	
			  	 <h2><?= $PartyEnrolled ?> Electors in: 
			    <?= $NumberOfElectors ?></h2>
			    <h2>Required Signatures:
			    <?= $NumberOfSignatures ?></H2>
			    <?php /* <h2>Number of Buildings: <?= $NumberOfAddressesOnDistrict ?></h2> */ ?>
			    
			  </div>
			  
		    <div class="column" style="background-color:#fff;">
			    	
			  	<P><a href="/get-involved/interested/getinfo/commited/?<?= $URLAction ?>" class="btn success">I want to run</a></P><BR>
			  	<P><a href="/get-involved/interested/getinfo/thinkaboutit/?<?= $URLAction ?>" class="btn info">I'll think about it</a></P><BR>
			  	<P><a href="/get-involved/interested/getinfo/moved/?<?= $URLAction ?>" class="btn warning">This is not my address</a></P>
			  	
			  </div>
							  	
				<?php } else { ?>
				
				<div class="column" style="background-color:#aaa;">
			  	 <h2>According to the voter file, you live in <?= $ResultVoter["DataCounty_Name"] ?> county.
			  	 	This tool is not yet ready for democrats outside New York City.</h2>  
			  </div>
				
				
				
			<?php  } ?>
			  							  
			
		</div>
		
		
		
		<P CLASS="right-disclaimer">
			<B>*</B><I>The required signatures number is the minimum necessary to be safe on the ballot, but the rules are such that if you 
				return a petition with one signature, there is a chance it can be accepted. If you submit <?= $NumberOfSignatures + 1 ?> adequately 
				signed names from the list, nobody will contest your right to be on the ballot. Anything under that, you could be challenged, 
				but at least return a petition with one signature. <B>You will never know.</B></I>
		</P>
		
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>