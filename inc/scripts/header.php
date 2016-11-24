<!--page header - hyperlinks for all pages go here-->
<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <title>header</title>
</head>
<body>
    <header>
        <nav id="navBar">
            <ul id="header">
                <li id="logo"><img id="logoIMG" src="https://pmcdeadline2.files.wordpress.com/2016/07/logo-tv-logo.png" alt="Logo" style="width:304px;height:228px;"></li>
                <li id="healthAndWellbeing"><a href="/inc/healthAndWellbeing.php">Health & Wellbeing</a></li>
                <li id="clubsAndSocieties"><a href="/inc/clubsAndSocietiesPage.php">Clubs & Societies</a></li>
                <li id="mapPage"><a href="/inc/mapPage.php">Maps</a></li>
                <!-- Code that could be useful for specific users
                 <?
                if (isset($_SESSION['username'])) {
                    echo "<li><a href='createarticle'>Create Article</a></li>";
                    echo "<li><a href='logout'>Logout</a></li>";
                } else {
                    echo "<li><a href='login'>Login</a></li>";
                }
                ?>-->
            </ul>
        </nav>
    </header>
</body>