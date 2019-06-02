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
	
	function CandidatePetition($PetitionSetID) {
		$sql = "SELECT * FROM PetitionSet " .
						"LEFT JOIN CandidatePetitionSet ON (PetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " . 
						"LEFT JOIN CandidatePetition ON (CandidatePetition.CandidatePetition_ID = PetitionSet.CandidatePetition_ID) " .
						"WHERE CandidatePetitionSet.CandidatePetitionSet_ID = :CandPetitionSetID AND CandidatePetition_SignedDate IS NULL " .
						"ORDER BY PetitionSet_Order";
		$sql_vars = array("CandPetitionSetID" => $PetitionSetID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CandidateInformation($CandidateID) {
		$sql = "SELECT * FROM Candidate WHERE Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $CandidateID);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	// This is base on SYstemUser
	function ListCandidatePetition($SystemUserID, $Status = "published") {
		$sql = "SELECT * FROM CandidatePetitionSet " .
						"LEFT JOIN CanPetitionSet ON (CanPetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE CandidatePetitionSet.SystemUser_ID = :SystemUserID AND Candidate_Status = :Status " .
						"ORDER BY CandidateElection_DisplayOrder, CanPetitionSet.Candidate_ID";
		$sql_vars = array("SystemUserID" => $SystemUserID, "Status" => $Status);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	// This is base on candidate_ID
	function ListCandidate($Candidate_ID, $Status = "published") {
		
		$sql = "SELECT * FROM Candidate " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE Candidate.Candidate_ID = :CandidateID AND Candidate_Status = :Status " .
						"ORDER BY CandidateElection_DisplayOrder";
		$sql_vars = array("CandidateID" => $Candidate_ID, "Status" => $Status);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	
	function ListVoterCandidate($Candidate_ID) {
		$sql = "SELECT * FROM CandidatePetition where Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $Candidate_ID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}

?>
