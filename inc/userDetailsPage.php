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
    if ($_SESSION['userID'] == $userID || $_SESSION['accessLevel'] == 31) {//if session id matches the current user let them see their account, or let the site admin
        //Select all values from the User table for the current user
        $sql_query = "SELECT * FROM User WHERE userID ='" . $userID . "';";
        $result = $db->query($sql_query);
        //Iterate through the values and create a html form for the user to see
        while ($row = $result->fetch_array()) {
            echo "<main>";
            echo "<form action=\"" . $userID . "\" method=\"post\">";
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
            //If Site Adminstrator or club Admin let see club details
            if ($_SESSION['accessLevel'] == 31) {
                /*
                 * This section affects the control over the Access Level of an individual user
                 */
                //Get existing values
                $currentLevelCode = $row['levelCode'];
                //Variables to affect which option is "selected" on page load
                $contributorValue = "";
                $nKPAGValue = "";
                $clubAdminValue = "";
                $siteAdminValue = "";
                //update variables as relevant
                switch ($currentLevelCode) {
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
                //Below is the options of administration as a selectable option list
                echo "<p>User Level:</p>";
                echo "<select name='userLevelSelect'>";
                echo "<option value=\"1\"" . $contributorValue . ">Contributor</option>";
                echo "<option value=\"11\"" . $nKPAGValue . ">NKPAG</option>";
                echo "<option value=\"21\"" . $clubAdminValue . ">Club Administrator</option>";
                echo "<option value=\"31\"" . $siteAdminValue . ">Site Administrator</option>";
                echo "</select>";
            }
        }
        echo "<p><input type=\"submit\" id='updateDetailsButton' value='Update Details'></p>";
        echo "</form>";
        if ($_SESSION['accessLevel'] == 31 || $_SESSION['accessLevel'] == 21) {
            /*
             * This section affects the Club Administration Options of a specific user
             */
            //Generate SQL query to get club name if club admin or site admin
            $sql_query2 = "SELECT clubName FROM Club WHERE adminID = '" . $userID . "';";
            if (mysqli_query($db, $sql_query2)) {
            } else {
                echo "Error: " . $sql_query2 . "<br>Error Message:" . mysqli_error($db);
            }
            $result2 = $db->query($sql_query2);
            echo "<p>Club Administrator for:</p>";
            //Iterate through club results and return them
            while ($row2 = $result2->fetch_array()) {
                echo "<form action=\"" . $userID . "\" method=\"post\">";
                echo "<input type=\"text\" name=\"clubName\" value=\"" . $row2['clubName'] . "\" disabled>";
                echo "<p><input type=\"submit\" id='removeClubAdmin' value='Remove as Club Admin'></p>";
                echo "</form>";
            }

            echo "</main>";
        } else {
            header("location: /404");
        }
        include("scripts/footer.php");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $userID = $params['userID'];
    include("scripts/dbconnect.php");
    //If user is updating their details
    if (isset($_POST['updateDetailsButton'])){
        $updatedUsername = $_POST["username"];
        $updatedPassword = $_POST["password"];
        $updatedEmailAddress = $_POST["emailAddress"];
        $updatedDisplayName = $_POST["displayName"];
        $userToUpdate = $_SESSION['username'];
        //If user is Site Admin then apply update to User Access Level also
        if ($_SESSION['accessLevel'] == 31) {
            $updatedLevelCode = $_POST["userLevelSelect"];
            $sql = "UPDATE User SET password = '" . $updatedPassword . "', emailAddress = '" . $updatedEmailAddress . "', displayName = '" . $updatedDisplayName . "', levelCode = '" . $updatedLevelCode . "' WHERE userID = '" . $userID . "';";
        } //If user is not site Admin apply update to all categories they can reach
        else {
            $sql = "UPDATE User SET password = '" . $updatedPassword . "', emailAddress = '" . $updatedEmailAddress . "', displayName = '" . $updatedDisplayName . "' WHERE userID = '" . $userID . "';";
        }
        //echo "<p>". $sql ."</p>";
        if (mysqli_query($db, $sql)) {
            //echo "<p>". $sql ."</p>";
            header("location: /userDetailsPage/" . $userID);
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }
    } else { //if user is removing themselves as club admin
        //Generate SQL query to get club name if club admin or site admin
        $selectedClub = $_POST["clubName"];
        $sql_query3 = "UPDATE Club SET adminID = null WHERE adminID = '" . $userID . "' AND clubName = '". $selectedClub ."';";
        if (mysqli_query($db, $sql_query2)) {
        } else {
            echo "Error: " . $sql_query2 . "<br>Error Message:" . mysqli_error($db);
        }
        $result2 = $db->query($sql_query2);
    }
}
?>