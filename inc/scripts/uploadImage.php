<?php
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 08/12/2016
 * Time: 18:38
 * Code sourced from
 * http://www.w3schools.com/php/php_file_upload.asp
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    echo "<div id='divForUploadImage'>";
    echo "<form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\">";
    echo "Select image to upload:";
    echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">";
    echo "<input type=\"submit\" value=\"Upload Image\" name=\"submit\">";
    echo "</form>";
    echo "</div>";
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
//Specifies the directory where the file is to be placed
    $target_dir = "../uploads/";
//Specifies the path of the file to be uploaded
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//Boolean to control whether file is allowed to upload or not
    $uploadOk = 1;
//Holds the file extension of the file
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
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
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            header("location:../registerPage");
        } else {
            echo "Sorry, there was an error uploading your file.";
            header("location:404");
        }
    }
}
?>