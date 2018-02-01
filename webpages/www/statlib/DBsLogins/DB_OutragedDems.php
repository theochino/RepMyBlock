<?php
// Make sure to include a .gitignore as to not commit your database password.

$databasename = "<DATABASE NAME>";
$databaseserver = "<DATABASE HOST>";
$databaseport = 3306;
$databaseuser = "<USERNAME>";
$databasepassword = "<PASSWORD>";

$DBErrorsFilename = "/tmp/DBErrors_" . $_SERVER["SERVER_ADDR"] . ".txt";

$sslkeys["srvkey"] = $_SERVER["DOCUMENT_ROOT"] . "<PATH TO SSL KEYS>/client-mysql-key.pem";
$sslkeys["srvcert"] = $_SERVER["DOCUMENT_ROOT"] . "<PATH TO SSL KEYS>/client-mysql-cert.pem";
$sslkeys["srvca"] = $_SERVER["DOCUMENT_ROOT"] . "<PATH TO SSL KEY>/ca-mysql-cert.pem";
?>
