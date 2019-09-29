<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php"; 	
	
	
	/* User is logged */
	if ( $MenuLogin == "logged") {
?>
<div class="main">

	<P>
		This is the Home Menu when logged with information about the program and some stats.
	</P>

	<P>
		
	<a href="/get-involved/list/?k=<?= $k ?>">I am interested in running for County Committee.</a><BR>
  <a href="/get-involved/nominate/?k=<?= $k ?>">I am not interested in running but I want to nominate a candidate in my district by singing a petition.</a>
	</P>
	
	<P>
		You nominated XXX to run for the following positions.
		<BR>
		XY1  == Have not accepted the nomination for <BR>
		HJ   == Accepted the nomination for<BR>
	</P>
	
	
 </DIV>

<?php		
	// User is not logged
	} else { 
	
?>

<div class="main">
	<P CLASS="BckGrndCenter">I WANT TO</P>

	<DIV>
		<A class="action-runfor" HREF="interested" CLASS="RunCC"><img class="action-runfor" src="/pics/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-nominate" HREF="propose" CLASS="NomCandidate"><img class="action-nominate" src="/pics/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>
<?php /*
	<P CLASS="BlueBox">
		<A HREF="interested" class="w3-button w3-bar-item w3-blue w3-hover-text-red BlueBox">ACT NOW! PETITIONING RUNS FROM<BR>FEBRUARY 26 TO APRIL 4, 2019.</a>
	</P>
*/?>
	<P CLASS="BckGrndElement">HOW IT WORKS</P>

	<P>
		<B>The County Committee is the most basic committee of any New York party; it's their backbone.</B>
	</P>
	
	<P>	
		The County Committee is the most basic committee of any New York party; it's the backbone because it selects the local platform and 
		the candidates that will represent our values. Many registered Democrats dont even know its existence. 
		It's the body that validates the party backroom deals. 
	</P>
	
	<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/MnI7iBxCN4A?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>

	<P>
		<B>The time commitment is about 40 hours a year.</B>
	</P>

</div>

<?php } ?>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>