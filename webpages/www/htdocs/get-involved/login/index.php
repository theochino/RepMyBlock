<?php
	$BigMenu = "profile";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST["username"])) {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
		$r = new login();
		
		### I need to check the username and password.
		$resultPass = $r->CheckUsernamePassword($_POST["username"], $_POST["password"]);
		
		

		if ( ! empty ($resultPass)) {
			
			//$result = $r->FindRawVoterInfoFromSystemID($resultPass["SystemUser_ID"], $DatedFilesID, $DatedFiles);	
			//echo "I am here<PRE>" . print_r($resultPass, 1) . "</PRE>";
			//echo "I am here<PRE>" . print_r($result, 1) . "</PRE>";
			//exit();

			// Check if the candidate ID is set .... if so, get it too.
			// The RawVoterID stuff will need to be changed ... once I log in, we need to swtich.		
			/* $URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $result["Raw_Voter_ID"] . 
											"&DatedFiles=" . $DatedFiles . 
											"&ElectionDistrict=" . $result["Raw_Voter_ElectDistr"] . "&AssemblyDistrict=" . $result["Raw_Voter_AssemblyDistr"] . 
											"&FirstName=" . $result["SystemUser_FirstName"] . "&LastName=" . $result["SystemUser_LastName"] .
											"&Candidate_ID=" . $resultPass["Candidate_ID"]; */
											
			$URLToEncrypt = "SystemUser_ID=" . $resultPass["SystemUser_ID"];						
			header("Location: /get-involved/list/?k=" . EncryptURL($URLToEncrypt));
			exit();
			// The reason for no else is that the code supposed to go away.
		}
						
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>

<div class="row">
	<div class="main">
		<H1>Log In</H1>

		<?php if (! empty ($error_msg)) {
			echo "<P>" . $error_msg . "</P>";	
		} ?>
		
		<div class="container">

		<P>
			<FORM METHOD="POST" ACTION="">
				<TABLE>
					<TR><TD>Username:</TD><TD><INPUT TYPE="text" NAME="username" VALUE="<?= $_POST["username"] ?>" placeholder="Username ... " SIZE=30></TD></TR>
					<TR><TD>Password:</TD><TD> <INPUT TYPE="password" NAME="password" placeholder="Password ..." SIZE=30></TD></TR>
					<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="signin" VALUE="Log In"></TD></TR>
				</TABLE>
			</FORM>
		</P>
		
		</DIV>
		
		<P>
			<FONT SIZE=+2><A HREF="/get-involved/login/forgotpwd">I forgot my password</A></FONT><BR>
			<A HREF="/get-involved">Return to the previous screen</A>
		</P>

	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>