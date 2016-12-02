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
    function translateLevelCode($levelCode){
        switch ($levelCode) {
            case 1:
                return "Contributor";
            case 11:
                return "NKPAG";
            case 21:
                return "Club Administrator";
            case 31:
                return "Site Administrator";
            default:
                return "Unknown User";
        }
    }
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
            echo "<form action=\"". $userID . "\" method=\"post\">";
            echo "<p>UserName:</p>";
            echo "<input type=\"text\" name=\"username\" value=\"" . $row['userName'] . "\" disabled>";
            echo "<p>Password:</p>";
            echo "<input type=\"password\" name=\"password\" value=\"" . $row['password'] . "\">";
            echo "<p>Confirm Password:</p>";
            echo "<input type=\"password\" name=\"confirmPassword\" placeholder='Confirm Password'>";
            echo "<p>Email Address:</p>";
            echo "<input type=\"text\" name=\"emailAddress\" value=\"" . $row['emailAddress'] . "\">";
            echo "<p>Display Name:</p>";
            echo "<input type=\"text\" name=\"displayName\" value=\"" . $row['displayName'] . "\">";
            if($_SESSION['accessLevel'] == 31) {    //If Site Adminstrator give extra controls.
                //Get existing value
                $currentLevelCode = $row['levelCode'];
                echo "<p>". $currentLevelCode ."</p>";
                $contributorValue = "";
                $nKPAGValue= "";
                $clubAdminValue = "";
                $siteAdminValue = "";
                //set option as existing value
                switch($currentLevelCode){
                    case 1:
                        $contributorValue = "selected=\"selected\"";
                        break;
                    case 11:
                        $nKPAGValue = "selected=\"selected\"";
                        break;
                    case 21:
                        $clubAdminValue = "selected=\"selected\"";
                        break;
                    case 31:
                        $siteAdminValue = "selected=\"selected\"";
                        break;
                    default:
                        //do nothing;
                }

                //echo "<p>Level Code:</p>";
                //echo "<input type=\"text\" name=\"levelCode\" value=\"" . translateLevelCode($row['levelCode']) . "\">";
                echo "<select name='userLevelSelect'>";
                echo "<option value=\"1\"". $contributorValue .">Contributor</option>";
                echo "<option value=\"11\"". $nKPAGValue .">NKPAG</option>";
                echo "<option value=\"21\"". $clubAdminValue .">Club Administrator</option>";
                echo "<option value=\"31\"". $siteAdminValue .">Site Administrator</option>";
                echo "</select>";
            }
            echo "<p><input type=\"submit\" id='updateDetailsButton' value='Update Details'></p>";
            echo "</form>";
            echo "</main>";
        }
    }
    include ("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $params['userID'];
    include("scripts/dbconnect.php");
    $updatedUsername = $_POST["username"];
    $updatedPassword = $_POST["password"];
    $updatedEmailAddress = $_POST["emailAddress"];
    $updatedDisplayName = $_POST["displayName"];
    $userToUpdate = $_SESSION['username'];
    //If user is Site Admin then apply update to User Access Level also
    if($_SESSION['accessLevel'] == 31) {
        $updatedLevelCode = $_POST["userLevelSelect"];
        $sql = "UPDATE User SET password = '".$updatedPassword."', emailAddress = '".$updatedEmailAddress."', displayName = '".$updatedDisplayName."', levelCode = '".$updatedLevelCode."' WHERE userID = '" . $userID ."';";
    }
    //If user is not site Admin apply update to all categories they can reach
    else{
        $sql = "UPDATE User SET password = '".$updatedPassword."', emailAddress = '".$updatedEmailAddress."', displayName = '".$updatedDisplayName. "' WHERE userID = '" . $userID ."';";
    }
    //echo "<p>". $sql ."</p>";
    if (mysqli_query($db, $sql)) {
        echo "<p>". $sql ."</p>";
        //header("location: /userDetailsPage/".$userID);
    } else {
        echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
    }
}
?>
