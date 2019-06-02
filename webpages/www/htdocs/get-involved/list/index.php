<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";  
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName;
	
	if ( ! empty ($_POST["SaveInfo"])) {
		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		$result = $r->CheckEmail($_POST["emailaddress"]);
		
		if ( empty ($result)) {
			// We did not find anything so we are creating it.
			$result = $r->AddEmail($_POST["emailaddress"], $_POST["login"], $FirstName, $LastName);
		} else if (! empty ($result["SystemUser_password"])) {			
				// That mean we did the stuff before so we need to jump to another screen
			
		}
		
		$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName;

		// The reason for no else is that the code supposed to go away.
		
		if ( $_POST["login"] == "password") {
			header("Location: requestpassword.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
		
		if ( $_POST["login"] == "email") {
			header("Location: requestemaillink.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
	
		// If we are here which we should never be we need to send user to problem loop
		exit();
	}

	$result = $r->FindSystemUser_ID($SystemUser_ID);		
	//echo "<PRE>" .print_r($result, 1) . "</PRE>";
	
	if ( empty ( $result[0]["Candidate_ID"])) {
		header("Location: /get-involved/list/explain/?k=" . EncryptURL("SystemUser_ID=" . $SystemUser_ID . 
																																		"&ElectionDistrict=" . $ElectionDistrict . 
																																		"&AssemblyDistrict=" . $AssemblyDistrict .
																																		"&FirstName=" . $FirstName . "&LastName=" . $LastName));
		exit();
	}
	
	if ( ! empty ($Candidate_ID)) {
		$result = $r->ReturnPetitionSet($Candidate_ID);
	}

	
	$NewK = "SystemUser_ID=" . $SystemUser_ID;
	
	// . "&RawVoterID=" . $RawVoterID . 
//					"&DatedFiles=" . $DatedFiles . "&ElectionDistrict=" . $ElectionDistrict . 
//					"&AssemblyDistrict=" . $AssemblyDistrict . "&FirstName=" . $FirstName . 
//					"&LastName=" . $LastName;	
		
				
	//echo "<PRE>" . print_r($result, 1) . "</PRE>";
	require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	$UniqNYSID = $result[0]["Raw_Voter_UniqNYSVoterID"];
	if (! empty ($UniqNYSID)) {
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";  
		$q = new OutragedDems();
		$ResultVoter = $q->SearchVoterDBbyNYSID($UniqNYSID, $DatedFiles);
		$ResultVoter = $ResultVoter[0];
		
		// I also need to find the Regular Raw Voter 
		$ResultVoterMyTable = $q->SearchLocalRawDBbyNYSID($UniqNYSID, $DatedFilesID);
		$ResultVoterMyTable = $ResultVoterMyTable[0];
	}
	
	$ElectionDistrict = $ResultVoter["Raw_Voter_ElectDistr"];
	$AssemblyDistrict = $ResultVoter["Raw_Voter_AssemblyDistr"];
				
	$r = new maps();
	$result = $r->CountRawVoterbyADED($DatedFiles, $AssemblyDistrict, $ElectionDistrict);
	$RawVoterID = $ResultVoter["Raw_Voter_ID"];
	
	$GeoDescAbbrev = sprintf("%'.02d%'.03d", $AssemblyDistrict, $ElectionDistrict);
	$PicID = $r->FindGeoDiscID($GeoDescAbbrev);

	$NumberOfElectors = $result["TotalVoters"];
	$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
	$NumberOfAddressesOnDistrict = 0;
	$PictureID = $PicID["GeoDesc_ID"];
	$PictureDir = intval( $PictureID /100);
	$PicURL = $FrontEndStatic . "/maps/" . $PictureDir . "/Img-" . $PictureID . ".jpg";	
	
				
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>

<div class="row">
  <div class="main">

		
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
		<h1><?= $result[0]["Candidate_DispName"] ?></h1>
<?php
		if ( ! empty ($successmsg)) {
			echo "<P><B><FONT SIZE=+1 COLOR=GREEN>" . $successmsg . "</FONT></B></P>";
		}
?>


<?php
		$NewKEncrypt = EncryptURL($NewK . "&Candidate_ID=" . $result[0]["Candidate_ID"]);
?>	

		<P>
			<FONT SIZE=+2>
				Download a 
				<A TARGET="BLANKPETITION" HREF="<?= $FrontEndPDF ?>/multipetitions/?k=<?= $NewKEncrypt ?>">blank petition</A>
				<A TARGET="BLANKPETITION" HREF="<?= $FrontEndPDF ?>/multipetitions/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download" aria-hidden="true"></i></A> and
				<A TARGET="BLANKPETITION" HREF="<?= $FrontEndPDF ?>/voterlist/?k=<?= $NewKEncrypt ?>">list of voters</A>
				<A TARGET="BLANKPETITION" HREF="<?= $FrontEndPDF ?>/voterlist/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download" aria-hidden="true"></i></A>
			</FONT>
				 
		</P>
		
		
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
			  
			 
							  	 
			  <div class="column" style="background-color:#aaa;">
			  	
			  	 <h2>Democrat Electors in: 
			    <?= $NumberOfElectors ?></h2>
			    <h2>Required Signatures:
			    <?= $NumberOfSignatures ?></H2>
			    <?php /* <h2>Number of Buildings: <?= $NumberOfAddressesOnDistrict ?></h2> */ ?>
			    
			  </div>
			</DIV>
			
			<P>
				Once you collect the  <?= $NumberOfSignatures ?> plus a few more, you need to wait until April 1<sup>st</sup> to take them
				to the board of elections. <B>Just follow the 
			<A HREF="<?= $FrontEndWeb ?>/where-to-file/prepare-to-file-your-petition-to-the-board-of-elections.html">instruction posted on the FAQ</A>.</B>
			</P>
			
		
		
<?php /*
		<h2>List of voters in your area.</H2>	
		
	
		<P>
			<FONT SIZE=+2><A HREF="/get-involved/target/?k=<?= $k ?>">Create a petition set with the voters you want to target</A></FONT><BR>		
		</P>
		
		<h2>This is a list of petition set created</h2>
		
		<P>
		
		<?php 
			if ( ! empty ($result) ) {
				foreach ($result as $var) {
					if ( ! empty ($var)) {
						$NewKEncrypt = EncryptURL($NewK . "&CandidatePetitionSet_ID=" . $var["CandidatePetitionSet_ID"] . 
																											   "&Candidate_ID=" . $var["Candidate_ID"] );
		?>				
						<A HREF="/get-involved/list/printpetitionset/?k=<?= $NewKEncrypt ?>">Petition set created 
							on <?= PrintShortDate($var["CandidatePetitionSet_TimeStamp"]) ?> at 
							<?= PrintShortTime($var["CandidatePetitionSet_TimeStamp"]) ?></A>
						<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/petitions/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download"></i></A> 
						<A HREF="/get-involved/list/emailpetition/?k=<?= $NewKEncrypt  ?>"><i class="fa fa-share"></i></A>																													
						<BR>
		<?php
					}
				}
			}
		?>

		</P>				
		
		<P>
			<FONT SIZE=+2><A HREF="managesignedvoters.php?k=<?= $k ?>">Manage your signed voters</A></FONT>
		</P>
		
		
		<P>
			<FONT SIZE=+2><A HREF="">Candidates running in your district.</A></FONT>
		</P>
		
		<UL>
			* None.
		</UL>

		*/ ?>

	</div>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>