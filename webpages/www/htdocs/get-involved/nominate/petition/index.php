<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
  $digits = array(
 		0 => 'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven'
  );
  
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	

	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	$p = new OutragedDems();
	$result = $p->ListCandidatePetition($SystemUser_ID);

	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
	
	


?>

<div class="row">

	<div class="main">
		
		<h1><A HREF="<?= $FrontEndPDF ?>/multipetitions/?SystemUser_ID=1" TARGET="NEW">PDF Petition to download</A></H1>
	
		<P>
			This is the petition that you need to sign to and return to the candidate. If the candidate doesn't live far, you can
			call her/him to pick up the petition in person or you can email her/him to schedule a time that is convinient.
		</P>

	</DIV>

</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>