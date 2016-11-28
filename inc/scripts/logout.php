<?php
session_start();
if (isset($_SESSION['username'])) {
    unset
    ($_SESSION['username']);
}
else{
    //do nothing
}
header("location:../clubsAndSocietiesPage.php")
;
?> 