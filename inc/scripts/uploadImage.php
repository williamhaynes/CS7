<?php
session_start();
include("dbconnect.php");
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 08/12/2016
 * Time: 18:38
 * Code inspired by
 * http://stackoverflow.com/questions/1636877/how-can-i-store-and-retrieve-images-from-a-mysql-database-using-php
 * And
 * http://www.w3schools.com/php/php_file_upload.asp
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    echo "<div id='divForUploadImage'>";
    echo "<form action=\"Forms/clubAdminForm\" method=\"post\" enctype=\"multipart/form-data\">";
    echo "Select image to upload:";
    echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">";
    echo "<input type=\"submit\" value=\"Upload Image\" name=\"uploadImage\">";
    echo "</form>";
    echo "</div>";
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageClubID = $_SESSION['clubID'];
    $filename =$_FILES['$fileToUpload'];
//Get the file contents
    $imageDate = file_get_contents($filename);
//Get the file size
    $imageSize = getimagesize($filename);
//Boolean to control whether file is allowed to upload or not
    $uploadOk = 1;
//Holds the file extension of the file
    $imageFileType = pathinfo($filename, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image{
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
// Check file size - currently set to 500KB
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "Oh my I'm loading the wrong script";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        $sql="INSERT INTO images(image_type, image, image_size, image_clubID, image_name)
              VALUES($imageFileType, $filename, $imageSize, $imageClubID, ".$filename['file'].")";
        if (mysqli_query($db, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>Error Message:" . mysqli_error($db);
        }

    }
}
?>