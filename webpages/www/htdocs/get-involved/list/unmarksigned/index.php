<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	

	// PrintDebugArray($Decrypted_k);

	$r = new voterlist();
	$r->UnMarkVoterAsSigned($CandidatePetition_ID, $Candidate_ID, $SystemUser_ID);
	echo "Unmarked";
?>