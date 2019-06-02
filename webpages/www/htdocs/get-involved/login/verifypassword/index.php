<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	// Check that the hash code exist.
	
	if ( ! empty ($_POST)) {
		if ( ! empty ($_POST["password"])) {
			if (password_verify ( $_POST["password"] , $password ) == 1) {
				
				
				$r->VerifyAccount($SystemUser_ID);
				$result = $r->FindRawVoterInfoFromSystemID($SystemUser_ID, $DatedFilesID, $DatedFiles);				
			
				if ($SystemUser_ID > 0 ) {
					//$resultCandidate = $r->FindCandidateInfo($SystemUser_ID);		
					$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID;
					
					header("Location: /get-involved/list/?k=" . EncryptURL($URLToEncrypt));
					exit();
				}
			}
		}
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<div class="row">
	<div class="main">
		
		<H1>Verify the email address</H1>
		
		<?php if (! empty ($error_msg)) {
			echo "<P>" . $error_msg . "</P>";	
		} ?>

		<P>
			<FORM METHOD="POST" ACTION="">
				<TABLE>
					<TR><TD>Password:</TD><TD><INPUT TYPE="password" NAME="password" VALUE="" SIZE=30></TD></TR>
					<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="signin" VALUE="Enter your password"></TD></TR>
				</TABLE>
			</FORM>
		</P>
		
		<P>
			<FONT SIZE=+2><A HREF="/get-involved/login/forgotpwd/">I forgot my password</A></FONT><BR>
			<A HREF="verify.php?hashkey=<?= $hashkey ?>&username=<?= $username ?>">Return to the previous screen</A>
		</P>
	</div>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>