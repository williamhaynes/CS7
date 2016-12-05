<?php
include_once 'dbconfig.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>File Uploading With PHP and MySql</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <div id="header">
            <label>File Uploading With PHP and MySql</label>
        </div>
        <div id="body">
            <form action="/../upload" method="post" enctype="multipart/form-data">
                <input type="file" name="file" />
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
        </div>
    </body>
</html>