<!-- Distinct login page for site - existing users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include ("scripts/header.php");
    ?>
    <main>
        <form action="loginPage" method="post">
            <input type="text" placeholder="User Name" name="username">
            <input type="password" placeholder="Password" name="password">
            <p><input type="submit" value='Login'></p>
        </form>
    </main>
    <?
    include("scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("scripts/dbconnect.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
//username is the variable, userName is the column in the table
    function checklogin($username, $password, $db){
        $sql_query = "SELECT * FROM User WHERE userName ='" . $username . "' AND password = '" . $password ."';";
        $result = $db->query($sql_query);
        while($row = $result->fetch_array()){
            return true;
        }
        return false;
    }

    if (checklogin($username, $password, $db)){
        session_start();
        $_SESSION['username'] = $username;
        header("location:../clubsAndSocietiesPage");
        print('success!');
    }
    else{
        header("location:loginPage");
        print('wrong password or username');
    }
}

?>
<!--
<!DOCTYPE html>
<html lang="en">

</html>
-->