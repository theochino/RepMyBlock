<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST["SaveInfo"])) {
	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
		
		$r = new login();

		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		//$result = $r->CheckEmail($_POST["emailaddress"]);
	
		// $resultRawVoter = $r->FindLocalRawVoterFromDatedFile($RawVoterID, $DatedFiles);
		
		$result = $r->SaveEmailNYSID($_POST["emailaddress"], $UniqNYSID);
		
		$URLToEncrypt = EncryptURL("SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
																"&DatedFiles=" . $DatedFiles . "&UniqNYSID=" . $UniqNYSID . 
																"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
																"&FirstName=" . $FirstName . "&LastName=" . $LastName);

		// The reason for no else is that the code supposed to go away.
		$URL="/get-involved/interested/getinfo/thinkaboutit/thanks/?k=" . $URLToEncrypt;
		header("Location: $URL");
		
		exit();
		
	}

include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<div class="row">
	<div class="main">
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<UL>
		<H3><?= $FirstName ?></H3>

		<P>
			We need Democrats like yourself to consider running for the County Committee.<BR>
			All over New York City there is a Democratic Club where you can find more information about
			how to get involved.<BR>
		</P>
	
		<P>
			All the clubs are not the same so you'll have to visit several until you find one that 
			that fit with your convictions.
		</P>
		
		
		<P>	
			<FORM METHOD="POST" ACTION="">
			Enter your email address: <INPUT TYPE="text" NAME="emailaddress" SIZE=30><BR>				
			<INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Save my information">
			</FORM>
		</P>
		
				
		</UL>
	</DIV>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>