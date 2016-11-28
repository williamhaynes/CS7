<!-- Distinct login page for site - existing users-->

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    include("../scripts/header.php");
    ?>
    <main>
        <form action="loginPage.php" method="post">
            <input type="text" placeholder="User Name" name="username">
            <input type="password" placeholder="Password" name="password">
            <p><input type="submit" value='Login'></p>
        </form>
    </main>
    <?
    include("../scripts/footer.php");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include("../scripts/dbconnect.php");

    $userName = $_POST['username'];
    $password = $_POST['password'];

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
        $_SESSION['userName'] = $username;
        header("location:../clubsAndSocieties.php");
        print('success!');
    }
    else{
        header("location:loginPage.php");
        print('wrong password or username');
    }
}
    else{
        print('unreachable statement');
    }

?>
<!--
<!DOCTYPE html>
<html lang="en">

</html>
-->