<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( $SystemUser_ID > 0) {

		if ( ! empty ($_POST["SaveInfo"])) {
		
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
			
			$r = new login();

			// First thing we need to check is the vadility of the email address.	
			// Then we need to check the database for the existance of that email.	
			$result = $r->CheckUsername($_POST["SystemUser_username"]);
			
			// We Checked that password matches so we are good.
			
			if ( empty ($result)) {
				// We did not find anything so we are creating it.
				// We need to encrypt the password here.
				
				$r->UpdateUsernamePassword($SystemUser_ID, $_POST["username"], $_POST["password"]);
				
				$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . 
											"&DatedFiles=" . $DatedFiles . 
											"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
											"&FirstName=" . $FirstName . "&LastName=" . $LastName;

				// The reason for no else is that the code supposed to go away.
				header("Location: registrationdone.php?k=" . EncryptURL($URLToEncrypt));
				exit();
				
			} else  {			
					// That mean we found an error in the user input so we give them the same screen
				
			}
			
			
			
		}
	} else {
		
		// The userid is ZERO and we need to check why.
		// We should never be here so we'll need to send meail to admin.
		
		
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

		You are requesting to login using a username and password.<BR>
		At the same time we are sending you an email to verify that you have access to email.
		
		<P>

			<FORM METHOD="POST" ACTION="">
			Enter the username you want: <INPUT TYPE="text" NAME="username" SIZE=30><BR>
			Enter the password you want: <INPUT TYPE="password" NAME="password" SIZE=30><BR>
			Verify the password you want: <INPUT TYPE="password" NAME="verifpassword" SIZE=30><BR>

			<BR>
			
			<INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Save my information">
			
			</FORM>
		</P>
	
				
		</UL>
		
	</BODY>
</HTML>
