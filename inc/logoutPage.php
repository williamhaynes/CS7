<?
session_start();
if (isset($_SESSION['username'])) {
    //Unset all session
    session_unset();
}

header("location:../clubsAndSocietiesPage");
?>