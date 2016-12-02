<!--
The page will hold details about the current user. They will be allowed to make any changes to their details and to clearly
see what their access rights are, i.e. club Administrator rights.
Possible ability to expand upon this and allow them to see their pending and verified posts, though this is
an option for expandability and is not a requirement.
-->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include ("scripts/header.php");
    include("scripts/dbconnect.php");
    $userID = $params['userID'];
/*
 * If a user is logged in, according to the session cookie, then select all the data from the database for that user
 * Pull the following information:
 * Username: The username of the user
 * Password: The password of the user
 * Email Address: The email address of the user
 * Display Name: The display name of the user
 * Level Code: The level code for the user
 */
    if ($_SESSION['userID'] == $userID || $_SESSION['accessLevel'] == 31) {
        $sql_query = "SELECT * FROM User WHERE userID ='" . $userID ."';";
        $result = $db->query($sql_query);
        while ($row = $result->fetch_array()) {
            echo "<main>";
            echo "<form action=\"userDetailsPage\" method=\"post\">";
            echo "<p>UserName:</p>";
            echo "<input type=\"text\" name=\"username\" value=\"" . $row['userName'] . "\">";
            echo "<p>Password:</p>";
            echo "<input type=\"password\" name=\"password\" value=\"" . $row['password'] . "\">";
            echo "<p>Confirm Password:</p>";
            echo "<input type=\"password\" name=\"confirmPassword\" placeholder='Confirm Password'>";
            echo "<p>Email Address:</p>";
            echo "<input type=\"text\" name=\"emailAddress\" value=\"" . $row['emailAddress'] . "\">";
            echo "<p>Display Name:</p>";
            echo "<input type=\"text\" name=\"displayName\" value=\"" . $row['displayName'] . "\">";
            if($_SESSION['accessLevel'] == 31) {    //If Site Adminstrator give extra controls.
                echo "<p>Level Code:</p>";
                echo "<input type=\"text\" name=\"levelCode\" value=\"" . $row['levelCode'] . "\">";
            }
            echo "<p><input type=\"submit\" id='updateDetailsButton' value='Update Details'></p>";
            echo "</form>";
            echo "</main>";
        }
    }
    include ("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("scripts/dbconnect.php");
    $updatedUsername = $_POST["username"];
    $updatedPassword = $_POST["password"];
    $updatedEmailAddress = $_POST["emailAddress"];
    $updatedDisplayName = $_POST["displayName"];
    if($_SESSION['accessLevel'] == 31) {
        $updatedLevelCode = $_POST["levelCode"];
    }
    $userToUpdate = $_SESSION['username'];

    $sql = "UPDATE User SET userName = '" .$updatedUsername."', password = '".$updatedPassword."', emailAddress = ".$updatedEmailAddress.", displayName = '".$updatedDisplayName."'";
    if($_SESSION['accessLevel'] == 31) {
        $sql .= ", levelCode = '".$updatedLevelCode."'";
                    }
    $sql .= "WHERE userID = '" .$userToUpdate ."';";
    echo "<p>". $sql ."</p>";
    if (mysqli_query($db, $sql)) {
        header("location: /userDetailsPage");
    } else {
        echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
    }
}
?>
