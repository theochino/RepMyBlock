<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST)) {
		$URL = "checkinfo.php?k=" . EncryptURL("ED=" . $_POST["ED"] . "&AD=" . $_POST["AD"] . "&Email=" . $_POST["Email"] .
								 "&FirstName=" . $_POST["FN"] . "&LastName=" . $_POST["LN"] . "&DOB=" . $_POST["DOB"]);						 
		header("Location: $URL");	
		exit();
	}
	
?>


<link rel="stylesheet" type="text/css" href="../maps.css">

<div class="header">
  <a href="#default" class="logo"><IMG SRC="/pics/OutragedDemLogo.png"></a>
  <div class="header-right">
    <a class="active" href="#home">Home</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a>
  </div>
</div> 


<UL>


I am interested to sign someone else petition.

<BR><BR>

<P>
	We have our own copy of the whole New York State database 
</P>

<STRONG>We need to look you up in the voter database.<BR>
	Are you a New York State Registered voter in the Democratic Party in order to sign a petition</STRONG>
<P>
What is your first name, last name, and date of birth ?

</UL>

<div class="container">

	<FORM ACTION="" METHOD="POST">
	
		<INPUT TYPE="hidden" NAME="ED" VALUE="<?= $_GET["ED"] ?>">
		<INPUT TYPE="hidden" NAME="AD" VALUE="<?= $_GET["AD"] ?>">
		<INPUT TYPE="hidden" NAME="EMAIL" VALUE="<?= $_GET["EMAIL"] ?>">
		
		<label for="fname">First Name</label>
		<input type="text" id="fname" name="FN" placeholder="Your name..">
		
		<label for="lname">Last Name</label>
		<input type="text" id="lname" name="LN" placeholder="Your last name..">
		
		<label for="meeting">Date of Birth:</label>
		<input id="meeting" type="date" name="DOB"> 
		
		<label for="submit">
			<input type="submit" value="Submit">
		</label>
	
	</FORM>

</div> 