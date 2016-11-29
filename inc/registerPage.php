<!-- Distinct register page for site - new users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
include ("scripts/header.php");
?>


<main>
    <form action="registerUser" method="post">
        <input type="text" placeholder="User Name" name="username">
        <input type="text" placeholder="Email Address" name="emailAddress">
        <input type="text" placeholder="Display Name" name="displayName">
        <input type="password" placeholder="Password" id="firstPassword" name="password">
        <input type="password" placeholder="Confirm Password" id="secondPassword" onchange="checkPasswordMatch()" name="confirmPassword">
        <p><input type="submit" value='Register'></p>
    </form>
</main>

<?
include ("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("scripts/dbconnect.php");

    //Variables
    $username = $_POST['username'];
    $emailAddress = $_POST['emailAddress'];
    $displayName = $_POST['displayName'];
    $password = $_POST['firstPassword'];

//username is the variable, userName is the column in the table
    function checkUserUnique($username, $emailAddress, $db){
        $sql_query = "SELECT * FROM User WHERE userName ='" . $username . "' OR emailAddress = '" . $emailAddress ."';";
        $result = $db->query($sql_query);
        while($row = $result->fetch_array()){
            return true;
        }
        return false;
    }

    if (checkUserUnique($username, $emailAddress, $db)){
        //if Unique user then add to database

        $sql_query = "INSERT INTO User (userName, password, emailAddress, displayName, levelCode)
                      VALUES ('". $username ."', '". $password ."', '". $emailAddress ."','" . $displayName ."', 1);";

        //and navigate to login page
        headerheader("location:loginPage");
        print('success!');
    }
    else{
        header("location:registerPage");
        print('That username or email address is already in use');
    }


}
?>