<!--Allows user/site admin to write blog posts for the health and wellbeing page. As per System Requirements.-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Health & Wellbeing Form</title>
</head>

<body>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({selector: 'textarea'});</script>
<form action="createarticle" method="post">
    <input type="text" name="articleName" placeholder="Article Name">
    <textarea name="articleText"></textarea>
    <input type="submit">
</form>

</body>
</html>


<?php
/**
 * Created by PhpStorm.
 * User: hype_
 * Date: 07/11/2016
 * Time: 12:24
 */

