<?php 
	if ( ! empty ($_POST["SubmitEmail"])) {
		$URL = "iaminterestedtoruns1.php?ED=" . $_POST["ED"] . "&AD=" . $_POST["AD"] . "&EMAIL=" . $_POST["EMAIL"] ;
		header("Location: $URL");
		exit();
	}
?>
<IMG SRC="https://www.outrageddems.nyc/word/wp-content/uploads/2018/01/cropped-OD-Logo_3.png">
<BR><BR>
<STRONG>We need to look you up in the voter database.<BR>
	Are you a New York State Registered voter in the Democratic Party ?</STRONG>
<P>
If you are, What is your email address ?
<FORM ACTION="" METHOD="POST">
	<INPUT TYPE="hidden" NAME="ED" VALUE="<?= $_GET["ED"] ?>">
	<INPUT TYPE="hidden" NAME="AD" VALUE="<?= $_GET["AD"] ?>">
	<DIV NAME="email">Email Address: <INPUT TYPE="TEXT" NAME="EMAIL"></DIV>
	<DIV NAME="EMAILINPUT"><INPUT TYPE="SUBMIT" NAME="SubmitEmail" VALUE="Get Information"></DIV>
</FORM>	
	
</P>
