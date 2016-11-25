<!-- Distinct register page for site - new users-->

<?php
include ("../scripts/header.php");
?>

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="../scripts/checkPasswordMatch.js"></script>
</head>

<body>


<form action="../scripts/registerUser.php" method="post">
    <input type="text" placeholder="User Name" name="userName">
    <input type="text" placeholder="Email Address" name="emailAddress">
    <input type="text" placeholder="Display Name" name="displayName">
    <input type="password" placeholder="Password" id="firstPassword" name="password">
    <input type="password" placeholder="Confirm Password" id="secondPassword" onchange="checkPasswordMatch();" name="confirmPassword">
    <input type="submit" value='Go Go Go!'>
</form>


</body>

<?
include ("../scripts/footer.php");




?>