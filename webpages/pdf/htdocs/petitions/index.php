<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/petition_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$r = new OutragedDems();
	
	$candidate_result = $r->CandidateInformation($Candidate_ID);
	$result = $r->CandidatePetition($CandidatePetitionSet_ID);
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);


	if (
			$result[0]["CandidatePetition_VoterCounty"] == "New York" || 
			$result[0]["CandidatePetition_VoterCounty"] == "Richmond"
		) {
		$pdf->Watermark = "Demo Petition / Not Valid";
	}

	$Counter = 1;
	$TotalCandidates = 0;
	$i = 0;
	if ( ! empty ($result)) {
		foreach ( $result as $var) {
			if ( ! empty ($var)) {
				// The Candidate need to be on the list automatically.
				// We'llneed to change that later.
				if ($Counter++ == 1) {
//				if ( $var["Raw_Voter_ID"] == $RawVoterID) {
					$pdf->Candidate[$TotalCandidates] =  $candidate_result["Candidate_DispName"];	
					$pdf->RunningFor[$TotalCandidates] = $candidate_result["Candidate_DispPosition"];
					$pdf->Residence[$TotalCandidates] = $candidate_result["Candidate_DispResidence"];		
																			
					// In this case the witness is the candidate.
					$pdf->WitnessName = $pdf->Candidate[$TotalCandidates];
					$pdf->WitnessResidence = $candidate_result["Candidate_DispResidence"];

					$TotalCandidates++;	
				}
				
				$Name[$i] = $var["CandidatePetition_VoterFullName"];		
				$Address[$i] = $var["CandidatePetition_VoterResidenceLine1"] . "\n" .
											$var["CandidatePetition_VoterResidenceLine2"] . "\n" .
											$var["CandidatePetition_VoterResidenceLine3"];
											
				$County[$i] = $var["CandidatePetition_VoterCounty"];
				$i++;
			}
		}
	}
	
	//echo "I am here $ED, $AD\n";
	//echo "<PRE>" . print_r($result, 1) . "<PRE>";
	//exit();
	//$NumberOfElectors = $result["TotalVoters"];
	//$NumberOfSignatures = intval($NumberOfElectors * .05) + 1;
	//$NumberOfAddressesOnDistrict = 0;
	
	fwrite(STDERR, "Result: " . count($result) . "\n");

	$pdf->NumberOfCandidates = $TotalCandidates;
	$pdf->county = $var["CandidatePetition_VoterCounty"];
	$pdf->party = "Democratic";
	$pdf->ElectionDate = "June 25th, 2019";
	
	if ($pdf->NumberOfCandidates > 1) { 
		$pdf->PluralCandidates = "s"; 
		$pdf->PluralAcandidates = "";	
	} else { 
		$pdf->PluralCandidates = "";
		$pdf->PluralAcandidates = "a";	
	}
	
	$pdf->RunningForHeading = "PARTY POSITION" . strtoupper($pdf->PluralCandidates);
	$pdf->CandidateNomination = "nomination of such party for public office ". $pdf->PluralCandidates;
	// Add or the if both.	
 	$pdf->CandidateNomination = "election to party position" . $pdf->PluralCandidates . " of such party.";

	$pdf->Appointments = "Theo Chino, 640 Riverside Drive Apt 10B, New York, NY 10031, " . 
												"Julio C. Pineda, 29 Cornelia Street Apt 1, Brooklyn, NY 11221, " .
												"Blanca N. Pujols, 640 Riverside Drive Apt 10H, New York, NY 10031";
	
	$pdf->TodayDateText = "Date: March _________ , 2019";
	$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
	$pdf->City = "City of New York";
  
	if ( $PageSize == "letter") {
		$NumberOfLines = 14 - $pdf->NumberOfCandidates;
		$pdf->BottonPt = 236;
	} else if ( $PageSize = "legal") {
		$NumberOfLines = 23;
		$pdf->BottonPt = 236;
	}

	$pdf->AliasNbPages();
	$pdf->SetTopMargin(8);
	$pdf->SetLeftMargin(5);
	$pdf->SetRightMargin(5);
	$pdf->SetAutoPageBreak(1, 38);
	$pdf->AddPage();
	
	// This is the meat of the petition.	
  $Counter = 0;

	// Need to calculate the number of empty line.
	
	$TotalCountName = count($Name);
	
	

  for ($i = 0; $i < $TotalCountName; $i++) {
  	$Counter++;
 		$YLocation = $pdf->GetY();

  	$pdf->SetFont('Arial', '', 10);
  	$pdf->SetY($YLocation + 2);
		$pdf->Cell(38, 0, $Counter . ". _______, 2019", 0, 0, 'L', 0);
		
		$pdf->SetX(195);
		$pdf->Cell(38, 0, $County[$i], 0, 0, 'L', 0);
		
		$pdf->SetXY(41, $YLocation + 6);
		$pdf->Cell(78, 0, $Name[$i], 0,'C', 0);
		
		$pdf->SetXY(121, $YLocation - 4);
		$pdf->MultiCell(73, 2.8, $Address[$i], 0, 'L', 0);

		$pdf->Line(5, $YLocation + 8, 212.5, $YLocation + 8);
		$pdf->SetY($YLocation);
		
		$pdf->Ln(13); 
		
		if ( $Counter > $NumberOfLines ) {
			$Counter = 0;
			$pdf->AddPage();
		}	
	}
	
	while ( $Counter <= $NumberOfLines) {
		$Counter++;
 		$YLocation = $pdf->GetY();

  	$pdf->SetFont('Arial', '', 10);
  	$pdf->SetY($YLocation + 2);
		$pdf->Cell(38, 0, $Counter . ". _______, 2019", 0, 0, 'L', 0);
		
		$pdf->SetX(195);
		$pdf->Cell(38, 0, $County[$i], 0, 0, 'L', 0);
		
		$pdf->SetXY(41, $YLocation + 6);
		
		
		$pdf->SetXY(121, $YLocation - 4);
		
		$pdf->Line(5, $YLocation + 8, 212.5, $YLocation + 8);
		$pdf->SetY($YLocation);
		
		$pdf->Ln(13); 
	}
	
    
	$pdf->Output("I", "OutragedDems-Petitions.pdf");


function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

