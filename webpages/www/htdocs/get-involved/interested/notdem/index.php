<?php 
	date_default_timezone_set('America/New_York'); 
	require $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";		
?>

<div class="row">	
  <div class="main">
  	<P>
<h3>Sorry, we did find you in the Voter Database but you are not a Registered Democrat.</H3> 
Our database is current as of <B></B><?= date('F j<\S\U\P>S</\S\U\P>, Y', strtotime( $DatedFiles )) ?>.<BR></B>
	<A HREF="<?= $NYVoterRegistration ?>" TARGET="BOS">Check the Board of Election website</A>.
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
		<B><A HREF="../index.php?k=<?= $k ?>">Return to the previous page</A></B>
	</P>
</DIV>
</DIV>