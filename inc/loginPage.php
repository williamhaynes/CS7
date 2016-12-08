<!-- Distinct login page for site - existing users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include ("scripts/header.php");
    ?>
    <main>
        <div id="divForLoginPage">
            <h2 class="pageHeaderText">User Login</h2>
            <form action="loginPage" method="post">
                <input type="text" placeholder="User Name or Email Address" name="username" class="loginPageTextBox">
                <p><input type="password" placeholder="Password" name="password" class="loginPageTextBox"></p>
                <p><input type="submit" id="loginPageLoginButton"value='Login'></p>
            </form>
            <p id="whyNotRegisterText">Not a member? Why not <a href='/registerPage'>register?</a></p>
        </div>
    </main>
    <?
    include("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("scripts/dbconnect.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    

    /*
     * A function to check the login details
     * Using the database to check if the details stored are the ones being entered
     */
    function checklogin($username, $password, $db){
        $sql_query = "SELECT * FROM User WHERE userName ='" . $username . "' OR emailAddress = '". $username ."' AND password = '" . $password ."';";
        $result = $db->query($sql_query);
        while($row = $result->fetch_array()){
            return true;
        }
        return false;
    }
    /*
     * A function to check the level code of the user
     * Using the database to check what level of user is logged in
     */
    function getLevelCode($username, $db){
        $sql_query = "SELECT levelCode FROM User WHERE userName ='" . $username ."' OR emailAddress='". $username ."';";
        $result = $db->query($sql_query);
        $thisLevelCode = 0;
        while($row = $result->fetch_array()){
            $thisLevelCode = $row['levelCode'];
        }
        return $thisLevelCode;
    }
    /*
     * A function to get the userID of the user
     * Using the database to get the userID
     */
    function getUserID($username, $db){
        $sql_query = "SELECT userID FROM User WHERE userName ='" . $username ."' OR emailAddress='". $username ."';";
        $result = $db->query($sql_query);
        $thisUserID = 0;
        while($row = $result->fetch_array()){
            $thisUserID = $row['userID'];
        }
        return $thisUserID;
    }

    function getDisplayName($username, $db){
        $sql_query = "SELECT displayName FROM User WHERE userName ='" . $username ."' OR emailAddress='". $username ."';";
        $result = $db->query($sql_query);
        $thisDisplayName = "";
        while($row = $result->fetch_array()){
            $thisDisplayName = $row['displayName'];
        }
        return $thisDisplayName;
    }
    /*
     * If all details match the details stored on the database then print 'success!'
     * Otherwise print 'wrong password or username'
     */
    if (checklogin($username, $password, $db)){
        session_start();
        $_SESSION['username'] = $username; 
        $_SESSION['accessLevel'] = getLevelCode($username, $db);
        $_SESSION['userID'] = getUserID($username, $db);
        $_SESSION['displayName'] = getDisplayName($username, $db);
        header("location:../clubsAndSocietiesPage");
        print('success!');
    }
    else{
        echo "<p>Wrong Username or Password</p>"; //error message to display if wrong username or password
        header("location:loginPage");
        print('wrong password or username');
    }
}

?>