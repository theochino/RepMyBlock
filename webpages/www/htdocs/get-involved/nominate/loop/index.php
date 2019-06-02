<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	
	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	
	$mysubject =  "I would like to nominate you.";
	$SampleText = "Hello,\nI would like to nominate you for the position of ... ";
	
	$p = new OutragedDems();
	
	if ( ! empty ($_POST)) {
		// Update the Database with the information
		
		echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
		
		// $r->UpdateCandidateNomination($Can);
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
		$p->InsertNewNomination($_POST["CandidateElectionID"], $SystemUser_ID, $_POST["FirstName"], $_POST["LastName"], $_POST["email"], $_POST["cellphone"]);
		
		SendNominationEmail($_POST["email"], $_POST["mysubject"], $_POST["textofemail"]);
		header("Location: index.php?k=" .  EncryptURL(DecryptURL($k) . "&successmsg=The message was successfully sent"));
		exit();		
	}

	$result = $p->ListOnlyElections();	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>

<div class="row">
	<div class="main">
			<FORM METHOD="POST" ACTION="">
		
		<h1>Nominations</H1>

		<H3><?= $FirstName ?></H3>

		<P>
			I would like to nominate this person for the position of 
			<SELECT NAME="CandidateElectionID">
				<OPTION>Select the Election</OPTION>
				<?php if (! empty ($result)) {
					foreach ($result as $var) {
						if ( ! empty ($var)) {
							
							echo "<OPTION VALUE=\"" . $var["CandidateElection_ID"] . "\">" . $var["CandidateElection_Text"] . "</OPTION>\n";
							
						}
					}
				}
				?>	
			</SELECT>			
		</P>

		<P>
				<TABLE>
					<TR>
						<TD>First Name:</TD><TD><INPUT TYPE="text" NAME="FirstName" VALUE="<?= $_POST["FirstName"] ?>" SIZE=30></TD>
						<TD>&nbsp;</TD>
						<TD>Last Name:</TD><TD><INPUT TYPE="text" NAME="LastName" VALUE="<?= $_POST["LastName"] ?>" SIZE=30></TD>
					</TR>

					<TR>
						<TD>Email:</TD><TD><INPUT TYPE="text" NAME="email" VALUE="<?= $_POST["email"] ?>" SIZE=30></TD>
						<TD>&nbsp;</TD>
						<TD>Cell Phone:</TD><TD><INPUT TYPE="text" NAME="cellphone" VALUE="<?= $_POST["cellphone"] ?>" SIZE=30></TD>
					</TR>
					
					<TR>
						<TD>Subject:</TD><TD COLSPAN=4><INPUT TYPE="text" NAME="mysubject" SIZE=85 VALUE="<?= $mysubject ?>"></TD>
					</TR>
					
					<TR>
						<TD VALIGN=TOP>&nbsp;<BR>Message:</TD>
						<TD COLSPAN=4><TEXTAREA NAME="textofemail" rows=10 cols=60><?= $SampleText ?></TEXTAREA></TD>
					</TR>
					
					
				
					<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Nominate this person"></TD></TR>
				</TABLE>
			</FORM>
		</P>
			
		</div>
</div>	


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>