<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class maps extends queries {

  function maps ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
	function InsertEmail($email) {
		$sql = "INSERT INTO Email SET Email_Txt = :Email";	
		$sql_vars = array(':Email' => $email);											
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function CountRawVoterbyADED($DatedFiles, $ADist, $EDist, $Party = "BLK") {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT COUNT(*) as TotalVoters FROM " . $TableVoter . " WHERE " . 
		"Raw_Voter_AssemblyDistr = :AssDist AND Raw_Voter_ElectDistr = :ElectDist " . 
		"AND Raw_Voter_EnrollPolParty = :Party AND Raw_Voter_Status = 'ACTIVE'";	
		$sql_vars = array('AssDist' => $ADist, 'ElectDist' => $EDist, 'Party' => $Party);							
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function FindRawVoterbyADED($DatedFiles, $EDist, $ADist) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE " . 
		"Raw_Voter_AssemblyDistr = :AssDist AND Raw_Voter_ElectDistr = :ElectDist ";
		$sql_vars = array('AssDist' => $ADist, 'ElectDist' => $EDist);							
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindRawVoterbyRawVoterID($DatedFiles, $RawVoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('Raw_Voter_ID' => $RawVoterID);							
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function FindGeoDiscID($GeoDescAbbrev) {
		$sql = "SELECT * FROM GeoDesc WHERE GeoGroup_ID = '3' AND GeoDesc_Abbrev = :Abbrev";
		$sql_vars = array('Abbrev' => $GeoDescAbbrev);							
		return $this->_return_simple($sql, $sql_vars);
	}

}

?>
