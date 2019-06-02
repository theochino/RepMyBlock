<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	$p = new maps();
	$GeoDescAbbrev = sprintf("%'.02d%'.03d", $AssemblyDistrict, $ElectionDistrict);
	$PicID = $p->FindGeoDiscID($GeoDescAbbrev);
?>

				  	
				  	
  <div class="side">
	<h1>ED<?= $ElectionDistrict ?> / AD<?= $AssemblyDistrict ?></H1>
  			
			  <div class="column" style="background-color:#fff;">
			   
					<P>
						<B><?= $ResultVoter["Raw_Voter_FirstName"] ?>
							 <?= $ResultVoter["Raw_Voter_MiddleName"] ?>
							 <?= $ResultVoter["Raw_Voter_LastName"] ?>
							 <?= $ResultVoter["Raw_Voter_Suffix"] ?></B>
					<BR>
						<?= $ResultVoter["Raw_Voter_ResHouseNumber"] ?>
						<?= $ResultVoter["Raw_Voter_ResFracAddress"] ?>
						<?= $ResultVoter["Raw_Voter_ResPreStreet"] ?>
						<?= $ResultVoter["Raw_Voter_ResStreetName"] ?>
						<?= $ResultVoter["Raw_Voter_ResPostStDir"] ?>
						<?= $ResultVoter["Raw_Voter_ResApartment"] ?><BR>
						<?= $ResultVoter["Raw_Voter_ResCity"] ?>, NY
						<?= $ResultVoter["Raw_Voter_ResZip"] ?>
					</P>
											
					<p><a target="_blank" class="district" href="showdistrict.php?GeoCodeID=<?= $PictureID ?>">
				  	<img id="myimage" src="<?= $PicURL ?>" alt="District">
					</a>
					</p>
			  </div>
			  
			  <?php //if (
							//		  $ResultVoter["Raw_Voter_CountyCode"] == 31 || $ResultVoter["Raw_Voter_CountyCode"] == 43 ||   // New York County and Richmond County
							//		  $ResultVoter["Raw_Voter_CountyCode"] == 3 || $ResultVoter["Raw_Voter_CountyCode"] == 24 || $ResultVoter["Raw_Voter_CountyCode"] == 41 // Bronx, Brooklyn, and Queens 
							//) { 
				?>
	</DIV>