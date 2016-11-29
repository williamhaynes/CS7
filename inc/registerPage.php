<!-- Distinct register page for site - new users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
include ("scripts/header.php");
?>


<main>
    <form action="registerPage" method="post">
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

    //Variables - NEED TO ADD SECURITY TO THIS BECAUSE ALLOWS SQL INJECTION CURRENTLY
    $username = $_POST['username'];
    $emailAddress = $_POST['emailAddress'];
    $displayName = $_POST['displayName'];
    $password = $_POST['password'];

//username is the variable, userName is the column in the table
    function checkUserUnique($username, $emailAddress, $db){
        $sql_query = "SELECT * FROM User WHERE userName ='" . $username . "' OR emailAddress = '" . $emailAddress ."';";
        $result = $db->query($sql_query);
        while($row = $result->fetch_array()){ //if in database return false
            return false;
        }
        return true; //if unique return true
    }

    if (checkUserUnique($username, $emailAddress, $db)){
        //if Unique user then add to database
        $sql = "INSERT INTO User (userName, password, emailAddress, displayName, levelCode)
                      VALUES ('". $username ."', '". $password ."', '". $emailAddress ."','" . $displayName ."', '1');";
        $result = $db->query($sql);
        //and navigate to login page
        header("location:../loginPage");
        print('success!');
    }
    else{
        header("location:../registerPage");
        print('That username or email address is already in use');
    }


}
?>