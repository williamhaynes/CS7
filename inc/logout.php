<?php
session_start();
if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
}

echo "<li><a href='createarticle'>Create Article</a></li>";
header("location:../clubsAndSocietiesPage");
?>