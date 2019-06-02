<?php
	//date_default_timezone_set('America/New_York'); 
		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . '/../libs/funcs/voterlist.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$r = new OutragedDems();

	$result = $r->ListCandidatePetition($SystemUser_ID, "published");
	$result = $result[0];
	$voters = $r->ListVoterCandidate($result["Candidate_ID"]);
	
	$PageSize = "letter";
	$pdf = new PDF('P','mm', $PageSize);

	$pdf->Candidate[0] = $result["Candidate_DispName"];
	$pdf->RunningFor[0] = $key["CandidatePositionName"];
	$pdf->Residence[0] = $result["Candidate_DispResidence"];
	$pdf->PositionType[0] = $result["CandidateElection_PositionType"];

	$pdf->NumberOfCandidates = 1;
	$pdf->ElectionDate = "June 25th, 2018";

	if ( $PageSize == "letter") {
		$NumberOfLines = 13; $pdf->BottonPt = 10.4;
	} else if ( $PageSize = "legal") {
		$NumberOfLines = 23; $pdf->BottonPt = 236;
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

	$TotalCountName = count($voters);
	
  for ($i = 0; $i < $TotalCountName; $i++) {
 		
 		$YLocation = $pdf->GetY() + 10;
  	$pdf->SetFont('Arial', '', 10);
		$pdf->SetXY(6, $YLocation);
		$pdf->Cell(27, 0, $i .  $voters[$i]["Raw_Voter_DatedTable_ID"], 0, 'L', 0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(50, 0, $voters[$i]["CandidatePetition_VoterFullName"], 0,'L', 0);		
		$pdf->SetFont('Arial', '', 10);
		$pdf->SetXY(38, $YLocation + 4);
		$pdf->MultiCell(0, 0, $voters[$i]["CandidatePetition_VoterResidenceLine1"] . " " .
															$voters[$i]["CandidatePetition_VoterResidenceLine2"] . " " .
															$voters[$i]["CandidatePetition_VoterResidenceLine3"], 0, 'R', 0);

		$pdf->Line(5, $YLocation + 8, 212.5, $YLocation + 8);
	//	$pdf->SetY($YLocation);
		
	
		
		if ( $Counter++ > $NumberOfLines ) {
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

