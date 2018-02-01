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
  
	function InsertEmail($email) {
		$sql = "INSERT INTO Email SET Email_Txt = :Email";	
		$sql_vars = array(':Email' => $email);											
		return $this->_return_nothing($sql,  $sql_vars);
	}

	function SearchVoterDB($DatedFiles, $FirstName, $LastName, $DOB) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE " . 
		"Raw_Voter_LastName= :LastName AND Raw_Voter_FirstName = :FirstName AND Raw_Voter_DOB = :DOB";
		$sql_vars = array('FirstName' => $FirstName, 'LastName' => $LastName, 'DOB' => $DOB);							
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	
	function FindGeoDiscID($GeoDescAbbrev) {
		$sql = "SELECT * FROM GeoDesc WHERE GeoGroup_ID = '3' AND GeoDesc_Abbrev = :Abbrev";
		$sql_vars = array('Abbrev' => $GeoDescAbbrev);							
		return $this->_return_simple($sql, $sql_vars);
	}

}

?>
