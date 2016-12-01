<?
session_start();
/*
 * if there is a session cookie 'username' active then unset the following information
 * username: clear the cookie for the username
 * accessLevel: clear the cookie for the username
 * userID: clear the cookie for the username
 * 
 * Effectively logout of the current user
 */
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
    unset($_SESSION['accessLevel']);
    unset($_SESSION['userID']);
}

header("location:../clubsAndSocietiesPage");
?>