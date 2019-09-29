<?php 
	$BigMenu = "represent";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$DOBYEAR = "19";
	$DOBDAY = "";
	$DOBMONTH = 1;

	if ( ! empty ($_POST)) {  
		if ( empty ($_POST["LN"]) || empty ($_POST["FN"])) {
			$error_msg = "<B><FONT COLOR=RED>Please enter your name.</FONT></B>";
		} else if ( empty ($_POST["year-of-birth"]) || empty ( $_POST["month-of-birth"]) || empty ($_POST["day-of-birth"])) {
	  	$error_msg = "<B><FONT COLOR=RED>Please enter your date of birth.</FONT></B>";
	  } else {
		  $DOB = $_POST["year-of-birth"] . "-" . $_POST["month-of-birth"] . "-" . $_POST["day-of-birth"];
		  if ( checkdate ( $_POST["month-of-birth"] ,  $_POST["day-of-birth"] , $_POST["year-of-birth"]) == 1) {
				$URL = "checkinfo.php?k=" . EncryptURL("FirstName=" . $_POST["FN"] . "&LastName=" . $_POST["LN"] . "&DOB=" . $DOB . "&Email=" . $_POST["EM"]);						 
				header("Location: $URL");	
				exit();
			}
			$error_msg = "<B><FONT COLOR=RED>Please check the date of birth as it seems incorrect.</FONT></B>";
		}
	}
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
	
	if ( ! empty ($DOB)) {
		$ParsedDOB = strtotime( $DOB );
		$DOBYEAR = date('Y', $ParsedDOB);
		$DOBDAY = date('d', $ParsedDOB);
		$DOBMONTH = date('n', $ParsedDOB);
	}
	
?>
<div class="main">

<P>
	<H1>Run for County Committee!</H1>
</P>
		
<P>
	<B>The first step in being your party block representative is to verify your voter registration.</B><BR>
	
</P>

<P>
	<A HREF="<?= $FrontEndWebsite ?>/county-committee">This link explains in more detail the role of the County Committee</A>.
</P>

<?php if (! empty ($error_msg)) { ?>
<P>
	<?= $error_msg ?>
</P>
<?php } ?>

<div class="container">
	<FORM ACTION="" METHOD="POST">

		<label for="fname">First Name</label>
		<input type="text" id="fname" name="FN" value="<?= $FN ?>" placeholder="Your name ...">
		
		<label for="lname">Last Name</label>
		<input type="text" id="lname" name="LN" value="<?= $LN ?>" placeholder="Your last name ...">
		<BR>
		<label for="meeting">Date of Birth:</label>
		<input id="meeting" type="text" name="day-of-birth" size=2 value="<?= $DOBDAY ?>">
		<SELECT id="meeting" name="month-of-birth"> 
		    <OPTION VALUE="01"<?php if ($DOBMONTH == 1) { echo " SELECTED"; } ?>>January</OPTION>
		    <OPTION VALUE="02"<?php if ($DOBMONTH == 2) { echo " SELECTED"; } ?>>February</OPTION>
		    <OPTION VALUE="03"<?php if ($DOBMONTH == 3) { echo " SELECTED"; } ?>>March</OPTION>
		    <OPTION VALUE="04"<?php if ($DOBMONTH == 4) { echo " SELECTED"; } ?>>April</OPTION>
		    <OPTION VALUE="05"<?php if ($DOBMONTH == 5) { echo " SELECTED"; } ?>>May</OPTION>
		    <OPTION VALUE="06"<?php if ($DOBMONTH == 6) { echo " SELECTED"; } ?>>June</OPTION>
		    <OPTION VALUE="07"<?php if ($DOBMONTH == 7) { echo " SELECTED"; } ?>>July</OPTION>
		    <OPTION VALUE="08"<?php if ($DOBMONTH == 8) { echo " SELECTED"; } ?>>August</OPTION>
		    <OPTION VALUE="09"<?php if ($DOBMONTH == 9) { echo " SELECTED"; } ?>>September</OPTION>
		    <OPTION VALUE="10"<?php if ($DOBMONTH == 10) { echo " SELECTED"; } ?>>October</OPTION>
		    <OPTION VALUE="11"<?php if ($DOBMONTH == 11) { echo " SELECTED"; } ?>>November</OPTION>
		    <OPTION VALUE="12"<?php if ($DOBMONTH == 12) { echo " SELECTED"; } ?>>December</OPTION>
		</SELECT>
		<input id="meeting" type="text" name="year-of-birth" size=4 VALUE="<?= $DOBYEAR ?>"> 
		<BR>
		<label for="meeting">Email:</label>
		<input type="text" id="email" name="EM" size=55 placeholder="Your email address ..." value="<?= $Email ?>">
		
		<label for="submit">
			<input type="submit" value="Verify your eligibility">
		</label>
	
	</FORM>
</div> 

<P>
<I>Each month we request  the complete New York State voter registration file using the Freedom of Information Law.<BR>
			<B>We ask for your date of birth in order to find your individual voting record.</B></I>
</P>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>