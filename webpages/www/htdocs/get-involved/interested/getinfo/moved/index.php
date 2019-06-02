<?php 
	date_default_timezone_set('America/New_York'); 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<div class="row">	
  <div class="main">
  	<P>


		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>

<?php /*
		If you wish, before clicking below, let us know your new address.
		
		<div class="container">
		
			<FORM ACTION="" METHOD="POST">
			
				<INPUT TYPE="hidden" NAME="ED" VALUE="<?= $_GET["ED"] ?>">
				<INPUT TYPE="hidden" NAME="AD" VALUE="<?= $_GET["AD"] ?>">
				<INPUT TYPE="hidden" NAME="EMAIL" VALUE="<?= $_GET["EMAIL"] ?>">
				
				<label for="fname">Address</label>
				<input type="text" id="fname" name="FN" placeholder="Your name..">
				
				<label for="lname">Last Name</label>
				<input type="text" id="lname" name="LN" placeholder="Your last name..">
			
				
				<label for="submit">
					<input type="submit" value="Submit">
				</label>
			
			</FORM>
		
		</div> 
		*/ ?>


		<P>
			Check your registration with the Board of Election because our database date from <B><?= date('F j<\S\U\P>S</\S\U\P>, Y', strtotime( $DatedFiles )) ?>.</B>
		</P>
		
				 <P>
			 	 <BR>
			</P>

		
		<P>
			<A HREF="<?= $NYVoterRegistration ?>" class="btn default" target="boecheck">Check the State Board of Election website</A>
		</P>
 
		 <P>
			 	 <BR>
			</P>


		<P>
			You have several way to make the Department of Election aware you have moved.
		</P>
		
		 <P>
			 	 <BR>
			</P>
			  
		<P>
			
				<a href="https://voterreg.dmv.ny.gov/MotorVoter" class="btn success" target="dmv">I have a DMV ID</a>
			  <a href="https://www.elections.ny.gov/NYSVoterRegistrationFormEnglish.html" class="btn info" target="boe1">U.S. Postal Service</a>
			 </P>
			 <P>
			 	 <BR>
			  </P>

		<P>
				<a href="https://dmv.ny.gov/more-info/electronic-voter-registration-application" class="btn success" target="dmv">Instructions DMV</a>
			  <a href="http://www.elections.ny.gov/VotingRegister.html#VoteRegChange" class="btn info" target="boe1">Instructions DOE</a>

		</P>
			  	
	 <P>
			 	 <BR>
			  </P>			  			
			
		<P>
		<A HREF="/get-involved/interested/getinfo/?k=<?= encryptURL("UniqNYSID=" . $UniqNYSID) ?>" class="normal">Return to the previous page</A>
		</p>
</DIV>
</DIV>
	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>