<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST["SaveInfo"])) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
		$r = new login();

		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		// This RawVoterID is the wrong one. We need to find the one from table Raw_Voter and not TabledRaw_Voter.
		// $resultRawVoter = $r->FindLocalRawVoterFromDatedFile($RawVoterID, $DatedFiles);		
		
		$EDAD = str_pad($AssemblyDistrict, 2, '0', STR_PAD_LEFT) .
						str_pad($ElectionDistrict, 3, '0', STR_PAD_LEFT);

		$result = $r->AddEmailWithNYSID($_POST["emailaddress"], $_POST["login"], $FirstName, $LastName, $UniqNYSID, "Running", $EDAD);
		
		
		$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName . "&emailaddress=" . $_POST["emailaddress"];
										
	
		// The reason for no else is that the code supposed to go away.		
		if ( $_POST["login"] == "password") {
			header("Location:/get-involved/register/requestpassword/index.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
		
		if ( $_POST["login"] == "email") {
			header("Location: /get-involved/register/requestemaillink/index.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
	
		// If we are here which we should never be we need to send user to problem loop
		exit();
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php"; 
?>
<div class="row">

	<div class="main">

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>

		<H3><?= $FirstName ?></H3>

		<P>
		<?php /*
			<A HREF="facebook.php?k=<?= $k ?>">Click here if you prefer to use your facebook information</A><BR>
			<A HREF="googleid.php?k=<?= $k ?>">Click here if you prefer to use your googleID information</A><BR>
		*/ ?>

			<FORM METHOD="POST" ACTION="">
			Enter your email address: <INPUT TYPE="text" NAME="emailaddress" SIZE=30><BR>
			
			<?php /*
			<INPUT TYPE="radio" NAME="login" VALUE="email">Do you prefer to login with a link sent to your email ?<BR>
			<BR>
			*/ ?>
			<INPUT TYPE="hidden" NAME="login" VALUE="password" CHECKED>
			
			<INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Next Screen">
			
			</FORM>
		</P>
	</div>
</div>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>