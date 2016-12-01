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
    <?
    echo "<script type=\"text/javascript\" src='";
    include(__DIR__ . "/../scripts/checkPasswordMatch.js");
    echo "'></script>";
    ?>
    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
</head>
<body>
    <header>
        <nav id="navBar">
            <ul id="header">
                <li id="logo"><img id="logoIMG" src="https://pmcdeadline2.files.wordpress.com/2016/07/logo-tv-logo.png" alt="Logo"></li>
                <li id="healthAndWellbeing"><a href="/healthAndWellbeingPage">Health & Wellbeing</a></li>
                <li id="clubsAndSocieties"><a href="/clubsAndSocietiesPage">Clubs & Societies</a></li>
                <li id="mapPage"><a href="/mapPage">Maps</a></li>
                 <?php
                 /*
                  * If the session cookie 'username' is found then the following buttons will be displayed
                  * Logout:  which will allow the user to logout
                  * My Account: the page that has all the details of the user
                  */
                if (isset($_SESSION['username'])) {
                                        if($_SESSION['accessLevel'] == 31){
                        /*
                         * If the user is logged in and they have an access level of 31 then the following buttons will be displayed
                         * User Admin Page: the user admin page displaying information on the site
                         */
                        echo "<li><a href='/usersAdminPage'>User Admin Page</a></li>";
                    }
                    echo "<li><a href='/userDetailsPage'>My Account</a></li>";
                    echo "<li id='logoutButton'><a href='/logoutPage'>Logout</a></li>";
                } else {
                    /*
                     * if there is no cookie found called 'username' then they is no one logged in and the following buttons are displayed
                     * Login: to login to their account
                     * Register: Allow them to register to a club
                     */
                    echo "<li id='loginButton'><a href='/loginPage'>Login</a></li>";
                    echo "<li id='registerButton'><a href='/registerPage'>Register</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
