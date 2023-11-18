<?php
$UID = "tolvukarlis";
$PWD = "ySZ5kua7";
$DefaultDB = "wp-tolvukarl";
$DBServerName = "localhost";
$strRemoteIP = $_SERVER["REMOTE_ADDR"];
$dbh= new mysqli ($DBServerName, $UID, $PWD, $DefaultDB);
if ($dbh->connect_errno)
{
    error_log( "Failed to connect to MySQL. Error(" . $dbh->connect_errno . ") " . $dbh->connect_error);
    exit;
}
?>

