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
    <p>View Uploads</p>
    <table width="80%" border="1">
        <tr>
            <th colspan="4">your uploads...<label><a href="/../scripts/fileUploadPageClubMedia.php">upload new files...</a></label></th>
        </tr>
        <tr>
            <td>File Name</td>
            <td>File Type</td>
            <td>File Size(KB)</td>
            <td>View</td>
        </tr>
        <?php
        $sql="SELECT * FROM clubmedia";
        $result = $db->query($sql);
        while($row = $result->fetch_array())
        {
            ?>
            <tr>
                <td><?php echo $row['file'] ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><?php echo $row['size'] ?></td>
                <td><a href="/../uploads/<?php echo $row['file'] ?>" target="_blank">view file</a></td>
                <td><?php echo $row['userID'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>

</div>
</body>
</html>