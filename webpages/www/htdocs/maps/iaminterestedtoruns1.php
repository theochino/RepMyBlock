<?php 
	if ( ! empty ($_POST["SubmitName"])) {
		$URL = "iaminterestedtoruns2.php?ED=" . $_POST["ED"] . "&AD=" . $_POST["AD"] . "&Email=" . $_POST["Email"] .
								 "&FN=" . $_POST["FN"] . "&LN=" . $_POST["LN"] . "&DOB=" . $_POST["DOB"];
		header("Location: $URL");
		exit();
	}
?>
<IMG SRC="https://www.outrageddems.nyc/word/wp-content/uploads/2018/01/cropped-OD-Logo_3.png">
<BR><BR>
<STRONG>We need to look you up in the voter database.<BR>
	Are you a New York State Registered voter in the Democratic Party ?</STRONG>
<P>
What is your first name, last name, and date of birth ?
<FORM ACTION="" METHOD="POST">
	<INPUT TYPE="hidden" NAME="ED" VALUE="<?= $_GET["ED"] ?>">
	<INPUT TYPE="hidden" NAME="AD" VALUE="<?= $_GET["AD"] ?>">
	<INPUT TYPE="hidden" NAME="EMAIL" VALUE="<?= $_GET["EMAIL"] ?>">
	
	<DIV NAME="fn">First Name: <INPUT TYPE="TEXT" NAME="FN"></DIV>
	<DIV NAME="ln">Last Name: <INPUT TYPE="TEXT" NAME="LN"></DIV>
	<DIV NAME="dob">Date of Birth [YYYYMMDD] (this will be fixed but DOE format): <INPUT TYPE="TEXT" NAME="DOB"></DIV>
	<DIV NAME="INPUT"><INPUT TYPE="SUBMIT" NAME="SubmitName" VALUE="Get Information"></DIV>
</FORM>	
	
</P>
