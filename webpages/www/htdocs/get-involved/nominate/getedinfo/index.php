<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
  $digits = array(
 		0 => 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven'
  );
  
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";

	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	// $DatedFilesID from var.
	
	
	if ( ! empty ($_POST)) {
		echo "This is funny.";
		echo "Take this to the nominating screen.";	
	
		echo "If you are not logged in ...";
	
		
		exit();
	}
	
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
	$result = $r->CountRawVoterbyADED($DatedFiles, $AssemblyDistrict, $ElectionDistrict);
	$RawVoterID = $ResultVoter["Raw_Voter_ID"];
	
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

	$URLAction = "k=" . EncryptURL("RawVoterID=" . $ResultVoterMyTable["Raw_Voter_ID"] . "&DatedFiles=" . $DatedFiles . 
								"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
								"&FirstName=" . ucwords(strtolower($ResultVoter["Raw_Voter_FirstName"])) . 
								"&LastName=" . ucwords(strtolower($ResultVoter["Raw_Voter_LastName"])));
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
	
	// Organize the elections							
	$ElectionResult = $p->ListElections($SomeVariable);
	if (! empty ($ElectionResult)) {
		foreach ($ElectionResult as $var) {
			if (! empty ($var)) {
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]]["pos_explain"] = $var["CandidateElection_URLExplain"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]]["pos_number"] = $var["CandidateElection_Number"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_web"] = $var["Candidate_StatementWebsite"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_pic"] = $var["Candidate_StatementPicFileName"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_email"] = $var["Candidate_StatementEmail"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_phone"] = $var["Candidate_StatementPhoneNumber"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_text"] = $var["Candidate_StatementText"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_id"] = $var["Candidate_ID"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_eid"] = $var["CandidateElection_ID"];
				$Election[$var["CandidateElection_PositionType"]][$var["CandidateElection_Text"]][$var["Candidate_DispName"]]["can_status"] = $var["Candidate_Status"];
			}
		}
	}
?>


<div class="row">

	<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/side/index.php";	?>
	<div class="main textleft">
	 	<P>
			<H2>Elections on the June 25<sup>th</sup> 2019 ballot.<BR>
				<?= $ResultVoter["DataCounty_Name"] ?> County</H2>
		</P>
			
			<FORM ACTION="" METHOD="POST">
			<P >
			<?php 
				if (! empty ($Election)) {
					foreach ($Election as $var => $key) {
						foreach ($key as $vor => $key2) {
						
						if ($var == "party") {
							if ($print_party == 0) {
								echo "<FONT SIZE=+1><B>Democratic party position:</B> <I>(volunteer and non official.)</I><BR>\n";
								$print_party = 1;
							} 
						} else {
							if ($print_elect == 0) {
								echo "<FONT SIZE=+1><B>City Official Position:</B> <I>(paid and official.)</I><BR>\n";
								$print_elect = 1;
							}
						}
						
						echo "<UL>";
						echo "<B>" . $vor . ":</B> <I>(select " . $digits[$key2["pos_number"]] . ")</I> <A HREF=\"" . $key2["pos_explain"] . "\" TARGET=\"PosInfo\"><i class=\"fa fa-question-circle\"></i></A><BR>\n";			
						echo "<UL>";
				
						foreach ($key2 as $vir => $key3) {
							if ( $key3["can_status"] == "published") {									
								echo "<INPUT TYPE=\"CHECKBOX\" NAME=\"NOMINATION[]\" VALUE=\"EID=" . $key3["can_eid"] . ";CANID=" . $key3["can_id"] . "\"> " . $vir . " <A HREF=\"" . $key3["can_web"] . "\" TARGET=\"CanInfo\"><i class=\"fa fa-info-circle\"></i></A><BR>\n";
							}
						}
						
						echo "<INPUT TYPE=\"CHECKBOX\" NAME=\"NOMINATION[]\" VALUE=\"EID=" . $key3["can_eid"] . ";SELF\"> I would like to nominate myself<BR>\n";
						echo "<INPUT TYPE=\"CHECKBOX\" NAME=\"NOMINATION[]\" VALUE=\"EID=" . $key3["can_eid"] . ";NOMINATE\"> I would like to nominate someone else<BR>\n";
						echo "</UL>";
						echo "</UL>\n";
							
						}
					}
				}
				?>
				</P>
	  		<P><INPUT TYPE="SUBMIT" class="btn success" VALUE="I want to nominate these candidates"></P>	
		 </FORM>
		  </DIV>
		 </div>
		  					
	
		  							  
		</DIV>
		</div>
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>