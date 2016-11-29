<!--page header - hyperlinks for all pages go here-->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <title>header</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="/scripts/checkPasswordMatch.js"></script>
</head>
<body>
    <header>
        <nav id="navBar">
            <ul id="header">
                <li id="logo"><img id="logoIMG" src="https://pmcdeadline2.files.wordpress.com/2016/07/logo-tv-logo.png" alt="Logo"></li>
                <li id="healthAndWellbeing"><a href="../healthAndWellbeingPage">Health & Wellbeing</a></li>
                <li id="clubsAndSocieties"><a href="../clubsAndSocietiesPage">Clubs & Societies</a></li>
                <li id="mapPage"><a href="../mapPage">Maps</a></li>
                 <?php
                if (isset($_SESSION['username'])) {
                    echo "<li><a href='../logoutPage'>Logout</a></li>";
                    echo "<li><a href='../userDetailsPage'>My Account</a></li>";
                    if($_SESSION['accessLevel'] == 41){
                        echo "<li><a href='../userDetailsPage'>Club Admin Page</a></li>";
                        echo "<li><a href='../userDetailsPage'>User Admin Page</a></li>";
                    }
                } else {
                    echo "<li><a href='../loginPage'>Login</a></li>";
                    echo "<li><a href='../registerPage'>Register</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
