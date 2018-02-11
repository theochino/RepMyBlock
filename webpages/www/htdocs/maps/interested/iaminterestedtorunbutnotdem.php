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
<STRONG>Sorry, we did find you in the Voter Database but you are not a Registered Democrat.<BR> 
Our database is current as of May 15, 2017.<BR></STRONG>
<P>
	<A HREF="https://voterlookup.elections.state.ny.us" TARGET="NEW">Check the City Board of Election Poll</A>
</P>


<H2>If you would like to change your party registration.</H2>
<UL>
	The voter registration form should be used to change your party enrollment from one party to 
	another or to enroll for the first time in a party. A change of enrollment received no later than 25 days 
	before the general election shall be deposited in a sealed enrollment box and opened the first Tuesday 
	following that general election and entered in the voter's registration record. Please see Deadlines 
	referenced above.
</UL>

<P>
	If you would like to change your party registration and you have a <B>New York State DMV issued</B> driver 
	license, permit or Non-Driver ID, you can use the DMV electronic voter registration application.
	<A HREF="https://dmv.ny.gov/more-info/electronic-voter-registration-application" TARGET="NEW">https://dmv.ny.gov/more-info/electronic-voter-registration-application</A>
</P>

<P>If you can't use the DMV electronic system, you can also complete the form online, download the PDF, print the PDF and mail it to the Department of Election
<A HREF="http://www.elections.ny.gov/VotingRegister.html#VoteRegChange" TARGET="NEW">http://www.elections.ny.gov/VotingRegister.html#VoteRegChange</A>
</P>

<P>
	<B>If you want to run for the county committee of the party you are registered</B>, check Non Partisan County Committee website: 
	<A HREF="https://ccsunlight.org/about">https://ccsunlight.org</A>
</P>
	
	<P>
		<A HREF="/maps">Return to main page</A>
	</P>

This is the end of one loop.
