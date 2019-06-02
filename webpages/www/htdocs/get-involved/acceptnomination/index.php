<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	
	// This is required for any jump to another internal site inside domain.
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	
	$p = new OutragedDems();
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>

<div class="row">
	<div class="main">
			<FORM METHOD="POST" ACTION="">
		
		<h1>Nominations</H1>

		<H3><?= $FirstName ?></H3>

		<P>
			You have been nominated for the positions of XXXXX by XYZ. They think you would be interested
			in getting implicated on local politics.
		</P>
		
		<P>
			This 3 minutes video explain what how the local party is organized and XYZ think you should be part of it.
		</P>
		
		<P>
			<UL>
				<iframe width="560" height="315" src="https://www.youtube.com/embed/MnI7iBxCN4A?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</UL>
		</P>
		
			</DIV>

</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>