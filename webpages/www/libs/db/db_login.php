<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class login extends queries {

  function login ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
	function CheckEmail($email) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $email);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function CheckUsername($Username) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_username = :Username";
		$sql_vars = array(':Username' => $Username);											
		return $this->_return_simple($sql,  $sql_vars);
	}

	function AddEmail($email, $login_type = "password", $firstname = "", $lastname = "") {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email, SystemUser_loginmethod = :Type, SystemUser_createtime = NOW()";	
		$sql_vars = array(':Email' => $email, ':Type' => $login_type);
		
		if ( ! empty ($firstname)) { $sql .= ", SystemUser_FirstName = :FirstName";	$sql_vars[":FirstName"] = $firstname;	}
		if ( ! empty ($lastname)) {	$sql .= ", SystemUser_LastName = :LastName"; $sql_vars[":LastName"] = $lastname;	}
		
		$this->_return_nothing($sql,  $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		return $this->_return_simple($sql);
	}
		
	function UpdateSystemGoogleMapsApiKey($SystemUser_ID, $apikey) {
		$sql = "UPDATE SystemUser SET SystemUser_googleapimapid = :apikey WHERE SystemUser_ID = :ID";
		$sql_vars = array(':apikey' => $apikey, ':ID' => $SystemUser_ID);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function UpdateUsernamePassword($SystemUser_ID, $username, $password) {
		$sql = "UPDATE SystemUser SET SystemUser_username = :username, SystemUser_password = :password WHERE SystemUser_ID = :ID";
		$sql_vars = array(':username' => $username, ':password' => $password, ':ID' => $SystemUser_ID);
		return $this->_return_nothing($sql,  $sql_vars);
	}


}


?>
