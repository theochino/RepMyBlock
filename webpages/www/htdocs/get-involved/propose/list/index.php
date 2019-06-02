<?php 
	$BigMenu = "nominate";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_stats.php";	
	
	$r = new stats();
	$result = $r->CandidatePetitions();

	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<div class="main">
	
<P>
	<h2>Report on the number of candidates for each AD and ED</H2>
</P>

<P>
	If you would like to represent your block, <B><A HREF="/get-involved/interested">check the requirements for your area here</A></B>
</P>

<div class="container">
		
		<CENTER>
		<TABLE BORDER=1>
			<TR>
				<TH>Candidate Name</TH>
				<TH>Position</TH>
				<TH>District Name</TH>
				<TH>Website</TH>
				<TH>Petition</TH>
			</TR>
			
<?php	
		if ( ! empty ($result)) {
			foreach ($result as $var) {
				if ( $var["Candidate_Status"] == "published") {		
?>					
					<TR ALIGN=CENTER>
						<TD><?= $var["Candidate_DispName"] ?></TD>
						<TD><?= $var["CandidateElection_Text"] ?></TD>
						<TD><?= $var["CandidateElection_DBTable"] ?></TD>
						<TD><a target="_blank" class="district" href="<?= $var["Candidate_StatementWebsite"] ?>" TARGET="Website"><?= $var["Candidate_StatementWebsite"] ?></a></TD>
						<TD><a target="_blank" class="district" href="<?= $FrontEndPDF . "/candidate/?k=" . EncryptURL("Candidate_ID=" . $var["Candidate_ID"] ) ?>">Download</a></TD>
					</TR>
				

<?php				
				}
			}
		}
?>
			
			
		</CENTER>
			
		</TABLE>

		
	
	
</div> 


<P>
	If you would like to nominate a person not in that list, <B><A HREF="/get-involved/propose">propose someone.</A></B>
</P>

</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>

