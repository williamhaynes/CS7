<!-- Distinct login page for site - existing users-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events Form</title>
</head>

<body>
<?php
include ("scripts/header.php");
?>

<form action="../scripts/checkLogin.php" method="post">
    <input type="text" placeholder="User Name" name="userName">
    <input type="text" placeholder="Password" name="password">
    <input type="submit" value='Go Go Go!'>
</form>
<?php
include ("scripts/footer.php");
?>
</body>
</html>
