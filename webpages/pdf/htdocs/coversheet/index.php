<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/coversheet_class.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	#$r = new OutragedDems();

	#$result = $r->ListCandidatePetition($SystemUser_ID, "published");

	
	#			$PetitionData[$var["CanPetitionSet_ID"]]["TotalPosition"] = $var["CandidateElection_Number"];
	#			$PetitionData[$var["CanPetitionSet_ID"]]["PositionType"]	= $var["CandidateElection_PositionType"];
	#			$PetitionData[$var["CanPetitionSet_ID"]]["CandidateName"]	= $var["Candidate_DispName"];
	#			$PetitionData[$var["CanPetitionSet_ID"]]["CandidatePositionName"]	= $var["CandidateElection_PetitionText"];
	#			$PetitionData[$var["CanPetitionSet_ID"]]["CandidateResidence"] = $var["Candidate_DispResidence"];
	#			$PetitionData[$var["CanPetitionSet_ID"]]["Witness_FullName"][$var["CandidateWitness_ID"]] = $var["CandidateWitness_FullName"];
	#			$PetitionData[$var["CanPetitionSet_ID"]]["Witness_Residence"][$var["CandidateWitness_ID"]] = $var["CandidateWitness_Residence"];
		
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);

	if (
			$result[0]["CandidatePetition_VoterCounty"] == "New York" || 
			$result[0]["CandidatePetition_VoterCounty"] == "Richmond"
		) {
		$pdf->Watermark = "Demo Petition / Not Valid";
	}

	$Counter = 1;
	$TotalCandidates = 1;
	
	$i = 0;
	if ( ! empty ($PetitionData)) {
		foreach ( $PetitionData as $var => $key) {
					
			if ( ! empty ($var)) {
				if ( is_array($key)) {
 					$pdf->Candidate[$TotalCandidates] =  "Candidate Name";
 					$pdf->RunningFor[$TotalCandidates] =  "Position Name";
					$pdf->Residence[$TotalCandidates] = $key["CandidateResidence"];
					$pdf->PositionType[$TotalCandidates] = $key["PositionType"];
					
					$pdf->Appointments[$TotalCandidates] = "";
					$comma_first = 0;
					foreach ($key["Witness_FullName"] as $klo => $vir) {
						if ($comma_first == 1) {
							$pdf->Appointments[$TotalCandidates] .= ", ";
						}
						$pdf->Appointments[$TotalCandidates] .= $vir . ", " . $key["Witness_Residence"][$klo];						
						$comma_first = 1;
					}						
					$TotalCandidates++;	
				
				}
			}
		}
	}
	
	$pdf->NumberOfCandidates = $TotalCandidates;
	$pdf->county = "New York" . $var["CandidatePetition_VoterCounty"];
	$pdf->party = "Democratic";
	$pdf->ElectionDate = "June 25th, 2019";
	
	if ($pdf->NumberOfCandidates > 1) { 
		$pdf->PluralCandidates = "s"; 
		$pdf->PluralAcandidates = "";	
	} else { 
		$pdf->PluralCandidates = "";
		$pdf->PluralAcandidates = "a";	
	}

	$pdf->RunningForHeading["electoral"] = "PUBLIC OFFICE" . strtoupper($pdf->PluralCandidates);
	$pdf->RunningForHeading["party"] = "PARTY POSITION" . strtoupper($pdf->PluralCandidates);

	$pdf->CandidateNomination = "nomination of such party for public office";
	// Add or the if both.	
 	$pdf->CandidateNomination .= " or for election to a party position of such party.";

	// Need to fix that.
	
	$pdf->WitnessName = "________________________________________"; 
	$pdf->WitnessResidence = "_______________________________________________________"; 
	
	
	$pdf->TodayDateText = "Date: " . date("F _________ , Y"); 
	$pdf->TodayDateText = "Date: April _______ , 2019";
	$pdf->County = $result[0]["CandidatePetition_VoterCounty"];
	$pdf->City = "City of New York";
	
	$pdf->City = "____________________"; 
	$pdf->County = "__________________"; 
	
	if ( $PageSize == "letter") {
		$NumberOfLines = 14 - $pdf->NumberOfCandidates;
		$pdf->BottonPt = 240.4;
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
	
 
	
	
	
	$pdf->Output("I", "CoverSheet.pdf");

function Redact ($string) {
	return str_repeat("X", strlen($string)); ;
	return $string;
}

?>

