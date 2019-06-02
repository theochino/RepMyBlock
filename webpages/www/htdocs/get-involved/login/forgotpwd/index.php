<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";

	$r = new login();

	if ( ! empty ($_POST["signin"])) {
		
		$hashtable = hash(md5, PrintRandomText(40));
		$r->UpdateHash($_POST["email"], $hashtable);
		$result = $r->CheckEmail($_POST["email"]);
		
		SendForgotLogin($_POST["email"],  $hashtable, $result["SystemUser_username"]);
		header("Location: /get-involved/login/sentpasswd/");
		
		exit();
	}
					
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>



<div class="row">
	<div class="main">
		<P>
			<FONT SIZE=+2>Please enter the email address you registered with:</FONT>
		</P>
		<P>
			<FORM METHOD="POST" ACTION="">
				<TABLE>
					<TR><TD>Email:</TD><TD><INPUT TYPE="text" NAME="email" VALUE="" SIZE=30></TD></TR>
					<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="signin" VALUE="Send me a link to reset my password"></TD></TR>
				</TABLE>
			</FORM>
		</P>
	
		<P>
			If you don't receive an email in the next few hours, please sent an email to <B>passwordissues@repmyblock.nyc</B>
		</P>
		
		<P>
			<A HREF="/get-involved">Return to the previous page.</A>
		</P>

</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>
