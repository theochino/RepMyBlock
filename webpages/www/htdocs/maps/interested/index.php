<?php 
	if ( ! empty ($_POST["SubmitEDAD"])) {
		$URL = "getedinfo.php?ED=" . $_POST["ED"] . "&AD=" . $_POST["AD"];
		header("Location: $URL");
		exit();
	}
?>
<IMG SRC="https://www.outrageddems.nyc/word/wp-content/uploads/2018/01/cropped-OD-Logo_3.png">

<BR><BR>
	<A HREF="iaminterestedtorun.php">I am interested to run</A><BR>
	<A HREF="findmyplace.php">Select your address on a map</A>

<BR><BR>


<FORM ACTION="" METHOD="POST">
	<DIV NAME="ED">Election District <INPUT TYPE="TEXT" NAME="ED"></DIV>
	<DIV NAME="AD">Assembly District <INPUT TYPE="TEXT" NAME="AD"></DIV>
	<DIV NAME="ADEDINPUT"><INPUT TYPE="SUBMIT" NAME="SubmitEDAD" VALUE="Get Information"></DIV>
</FORM>


		