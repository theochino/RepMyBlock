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


	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
	echo "This is the self nomination screen";

?>
