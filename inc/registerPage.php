<!-- Distinct register page for site - new users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
include ("scripts/header.php");
?>


<main>
    <div id="divForRegisterPage">
        <script>
            $(document).ready(function() {
                //If any fields are changed by the user it runs the relevant field check or password check.
                $('#secondPassword').keyup(checkPasswordMatch());
                $('#firstPassword').keyup(checkPasswordMatch());
                $('#usersname').keyup(checkFields());
                $('#usersEmailAddress').keyup(checkFields());
                $('#usersEmailAddress').keyup(checkFields());
                $('#firstPassword').keyup(checkFields());
            });
            //variable for JS - allows functions to both access value
            var passwordsMatch = false;
            /*
             * A function which compares the two password values and makes sure they match
             */
            function checkPasswordMatch() {
                var password = $('#firstPassword').val();
                var confirmPassword = $('#secondPassword').val();

                if (password != confirmPassword) {
                    $('#passwordConfirmer').html("Passwords do not match!");
                    $('#submitRegisterButton').attr("disabled", true);
                    passwordsMatch = false;
                }
                else if($('#firstPassword').val() && password == confirmPassword){
                    $('#passwordConfirmer').html("Passwords match!");
                    passwordsMatch = true;
                }
            }

            /*
             * a function which check that all fields have had values input in to them
             * additional check rules could be added here if necessary.
             * Commented out console code for debugging.
             */
            function checkFields(){
                var username = false;
                var emailAddress = false;
                var displayName = false;
                var passwords = false;
                var fieldsFilled = false;

                if($('#usersname').val()){  //if username has value
                    username = true;
                    //console.log("username true");
                } else{ username = false;}

                if($('#usersEmailAddress').val()){ //if email address has value
                    emailAddress = true;
                    //console.log("emailaddress true");
                } else{ emailAddress = false;}

                if($('#usersDisplayName').val()){ //if displayname has been set
                    displayName = true;
                    //console.log("displayname true");
                    //console.log($('#usersDisplayName').val.toString());
                } else{ displayName = false;}

                if($('#firstPassword').val()){ //if password set
                    passwords = true;
                    //console.log("firstpassword true");
                    //console.log("fieldsfull should be true if passwords match");
                } else{ passwords = false;}

                //if all fields filled out
                if(username == true && emailAddress == true && displayName == true && passwords == true){
                    fieldsFilled = true;
                    //console.log("fieldsfilled true");
                } else{ fieldsFilled = false;}

                //if all fields filled out and passwords match
                if(fieldsFilled == true && passwordsMatch == true){
                    $('#submitRegisterButton').removeAttr("disabled");  //re-enable the submit button to allow registration
                    //console.log("enabled registerbutton");
                }
                else{
                    $('#submitRegisterButton').attr("disabled", true);  //disable the submit button to prevent registration
                }
            }
        </script>
        <h2 class="pageHeaderText">Register</h2>
        <form action="registerPage" method="post">
            <p><input type="text" placeholder="User Name" id="usersname" onchange="checkFields()" name="username" class="loginAndRegisterPageTextBox"></p>
            <p><input type="text" placeholder="Email Address" id="usersEmailAddress" onchange="checkFields()" name="emailAddress" class="loginAndRegisterPageTextBox"></p>
            <p><input type="text" placeholder="Display Name" id="usersDisplayName" onchange="checkFields()" name="displayName" class="loginAndRegisterPageTextBox"></p>
            <p><input type="password" placeholder="Password" id="firstPassword" onchange="checkPasswordMatch()" name="password" class="loginAndRegisterPageTextBox"></p>
            <p><input type="password" placeholder="Confirm Password" id="secondPassword" onchange="checkPasswordMatch(); checkFields();" name="confirmPassword" class="loginAndRegisterPageTextBox"></p>
            <p id="passwordConfirmer"></p>
            <p><input type="submit" id='submitRegisterButton' value='Register' disabled></p>
            <p class="whyNotRegisterText">Already a member? Why not <a href='/loginPage'>login?</a></p>
        </form>
    </div>
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