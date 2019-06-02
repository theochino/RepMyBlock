<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/mysql.php";

class queries {

  function queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo) {

  	if ( $DebugInfo["Flag"] > 0 ) {
  		echo "<BR><FONT COLOR=GREEN><I><B>Database: Server:</B> $databaseserver - <B>Name:</B> $databasename</I></FONT><BR>";
		}  	
	
  	$this->DebugInfo = $DebugInfo;
    $this->DB = new DB();    
    $this->DB->open($databasename, $databaseserver, $databaseport, 
                    $databaseuser, $databasepassword, $sslkeys, $DebugInfo);                    
  }

	// Function has been changed to the same because
	// I am using Mysql PDO instead of the PHP Mysql 
	// That has been deprecated.
	// 04/05/2014 - Theo
	
  function _return_multiple($SQL, $SQL_Vars = "") {
		$result = $this->DB->query($SQL, $SQL_Vars, 1, $this->DebugInfo);
	  return $this->_compress_result($result); 
  }
  
  function _return_simple($SQL, $SQL_Vars = "") {
  	$result = $this->DB->query($SQL, $SQL_Vars, 1, $this->DebugInfo);
    $result = $this->_compress_result($result);
    return $result[0]; 
  }
  
  function _return_nothing($SQL, $SQL_Vars = "") {
  	$this->DB->query($SQL, $SQL_Vars, 0, $this->DebugInfo);
    return;
  }
  
  function _compress_result($result) {

  	unset($newresult);  
  	$i = 0;
  		
  	if ( ! empty($result)) {
	  	foreach ($result as $index => $PremStag) {
	  		if ( ! empty ($PremStag)) {
	  			if ( is_array ($PremStag)) {
		  			foreach ($PremStag as $index => $DeuxStag) {
		 					if ( is_array($DeuxStag)) {
	 							$DeuxStag =  array_unique($DeuxStag, SORT_LOCALE_STRING);
	 						
		 						if ( (count($DeuxStag) == 1) || (count($DeuxStag) == 2 && empty ($DeuxStag[1]))) {
									$newresult[$i][$index] = $DeuxStag[0];
								} else {
									$newresult[$i][$index] = "*** SEVERAL ***";
								}
							} else {
								$newresult[$i][$index] = $DeuxStag;
							}
						}
					}
				}
				$i++;
			}
		}
				
  	unset ($result);
  	return $newresult;
  }
  
  /*
  // Function to print selected coluns in the Db 
  function _print_cols() {
		$first_time = 0;
		
		if ( ! empty ($this->distinct)) {
			$return_var = "DISTINCT ";
		} else {
			$return_var = "";
		}
		
		if ( ! empty ($this->cols)) {
			foreach ($this->cols as $var) {
				if ( ! empty ($var)) {
					if ( $first_time != 0 ) {	
						$return_var .= ", ";
					} else {
						$first_time = 1;
					}
					$return_var .= $var;
				}
			}
		}	else {	
			$return_var = "*";
		}
		
		return $return_var;
	}
	
	function _print_sorts() {
		$first_time = 0;
		$return_var = "ORDER BY ";
		
		if ( ! empty ($this->sorts)) {
			foreach ($this->sorts as $var) {
				if ( ! empty ($var)) {
					if ( $first_time != 0 ) {	
						$return_var .= ", ";
					} else {
						$first_time = 1;
					}
					$return_var .= $var;
				}
			}
		}	else {	
			$return_var = "*";
		}
		
		return $return_var;
	}
	*/
}
/// MAKE SURE THERE IS NOTHING AT THE END OTHERWISE THE COOKIE DOES NOT GET SET !!!
?>
