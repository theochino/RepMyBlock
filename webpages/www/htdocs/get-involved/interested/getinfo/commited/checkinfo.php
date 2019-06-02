<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	// I just found the voter here .... so no need to do the reg.
		// We'll need verify them.

		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";	
		$r = new OutragedDems();
		$SystemUserID = $r->FindSystemUserVoter($RawVoterID);
		 			
		if (count ($SystemUserID) > 0) {
			#$URL = "../../list/?k=" . EncryptURL("SystemUser_ID=" . $SystemUserID[0]["SystemUser_ID"] . 
			#																	"&RawVoterID=" . $SystemUserID[0]["Raw_Voter_ID"] . "&DatedFiles=" . $DatedFiles . 
			#																	"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict);
			$URL = "../../login";
		} else {
			$URL = "../../register/?k=" . $k;
		}
	

	header("Location: $URL");
	exit();

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
		
		<link rel="stylesheet" type="text/css" href="../../maps.css">

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

		Let's start with some contact info.
		
		<P>

			<A HREF="facebook.php?k=<?= $k ?>">Click here if you prefer to use your facebook information</A><BR>
			<A HREF="googleid.php?k=<?= $k ?>">Click here if you prefer to use your googleID information</A><BR>

			<FORM METHOD="POST" ACTION="">
			Enter your email address: <INPUT TYPE="text" NAME="emailaddress" SIZE=30><BR>
			
			<INPUT TYPE="radio" NAME="login" VALUE="email">Do you prefer to login with a link sent to your email ?<BR>
			<INPUT TYPE="radio" NAME="login" VALUE="password" CHECKED>Do you prefer to login with a traditional password ?<BR>
			<BR>
			
			<INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Save my information">
			
			</FORM>
		</P>
		
		
		
		<A HREF="checkinfo.php?k=<?= $k ?>">I want to continue to the next step</A>
				
		</UL>
		
	</BODY>
</HTML>
