<!-- This is the upload button where signed in users can upload -->

<?php
session_start();
include(__DIR__ . "/../scripts/dbconnect.php");
if (isset($_SESSION['userID'])) {

?>
        <form action="/../uploadClubMedia" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="hidden" name="userID" value=<?php print $userID;?> />
            <button type="submit" name="btn-upload">upload</button>
        </form>
        <br /><br />
        <?php
        if(isset($_GET['success']))
        {
            ?>
            <label>File Uploaded Successfully...  <a href="/../viewUploads">click here to view file.</a></label>
            <?php
        }
        else if(isset($_GET['fail']))
        {
            ?>
            <label>Problem While File Uploading !</label>
            <?php
        }
        else
        {
            ?>
            <label>Try to upload any files(PDF, DOC, EXE, VIDEO, MP3, ZIP,etc...)</label>
            <?php
        }
        ?>
        <?

}else{
    //If not logged in don't show comment box
    echo"<p>Login to comment</p>";
} ?>
