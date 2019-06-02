<?php
	$BigMenu = "profile";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>

<div class="row">
	
  <div class="main">
    <h2>My Profile</h2>
      
		<A HREF="/get-involved/profile/change-password/?k=<?= $k ?>">Change Password</A><BR>
		<A HREF="/get-involved/profile/change-password/?k=<?= $k ?>">Change Personal Information</A>
		
		<?php
		/* 

    <h2>Candidate Information</h2>
      
		<A HREF="/get-involved/profile/upload-picture/?k=<?= $k ?>">Change Picture</A><BR>
		<A HREF="/get-involved/profile/public-information/?k=<?= $k ?>">Change Public Information</A><BR>
   
     */ 
     ?>
  </div>
  
   
  
  
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>