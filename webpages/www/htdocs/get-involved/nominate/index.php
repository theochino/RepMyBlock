<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
  $digits = array(
 		0 => 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven'
  );
  
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	$p = new OutragedDems();
	
	// $DatedFilesID from var.
	if ( ! empty ($_POST)) {
		$CandidateNomin = "";	$print_nominate = 0;
		$CandidateSelf = ""; $print_self = 0;
		
		//echo "<B>DecryptedLIne:</B> " .  $_SERVER['DOCUMENT_URI'] .  "<UL>$Decrypted_k</UL>";				
		$ListCandidates = $p->ListCandidateNomination($SystemUser_ID);
		
		// Need to check out the list.
		for ($i = 0; $i < count ($_POST["NOMINATION"]); $i++) {
			preg_match("/EID=(.*);CANID=(.*)/", $_POST["NOMINATION"][$i], $matches, PREG_OFFSET_CAPTURE);
			$MatchingPerson = 0;
			
			for ($j = 0; $j < count($ListCandidates); $j++) {
				if ($ListCandidates[$j]["CandidateElection_ID"] == $matches[1][0]	&& 
						$ListCandidates[$j]["Candidate_ID"] == $matches[2][0]	&& 
						$ListCandidates[$j]["SystemUser_ID"] == $SystemUser_ID ) {
					$MatchingPerson = 1;
				}
			}
			
			if ( is_numeric($matches[2][0]) && $MatchingPerson == 0 ) { 				
				$p->CandidateNomination($SystemUser_ID, $matches[1][0], $matches[2][0]);
			}		
			
			if ( $matches[2][0] == "NOMINATE") {
				if ($print_nominate == 1) { $CandidateNomin .= ","; }
				$CandidateNomin .= $matches[1][0];
				$print_nominate = 1;
				
			} else if ($matches[2][0] == "SELF") { 
				if ($print_self  == 1) { $CandidateSelf .= ","; }
				$CandidateSelf .= $matches[1][0];
				$print_self = 1;
			}
				
		}
		
		$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID;
		if ( $print_nominate == 1) { $URLToEncrypt .= "&CandidateNomin=" . $CandidateNomin; }
		if ( $print_self == 1) { $URLToEncrypt .= "&CandidateSelf=" . $CandidateSelf; }


		if ( $print_nominate == 1) { header("Location: /get-involved/nominate/loop/?k=" . EncryptURL($URLToEncrypt));	exit(); } 
		if ( $print_self == 1) { header("Location: /get-involved/nominate/selfnominate/?k=" . EncryptURL($URLToEncrypt));	exit();} 
		
		header("Location: /get-involved/nominate/petition/?k=" . EncryptURL($URLToEncrypt));
		exit();
	}
	
	if ( empty ($DatedFiles)) {
		print "<FONT COLOR=\"RED\">We have an issue with the NYS Voter File and we can't continue.</FONT>";
		exit(1);
	}
	
	// require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
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
		
		<P>
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
						
						echo "<UL CLASS=\"right-align\">";
						echo "<B>" . $vor . ":</B> <I>(select " . $digits[$key2["pos_number"]] . ")</I> <A HREF=\"" . $key2["pos_explain"] . "\" TARGET=\"PosInfo\"><i class=\"fa fa-question-circle\"></i></A><BR>\n";			
						echo "</UL>";
				
						foreach ($key2 as $vir => $key3) {
							if ( $key3["can_status"] == "published") {									
								echo "<INPUT TYPE=\"CHECKBOX\" NAME=\"NOMINATION[]\" VALUE=\"EID=" . $key3["can_eid"] . ";CANID=" . $key3["can_id"] . "\"> " . $vir . " <A HREF=\"" . $key3["can_web"] . "\" TARGET=\"CanInfo\"><i class=\"fa fa-info-circle\"></i></A><BR>\n";
							}
						}
						
						echo "<INPUT TYPE=\"CHECKBOX\" NAME=\"NOMINATION[]\" VALUE=\"EID=" . $key3["can_eid"] . ";CANID=SELF\"> I would like to nominate myself<BR>\n";
						echo "<INPUT TYPE=\"CHECKBOX\" NAME=\"NOMINATION[]\" VALUE=\"EID=" . $key3["can_eid"] . ";CANID=NOMINATE\"> I would like to nominate someone else<BR>\n";
						echo "</UL>";
						echo "</UL>\n";
							
						}
					}
				}
				?>
				
				</P>

	  		<P><INPUT TYPE="SUBMIT" class="btn success" VALUE="I want to nominate these candidates"></P>	
	
		  </DIV>
		 </div>
		  					
		 </FORM>
		  							  
		</DIV>
		</div>
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>