<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class OutragedDems extends queries {

  function OutragedDems ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
     
	function FindRawVoterbyID($DatedFiles, $VoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM :TableVoter WHERE Raw_Voter_ID = :VoterID";	
		$sql_vars = array('TableVoter' => $TableVoter, 'VoterID' => $VoterID);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function FindRawVoterbyADED($DatedFiles, $EDDist, $ADDist) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_AssemblyDistr = :AssDist AND Raw_Voter_ElectDistr = :EleDist";	
		$sql_vars = array('AssDist' => $ADDist, 'EleDist' => $EDDist);							
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function CandidatePetition($CandidateID) {
		$sql = "SELECT * FROM CandidatePetition WHERE Candidate_ID = :Candidate ORDER BY CandidatePetition_Order";
		$sql_vars = array('Candidate' => $CandidateID);							
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}

?>
