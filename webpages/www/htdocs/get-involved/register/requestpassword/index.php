<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( $SystemUser_ID > 0) {

		if ( ! empty ($_POST["SaveInfo"])) {
		
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
			
			$r = new login();

			// First thing we need to check is the vadility of the email address.	
			// Then we need to check the database for the existance of that email.	
			$result = $r->CheckUsername($_POST["username"]);
			
			// We Checked that password matches so we are good.	
			if ( empty ($result)) {
				// We did not find anything so we are creating it.
				// We need to encrypt the password here.
				
				// Check that the password match.
				if ($_POST["password"] == $_POST["verifpassword"]) {
																	
					if (strlen($_POST["password"]) < 8) {
			    	$ErrorMessage = "<FONT COLOR=RED><B>Password too short!<BR>Password must at least 8 characters!</B></FONT>";
			    } else if (!preg_match("#[0-9]+#", $_POST["password"])) {
        		$ErrorMessage = "<FONT COLOR=RED><B>Password must include at least one number!</B></FONT>";
    			} else if (!preg_match("#[a-zA-Z]+#", $_POST["password"])) {
			    	$ErrorMessage = "<FONT COLOR=RED><B>Password must include at least one letter!</B></FONT>";
			    } else {
			    	
						$hashtable = hash("md5", PrintRandomText(40));
						$r->UpdateUsernamePassword($SystemUser_ID, $_POST["username"], $_POST["password"], $hashtable );
					
						$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . 
													"&DatedFiles=" . $DatedFiles . 
													"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
													"&FirstName=" . $FirstName . "&LastName=" . $LastName;

						// Mail it
						require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
						SendWelcomeEmail($emailaddress, $hashtable, $_POST["username"]);
						header("Location: /get-involved/register/registrationdone/?k=" . EncryptURL($URLToEncrypt));
						exit();
					}
				} else {
					$ErrorMessage = "<FONT COLOR=RED><B>The password don't match, please verify that they do.</B></FONT>";
				}
				
			} else  {			
					// That mean we found an error in the user input so we give them the same screen
					$ErrorMessage = "<FONT COLOR=RED><B>The username " . $_POST["username"] . " is already in the System</B></FONT>";
			}

		}
	} else {
		
		// The userid is ZERO and we need to check why.
		// We should never be here so we'll need to send meail to admin.
		
		print "<FONT COLOR=RED><B>THERE IS AN INTERNAL ERROR WITH userid = zero - Nothing you can do, we need to investigate. Try from the beggining.</B></FONT>";
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";		
?>


<div class="row">
	<div class="main">
		
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>

		<H3><?= $FirstName ?></H3>

		<P>
			Please select a username and a password.
		</P>

		<?php if (! empty ($ErrorMessage)) { 
			echo "<P>" . $ErrorMessage . "</P>";
		} ?>
		
		<P>
			<FORM METHOD="POST" ACTION="">
				<TABLE>
					<TR><TD>Username:</TD><TD><INPUT TYPE="text" NAME="username" VALUE="<?= $_POST["username"] ?>" SIZE=30></TD></TR>
					<TR><TD>Password:</TD><TD> <INPUT TYPE="password" NAME="password" SIZE=30></TD></TR>
					<TR><TD>Verify password:</TD><TD> <INPUT TYPE="password" NAME="verifpassword" SIZE=30></TD></TR>
					<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Save my information"></TD></TR>
				</TABLE>
			</FORM>
		</P>
			
		</div>
</div>	
			
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>