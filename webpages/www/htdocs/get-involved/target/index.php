<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$BigMenu = "represent";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	
	if ( $SystemUser_ID > 0 ) {
	
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
		
		$r = new voterlist();
	

		$result = $r->CheckRawVoterID($SystemUser_ID);	
		$resultRaw = $r->FindLocalRawVoterFromDatedFile($result["Raw_Voter_ID"], $DatedFiles);
	
		$FindVoterID = $r->FindRawVoterbyRawVoterID($DatedFiles, $resultRaw["Raw_Voter_TableDate_ID"]);			
		$County = $r->GetCountyFromNYSCodes($FindVoterID["Raw_Voter_CountyCode"]);
		
		$EDAD = str_pad($FindVoterID["Raw_Voter_AssemblyDistr"], 2, '0', STR_PAD_LEFT) . 
						str_pad($FindVoterID["Raw_Voter_ElectDistr"], 3, '0', STR_PAD_LEFT);
		$ResultElection = $r->FindElectionIDforEDAD($EDAD);			

		$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID;
		//header("Location: /get-involved/list/displayvoters/?k=" . EncryptURL($URLToEncrypt));
		//exit();
		
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
	
?>

<div class="row">
	
	<div class="side">
    <h2>ED<?= $ElectionDistrict ?>/AD<?= $AssemblyDistrict ?></h2>
    <div class="fakeimg" style="height:240px;"><IMG SRC="https://static.outrageddems.nyc/maps/56/Img-5676.jpg" height=200></div>
    <p>
    	Stats: <?= $CountDemocrats ?> Democrats<BR>
    	Signed petitions<BR>
    	Day Left: <?= $LastDayPetiton ?>
    </P>
  
  </div>
   <div class="main">

		<FORM ACTION="" METHOD="POST">
		<h2>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H2>
			
		
		
		</FORM>
	
		<A HREF="/get-involved/list/?k=<?= EncryptURL("SystemUser_ID=" . $SystemUser_ID) ?>">Return to previous screen</A>
	</div>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>