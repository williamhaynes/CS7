<!-- Distinct register page for site - new users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
include ("scripts/header.php");
?>


<main>
    <script>
        $(document).ready(function() {
            $('#secondPassword').keyup(checkPasswordMatch());
            $('#firstPassword').keyup(checkPasswordMatch());
        });

        function checkPasswordMatch() {
            var password = $('#firstPassword').val();
            var confirmPassword = $('#secondPassword').val();

            if (password != confirmPassword) {
                $('#passwordConfirmer').html("Passwords do not match!");
            }
            else{
                $('#passwordConfirmer').html("Passwords match!");
            }
        }

    </script>
    <form action="registerPage" method="post">
        <input type="text" placeholder="User Name" name="username">
        <input type="text" placeholder="Email Address" name="emailAddress">
        <input type="text" placeholder="Display Name" name="displayName">
        <input type="password" placeholder="Password" id="firstPassword" name="password">
        <input type="password" placeholder="Confirm Password" id="secondPassword" onchange="checkPasswordMatch()" name="confirmPassword">
        <p id="passwordConfirmer"></p>
        <p><input type="submit" value='Register'></p>
    </form>
</main>

<?
include ("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("scripts/dbconnect.php");

    /*
     * Variables for the different values of the user
     * Username: The username of the user
     * emailAddress: The email address of the user
     * displayName: The display name of the user
     * password; The password of the user
     */
    $username = $_POST['username'];
    $emailAddress = $_POST['emailAddress'];
    $displayName = $_POST['displayName'];
    $password = $_POST['password'];

    /*
     * A function checkUserUnique to make sure each user login is unique
     * Using a database to check the login details like login and/or emailAddress
     *
     * Returns true if unique or false if in database
     */
    function checkUserUnique($username, $emailAddress, $db){
        $sql_query = "SELECT * FROM User WHERE userName ='" . $username . "' OR emailAddress = '" . $emailAddress ."';";
        $result = $db->query($sql_query);
        while($row = $result->fetch_array()){ 
            return false; //in database so returns false
        }
        return true; //is unique so returns true
    }

    /*
     * If user is unique then they will be added to the database and add the following values
     * username: The users username
     * password: The password the user has created
     * emailAddress: The email address the user has given
     * displayName: The display name the user is given
     * levelCode: The level code the user has
     * 
     * After the users details have been added to the database the page will then navigate to the login page
     */
    if (checkUserUnique($username, $emailAddress, $db)){
        $sql = "INSERT INTO User (userName, password, emailAddress, displayName, levelCode)
                      VALUES ('". $username ."', '". $password ."', '". $emailAddress ."','" . $displayName ."', '1');";
        $result = $db->query($sql);
        header("location:../loginPage");
        print('success!');
    }
    /*
     * If the details are already in use then the page will display an error message
     */
    else{
        header("location:../registerPage");
        print('That username or email address is already in use');
    }


}
?>