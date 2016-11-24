<!-- Distinct register page for site - new users-->

<?php
include ("../scripts/header.php");
?>

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>

<body>


<form action="../scripts/registerUser.php" method="post">
    <input type="text" placeholder="User Name" name="userName">
    <input type="text" placeholder="Email Address" name="emailAddress">
    <input type="text" placeholder="Display Name" name="displayName">
    <input type="password" placeholder="Password" name="password">
    <input type="password" placeholder="Confirm Password" name="confirmPassword">
    <input type="submit" value='Go Go Go!'>
</form>


</body>

<?
include ("../scripts/footer.php");
?>