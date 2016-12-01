<!-- php file to connect to server -->

<?php
/*
 * Connect to your Azure server and select database
 * Your connection details are all on the azure portal
 */
$db = new mysqli(
    "eu-cdbr-azure-north-e.cloudapp.net", //Server Name
    "b1fa144aa688ff", //Username
    "4e96e436",
    "db_pgo_cs7" ); //Database
/*
 * If database fails to connect - error message displays
 */
if ($db->connect_errno){
    die ('Connection Failed :'.$db->connect_error);
}
?>