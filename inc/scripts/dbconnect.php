//php file to connect to server

<?php
define('DB_SERVER', 'us-cdbr-azure-southcentral-f.cloudapp.net');
define('DB_USERNAME', 'b21eaed643e4cb');
define('DB_PASSWORD', '4756773b');
define('DB_DATABASE', 'wjh0001db');
$db = mysqli_connect(DB_SERVER,
    DB_USERNAME, DB_PASSWORD,
    DB_DATABASE);
?>