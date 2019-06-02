<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new voterlist();
	$result = $r->GetPetitionsSets($CandidatePetitionSet_ID);
	$EncryptURL = EncryptURL("Candidate_ID=" . $Candidate_ID . "&CandidatePetitionSet_ID=" . $CandidatePetitionSet_ID);
	
	$SampleText = "Hello,\n\nAttached is the petition I would you to get signed in your building.\n\nThanks for your help.\n" . $FirstName;
	
	if (! empty ($_POST)) {
		if ( ! empty ($_POST["friendemail"])) {
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
			SendPetitionEmail2($_POST["friendemail"], $_POST["mysubject"], $_POST["textofemail"], $k);
			header("Location: index.php?k=" .  EncryptURL("SystemUser_ID=" . $SystemUser_ID . "&CandidatePetitionSet_ID=" . 
																										"&Candidate_ID=" . $Candidate_ID . "&successmsg=The message was successfully sent"));
			exit();		
			
		} else {
			$error_msg = "<FONT COLOR=RED><B>Please verify the email address</B></FONT>";
		}
	}
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";	
	$mysubject = "Testing the sending the email .. ... " . date("m - d - y H:i:s");	
	$friendemail = "theo.chino@gmail.com";
?>

<div class="row">
	<div class="main">
		
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<P>
			Email a blank witnessed petition set to a friend so she/he can help you get more signature.
		</P>

		<?php if (! empty ($error_msg)) { 
			echo "<P>" . $error_msg . "</P>";
		} else if (! empty ($successmsg)) {
			echo "<P><FONT COLOR=GREEN><B>" . $successmsg . "</B></FONT></P>";
		}
		?>

			<P>
				<FORM ACTION="" METHOD="POST">
				<INPUT TYPE="text" NAME="friendemail" SIZE=40 placeholder="Your friend email address ..." VALUE="<?= $friendemail ?>"><BR>
				<INPUT TYPE="text" NAME="mysubject" SIZE=80 VALUE="<?= $mysubject ?>"><BR>
				<TEXTAREA NAME="textofemail" rows=10 cols=60><?= $SampleText ?></TEXTAREA><BR>
				<INPUT TYPE="submit" VALUE="Send the petition via email to a friend"><BR>		
				</FORM>
			</P>
			
			

		<P>
			<A HREF="/get-involved/list/?k=<?= EncryptURL("SystemUser_ID=" . $SystemUser_ID); ?>">Return to previous screen</A>	
		</P>

	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>