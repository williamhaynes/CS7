<!-- PHP file to allow includeable calendar on relevant pages -->
<?php
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 05/12/2016
 * Time: 11:58
 */
include("dbconnect.php");
    session_start();                                                //Allow access to session cookies
    $clubID = $params['clubID'];                               //get required session cookie
    //Get the current URL
    $currentURL = $_SERVER['REQUEST_URI'];
    $sql_query;                                                     //Initialize query
    if($currentURL == "/clubsAndSocietiesPage"){            //If page making call P&S page
        $sql_query = "SELECT * FROM clubcalender INNER JOIN club ON club.clubID=clubcalender.clubID;";                //Get all events
        echo "<div id=calendar>";
        echo "<table id=\"allEventsCalendar\">";
        echo "<tr>";
        echo "<th>Date</th>";
        echo "<th>Event Name</th>";
        echo "<th>Club</th>";
        echo "</tr>";
    }
    elseif ($currentURL == "/clubPage/" . $clubID){                                                          //Call by specific club
        $sql_query = "SELECT * FROM clubcalender INNER JOIN club ON club.clubID=clubcalender.clubID WHERE clubcalender.clubID ='".$clubID."';";     //Get specific Events
        echo "<div id=calendar>";
        echo "<table id=\"specificClubCalendar\">";
        echo "<tr>";
        echo "<th>Date</th>";
        echo "<th>Event Name</th>";
        echo "<th>Event Description</th>";
        echo "</tr>";
    }
    $result = $db->query($sql_query);                               //Process relevant query
    while($row = $result->fetch_array()) {                           //Iterate through Query Results
        //if all clubs
        //echo"<p>Club Name is".$row['clubName']."</p>";
        //echo"<p>Club Query is".$sql_query."</p>";
        if ($currentURL == "/clubsAndSocietiesPage") {
            //Implement table row
            echo "<tr>";
            //Echo club name
            echo "<td>" . $row['eventStartDate'] . "</td>";
            //Echo event name
            echo "<td>" . $row['eventName'] . "</td>";
            //Echo event date
            echo "<td>" . $row['clubName'] . "</td>";
            //End table row
            echo "</tr>";
        }
        elseif ($currentURL == "/clubPage/" . $clubID){//if specific club
            //Implement table row
            echo "<tr>";
                //Echo event name
            echo "<td>". $row['eventStartDate'] . "</td>";
                //Echo event date
            echo "<td>". $row['eventName'] . "</td>";
                //Echo event Description
            echo "<td>". $row['eventDescription'] . "</td>";
            //End table row
            echo "</tr>";
        }
    }
    echo "</table>";
        if (($_SESSION['userID']!=NULL&&$_SESSION['userID']==$_SESSION['adminID']||$_SESSION['accessLevel']==31)) {
            echo "<a id='createEventLink' href='/eventsForm' class='button'> Add Event </a>";
        }
    echo "</div>";

?>