<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php"; 	

	if ($_GET["crd"] == 1) {
		$error_msg = "Cryptographic Decrypt error";
	}
	
	if ($_GET["cre"] == 1) {
		$error_msg = "Cryptographic Encrypt error";
	}


	echo "<P><BR><BR></P>";

	echo "<h2>" . $error_msg . "</h2>";


	echo "<P><BR><BR></P>";	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; 
?>
