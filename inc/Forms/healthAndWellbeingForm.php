<!--Allows user/site admin to write blog posts for the health and wellbeing page. As per System Requirements.-->
<?php
include ("../scripts/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health & Wellbeing Form</title>
</head>

<body>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({selector: 'textarea'});</script>
<form action="healthAndWellbeingForm.php" method="post">
    <input type="text" name="articleName" placeholder="Article Name">
    <textarea name="articleText"></textarea>
    <input type="submit">
</form>

</body>
</html>
<?php
include ("../scripts/footer.php");


//variables

$articleName = $_POST["articleName"];
$articleText = $_POST["articleText"];

//INSERT into the database
//Currently verified is always false possible to use a variable to check to see if its the site administrator posting
$sql = "INSERT INTO Health News (title, content, verified) VALUES ('" . $articleName . "', '" . $articleText . "', 'FALSE');";


if (mysqli_query($db, $sql)) {
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

//header("location:viewusers.php");



?>
