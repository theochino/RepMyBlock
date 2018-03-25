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

	<link rel="stylesheet" type="text/css" href="../maps.css">

		<div class="header">
		  <a href="#default" class="logo"><IMG SRC="/pics/OutragedDemLogo.png"></a>
		  <div class="header-right">
		    <a class="active" href="#home">Home</a>
		    <a href="#contact">Contact</a>
		    <a href="#about">About</a>
		  </div>
		</div> 

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>

		If you which, before clicking below, let us know your address.
		
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


		
		Check your registration with the Board of Election because our database date from may 15, 2017.
		
		
		<P>
			<A HREF="https://voterlookup.elections.state.ny.us" class="btn default" target="boecheck">Check the City Board of Election Website</A>
		</P>

		<BR>
	
		If you have moved, you have several way to make the Department of Election know you have moved.
		<BR>
		
		<P>
			
				<a href="https://voterreg.dmv.ny.gov/MotorVoter" class="btn success" target="dmv">I have a DMV ID</a>
			  <a href="https://www.elections.ny.gov/NYSVoterRegistrationFormEnglish.html" class="btn info" target="boe1">U.S. Postal Service</a>
			  
			  </P><BR>

		<P>
				<a href="https://dmv.ny.gov/more-info/electronic-voter-registration-application" class="btn success" target="dmv">Instructions DMV</a>
			  <a href="http://www.elections.ny.gov/VotingRegister.html#VoteRegChange" class="btn info" target="boe1">Instructions DOE</a>
		</P><BR>
			  	
			  			
			
		</P>
		<A HREF="" class="normal">Return to the previous page</A>
