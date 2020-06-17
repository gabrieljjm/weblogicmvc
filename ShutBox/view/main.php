<?php
require_once ('../model/UserModel.inc.php');
session_start();
if(!isset($_SESSION['user'])){
    header("Location:login.php");
}else{
    $user = $_SESSION['user'];
}
?>


<html>
<head>
    <title>Page Title</title>
</head>
<body>
    <p>
        You are now logged in <?php print $user->getUsername() ?>
        <a href="index.php?op=logout">Logout</a>
    </p>
</body>
</html>