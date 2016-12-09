<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include("/../scripts/dbconnect.php");
        $locationID = $params['locationID'];

    }
}
?>