<!-- php file to connect to server -->

<?php

// connect to your Azure server and select database (remember you connection details are all on the azure portal
$db = new mysqli(
    "eu-cdbr-azure-north-e.cloudapp.net",
    "b1fa144aa688ff",
    "4e96e436",
    "db_pgo_cs7" );

if ($db->connect_errno){
    die ('Connection Failed :'.$db->connect_error);
}
?>