<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	if ( $SystemUser_ID > 0) {


		if ( ! empty ($_POST["SaveInfo"])) {
		
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
			
			$r = new login();
	
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
					$r->UpdateUsernamePassword($SystemUser_ID, $username, $_POST["password"], $hashtable );
				
					$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . 
												"&DatedFiles=" . $DatedFiles . 
												"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
												"&FirstName=" . $FirstName . "&LastName=" . $LastName;
	
											
					header("Location: /get-involved/login/recoverdone/?k=" . EncryptURL($URLToEncrypt));
					exit();
				}
			} else {
				$ErrorMessage = "<FONT COLOR=RED><B>The password don't match, please verify that they do.</B></FONT>";
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
		<H3>Select a new password</H3>

		<?php if (! empty ($ErrorMessage)) { 
			echo "<P>" . $ErrorMessage . "</P>";
		} ?>
		
		<P>
			<FORM METHOD="POST" ACTION="">
				<TABLE>
					<TR><TD>Password:</TD><TD> <INPUT TYPE="password" NAME="password" SIZE=30></TD></TR>
					<TR><TD>Verify password:</TD><TD> <INPUT TYPE="password" NAME="verifpassword" SIZE=30></TD></TR>
					<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Select a new password"></TD></TR>
				</TABLE>
			</FORM>
		</P>
	</DIV>
</DIV>
			
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>