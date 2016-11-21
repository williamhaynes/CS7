//php file to connect to server

<?php
define('DB_SERVER', 'eu-cdbr-azure-north-e.cloudapp.net');
define('DB_USERNAME', 'b1fa144aa688ff');
define('DB_PASSWORD', '4e96e436');
define('DB_DATABASE', 'db_pgo_cs7');
$db = mysqli_connect(DB_SERVER,
    DB_USERNAME, DB_PASSWORD,
    DB_DATABASE);
?>