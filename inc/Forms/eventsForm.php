<!--Allows Club Admin/Site Admin to add events to the Calendar.-->
<?php
session_start();
if (isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include(__DIR__ . "/../scripts/header.php");
        include(__DIR__ . "/../scripts/dbconnect.php");
        ?>
        <main>
            <body>
            <p>Oh my my my my my my</p>
            <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
            <script>tinymce.init({selector: 'textarea'});</script>
            <form action="eventsForm.php" method="post">
                <input type="text" placeholder="Event Name" name="eventName">
                <input type="text" placeholder="Start Date" name="eventStartDate">
                <input type="text" placeholder="End Date" name="eventEndDate">
                <textarea name="eventDescription"></textarea>
                <input type="submit" value='Create Event'>
            </form>

            </body>
        <?
        include(__DIR__ . "/../scripts/footer.php");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*
        //include database
        include ("../scripts/dbconnect.php");

        //variables
        $clubID = $params['clubID'];
        $eventName = $_POST["eventName"];
        $eventStartDate = $_POST["eventStartDate"];
        $eventEndDate = $_POST["eventEndDate"];
        $eventDescription = $_POST["eventDescription"];

        $sql = "INSERT INTO clubcalender (clubID, eventName, eventStartDate, eventEndDate, eventDescription) VALUES ('" . $clubID . "', '" . $eventName . "', '" . $eventStartDate . "', '" . $eventEndDate . "', '".$eventDescription."');";
        if (mysqli_query($db, $sql)) {
            header("location:/clubPage/$clubID");
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }*/
    }
    //If not signed in send them to the login screen
}else {
        header("location:login");
    }
?>