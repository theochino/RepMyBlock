<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["SaveInfo"])) {
	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
		
		$r = new login();

		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		$result = $r->CheckEmail($_POST["emailaddress"]);
		
		if ( empty ($result)) {
			// We did not find anything so we are creating it.
			$result = $r->AddEmail($_POST["emailaddress"], $_POST["login"], $FirstName, $LastName);
		} else if (! empty ($result["SystemUser_password"])) {			
				// That mean we did the stuff before so we need to jump to another screen
			
		}
		
		$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName;

		// The reason for no else is that the code supposed to go away.
		
		if ( $_POST["login"] == "password") {
			header("Location: requestpassword.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
		
		if ( $_POST["login"] == "email") {
			header("Location: requestemaillink.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
	
		// If we are here which we should never be we need to send user to problem loop
		
		exit();
		
	}


?>
<HTML>
	<BODY>
		
		<link rel="stylesheet" type="text/css" href="../maps.css">

		<div class="header">
		  <a href="#default" class="logo"><IMG SRC="/pics/OutragedDemLogo.png"></a>
		  <div class="header-right">
		    <a class="active" href="#home">Home</a>
		    <a href="#contact">Contact</a>
		    <a href="#about">About</a>
		  </div>
		</div> 
		
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<UL>
		<H3><?= $FirstName ?></H3>
		<H3><?= $Decrypted_k ?></H3>

		We are now going to present the list of voters in your area. <BR>
		
				
		<P>
		Step #1 is to prep the voter list: <A HREF="prepvoters.php?k=<?= $k ?>">Prep the Voter list</A><BR>
		Step #2 is to get the Petition in PDF Format
		<A TARGET="PDFFORM" HREF="<?= $FrontEndPDF ?>/petitions/?Candidate_ID=<?= $Candidate_ID ?>">Download the petition</A><BR>
<BR>


		Step #4: This is an example in case someone want to run but not commited.
		<A TARGET="PDFFORM" HREF="<?= $FrontEndPDF ?>/redactedpetitions/?ED=<?= $ElectionDistrict ?>&AD=<?= $AssemblyDistrict ?>&RAW=<?= $RawVoterID ?>&DatedFiles=<?= $DatedFiles ?>">Download the petition</A>

			
		</P>
		
				
		</UL>
		
	</BODY>
</HTML>
