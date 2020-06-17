<?php
session_start();

if(!isset($_SESSION['user'])){
    include '../model/LoginModel.php';
    die();
}

?>

<html>
<head>
    <title>Page Title</title>
</head>
<body>
    <div id="login-controls">
        <h2>Login</h2>

        <form action = "../controller/LoginController.php" method = "POST" >
            <p>Username: <br />
            <input type = "text" name="user"/>
            </p>
            <p>Password: <br />
            <input type = "password" name="pass"/>
            </p>
            <input type="submit" name ="op" value="login"/>
        </form>
    </div>
</body>
</html>