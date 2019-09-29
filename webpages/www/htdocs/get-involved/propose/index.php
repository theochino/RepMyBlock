<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST)) {  
		if ( empty ($_POST["LN"]) || empty ($_POST["FN"])) {
			$error_msg = "<B><FONT COLOR=RED>Please enter your name.</FONT></B>";
		} else if ( empty ($_POST["year-of-birth"]) || empty ( $_POST["month-of-birth"]) || empty ($_POST["day-of-birth"])) {
	  	$error_msg = "<B><FONT COLOR=RED>Please enter your date of birth.</FONT></B>";
	  } else {
		  $DOB = $_POST["year-of-birth"] . "-" . $_POST["month-of-birth"] . "-" . $_POST["day-of-birth"];
		  if ( checkdate ( $_POST["month-of-birth"] ,  $_POST["day-of-birth"] , $_POST["year-of-birth"]) == 1) {
				$URL = "/get-involved/nominate/checkinfo/?k=" . EncryptURL("FirstName=" . $_POST["FN"] . "&LastName=" . $_POST["LN"] . "&DOB=" . $DOB . "&Email=" . $_POST["EM"]);						 
				header("Location: $URL");	
				exit();
			}
			$error_msg = "<B><FONT COLOR=RED>Please check the date of birth as it seems incorrect.</FONT></B>";
		}
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>


<div class="main">

<P>
	<H1>Nominate a candidate!</H1>
</P>

<P>
	This tool will help you nominate candidates that have expressed interest in running 
	in New York City. Many of the candidates are unheard because the current system is
	based on a pay to play system.
</P>

<P>
	In order to nominate a candidate, you need to be a <B>registered voter in the party</B> 
	you are nominating the candidate.
</P>

<P>
<B><A HREF="/get-involved/propose/list/">List of candidate already nominated you can support</A></B>
</P>


<?php if (! empty ($error_msg)) { ?>
<P>
	<?= $error_msg ?>
</P>
<?php } ?>

<div class="container">
	<FORM ACTION="" METHOD="POST">

		<label for="fname">First Name</label>
		<input type="text" id="fname" name="FN" value="<?= $_POST["FN"] ?>" placeholder="Your name ...">
		
		<label for="lname">Last Name</label>
		<input type="text" id="lname" name="LN" value="<?= $_POST["LN"] ?>"placeholder="Your last name ...">
		<BR>
		<label for="meeting">Date of Birth:</label>
		<input id="meeting" type="text" name="day-of-birth" size=2>
		<SELECT id="meeting" name="month-of-birth"> 
		    <OPTION VALUE="01">January</OPTION>
		    <OPTION VALUE="02">February</OPTION>
		    <OPTION VALUE="03">March</OPTION>
		    <OPTION VALUE="04">April</OPTION>
		    <OPTION VALUE="05">May</OPTION>
		    <OPTION VALUE="06">June</OPTION>
		    <OPTION VALUE="07">July</OPTION>
		    <OPTION VALUE="08">August</OPTION>
		    <OPTION VALUE="09">September</OPTION>
		    <OPTION VALUE="10">October</OPTION>
		    <OPTION VALUE="11">November</OPTION>
		    <OPTION VALUE="12">December</OPTION>
		</SELECT>
		<input id="meeting" type="text" name="year-of-birth" size=4 VALUE="19"> 
		<BR>
		<label for="meeting">Email:</label>
		<input type="text" id="email" name="EM" size=55 placeholder="Your email address ..." value="<?= $_POST["EM"] ?>">
		
		<label for="submit">
			<input type="submit" value="Verify your eligibility">
		</label>
	
	</FORM>
</div> 

</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>