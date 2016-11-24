<!-- Distinct login page for site - existing users-->

<?php
include ("../scripts/header.php");
?>

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>

<body>


<form action="../scripts/checkLogin.php" method="post">
    <input type="text" placeholder="User Name" name="userName">
    <input type="password" placeholder="Password" name="password">
    <input type="submit" value='Login'>
</form>


</body>

<?
include ("../scripts/footer.php");
?>
<!--
<!DOCTYPE html>
<html lang="en">

</html>
-->