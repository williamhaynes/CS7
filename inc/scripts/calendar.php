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
    $clubID = $_SESSION['clubID'];                                  //get required session cookie
    //Get the current URL
    $currentURL = $_SERVER['REQUEST_URI'];
    $sql_query;                                                     //Initialize query
    if($currentURL == "/clubsAndSocietiesPage"){            //If page making call P&S page
        $sql_query = "SELECT * FROM clubCalender;";                //Get all events
    }
    elseif ($currentURL == "clubPage/" . $clubID){                                                          //Call by specific club
        $sql_query = "SELECT * FROM clubCalendar INNER JOIN club ON = 'clubCalendar". $clubID."'='club'". $clubID. ";";     //Get specific Events
    }

    $result = $db->query($sql_query);                               //Process relevant query
    while($row = $result->fetch_array()){                           //Iterate through Query Results
        //if all clubs
            //Echo club name
        echo "<tr>". $row['clubName'] ."</tr>";
            //Echo event name
        echo "<tr>". $row['eventName'] . "</tr>";
            //Echo event date
        echo "<tr>". $row['eventStartDate'] . "</tr>";
        //if specific club
            //Echo event name
        echo "<tr>". $row['eventName'] . "</tr>";
            //Echo event date
        echo "<tr>". $row['eventStartDate'] . "</tr>";
            //Echo event Description
        echo "<tr>". $row['eventDescription'] . "</tr>";
    }



?>