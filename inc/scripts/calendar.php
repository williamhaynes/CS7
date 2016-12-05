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
    $sql_query;                                                     //Initialize query
    if(true){            //If page making call P&S page
        $sql_query = "SELECT * FROM Club Calender;";                //Get all events
    }
    else {                                                          //Call by specific club
        $sql_query = "SELECT * FROM Club Calendar WHERE = '". $clubID."';";     //Get specific Events
    }

    $result = $db->query($sql_query);                               //Process relevant query
    while($row = $result->fetch_array()){                           //Iterate through Query Results
        //if all clubs
            //Echo club name
            //Echo event name
            //Echo event date
        //if specific club
            //Echo event name
            //Echo event date
            //Echo event Description
    }



?>