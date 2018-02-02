<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/petition_class.php';
	
	$ED = $_GET["ED"];
	$AD = $_GET["AD"];
	$RawVoterID = $_GET["RAW"];
	$DatedFiles = $_GET["DatedFiles"];
	
	$r = new OutragedDems();
	$result = $r->FindRawVoterbyADED($DatedFiles, $ED, $AD);

	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);

	$TotalCandidates = 0;
	$i = 0;
	if ( ! empty ($result)) {
		foreach ( $result as $var) {
			if ( ! empty ($var)) {
				// The Candidate need to be on the list automatically.
				// We'll need to change that later.
				if ( $var["Raw_Voter_ID"] == $RawVoterID) {
					$pdf->Candidate[$TotalCandidates] = $var["Raw_Voter_FirstName"] . " " . $var["Raw_Voter_MiddleName"] . " " . 
																							Redact($var["Raw_Voter_LastName"]) . " " . $var["Raw_Voter_Suffix"];	
					$pdf->RunningFor[$TotalCandidates] = "Member of the Democratic County Committee from the " . $ED . "th " .
																								"Election District in the " . $AD . "st Assembly District " . 
																								"Queens County, New York State";
					$pdf->Residence[$TotalCandidates] = Redact($var["Raw_Voter_ResHouseNumber"]) . " " . $var["Raw_Voter_ResStreetName"] . "\n" .
											$var["Raw_Voter_ResCity"] . ", NY " . $var["Raw_Voter_ResZip"];			
																			
					// In this case the witness is the candidate.
					$pdf->WitnessName = $pdf->Candidate[$TotalCandidates];
					$pdf->WitnessResidence = Redact($var["Raw_Voter_ResHouseNumber"]) . " " . $var["Raw_Voter_ResStreetName"] . ", " .
											$var["Raw_Voter_ResCity"] . ", NY " . $var["Raw_Voter_ResZip"];			

					
					$TotalCandidates++;	
				}
				
				$Name[$i] = $var["Raw_Voter_FirstName"] . " " . $var["Raw_Voter_MiddleName"] . " " . 
										Redact($var["Raw_Voter_LastName"]) . " " . $var["Raw_Voter_Suffix"];	 		
				$Address[$i] = Redact($var["Raw_Voter_ResHouseNumber"]) . " " . $var["Raw_Voter_ResStreetName"] . "\n" .
											$var["Raw_Voter_ResCity"] . ", NY " . $var["Raw_Voter_ResZip"] . "\n" .
											"County of New York";
				$County[$i] = "New York";
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
	$pdf->county = "New York";
	$pdf->party = "Democratic";
	$pdf->ElectionDate = "September 12th, 2018";
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
	
	$pdf->TodayDateText = "Date: December _________ , 2017";
	$pdf->County = "Queens";
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

  for ($i = 0; $i < count($Name); $i++) {
  	$Counter++;
 		$YLocation = $pdf->GetY();

  	$pdf->SetFont('Arial', '', 10);
  	$pdf->SetY($YLocation + 2);
		$pdf->Cell(38, 0, $Counter . ". Dec _____, 2017", 0, 0, 'L', 0);
		
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
    
	$pdf->Output("I", "OutragedDems-Petitions.pdf");


function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

