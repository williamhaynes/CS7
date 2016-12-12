<!--Header on each web page, all hyperlinks for all pages also go here -->
<?php
session_start(); //start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <title>Portlethen Go</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
    <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
    <script type="text/javascript">
        window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website, cookies are used to help you navigate the site once you're logged in.","dismiss":"Got it!","learnMore":"More info","link":null,"theme":"dark-top"};
    </script>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
    <!-- End Cookie Consent plugin -->

</head>
<body style="background-image:url(../../style/background.jpg)">
    <header>
        <nav id="navBar">
            <ul id="header">
                <li id="logo"><img id="logoIMG" src="../../style/logo.png" alt="Logo"></li>
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
                        echo "<li><a href='/healthAndWellBeingAdminPage'>Article Admin Page</a></li>";
                        echo "<li><a href='/mapAdminPage'>Map Admin Page</a></li>";
                    }
                    if($_SESSION['accessLevel'] == 11){
                        /*
                         * If the user is logged in and they have an access level of 11 then the following buttons will be displayed
                         * mapAdminPage: the map admin page displaying information of map markers
                         */
                        echo "<li><a href='/mapAdminPage'>Map Admin Page</a></li>";
                    }
                    echo "<li><a href='/userDetailsPage/". $_SESSION['userID'] ."'>My Account</a></li>";
                    echo "<li id='logoutButton'><a href='/logoutPage'>Logout</a></li>";
                } else {
                    /*
                     * if there is no cookie found called 'username' there is no one logged in and the following buttons are displayed
                     * Login: to login to their account
                     * Register: Allow them to register
                     */
                    echo "<li id='loginButton'><a href='/loginPage'>Login</a></li>";
                    echo "<li id='registerButton'><a href='/registerPage'>Register</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
