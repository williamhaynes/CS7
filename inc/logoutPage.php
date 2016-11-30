<?
session_start();
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    unset($_SESSION['accessLevel']);
    unset($_SESSION['userID']);

    //Unset all session
    //session_unset();
}

header("location:../clubsAndSocietiesPage");
?>