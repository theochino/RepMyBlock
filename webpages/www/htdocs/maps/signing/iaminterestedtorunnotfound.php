<?php 
	date_default_timezone_set('America/New_York'); 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	
	$GoogleMapKeyID = "AIzaSyDDYjTlFL3rPZMZN6TGFqWBGrp2aRxoO5c"; 
	
	$ElectionDistrict = $_GET["ED"];
	$AssemblyDistrict = $_GET["AD"];
	$UserEmail = $_GET["EMAIL"];
	$FirstName = $_GET["FN"];
	$LastName = $_GET["LN"];
	$DateOfBirth = $_GET["DOB"];	
	$DatedFiles = "20170515";

?>
<IMG SRC="https://www.outrageddems.nyc/word/wp-content/uploads/2018/01/cropped-OD-Logo_3.png">
<BR><BR>
<STRONG>Sorry, we did not find you in the Voter Database.<BR> Our database is current as of May 15, 2017.<BR>
	If you had a change, like recently moved to New York State or changed your registration.
	Are you a New York State Registered voter in the Democratic Party ?</STRONG>
<P>
	<A HREF="https://voterlookup.elections.state.ny.us" TARGET="NEW">Check the City Board of Election Poll</A>
</P>
		
If you allow us, we can automatiquelly query the NYS Voter Database and import the data.		

<FORM ACTION="" METHOD="POST">
	<DIV NAME="County">County: <INPUT TYPE="TEXT" NAME="County"></DIV>
	<DIV NAME="ZipCode">Zipcode: <INPUT TYPE="TEXT" NAME="ZipCode"></DIV>
	<DIV NAME="ZipCode"><INPUT TYPE="SUBMIT" NAME="SubmitEmail" VALUE="Get Information"></DIV>
</FORM>	
	
</P>

This is the end of one loop.
