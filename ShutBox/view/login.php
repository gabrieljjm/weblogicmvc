<?php
session_start();
if(isset($_SESSION['user'])) header ("Location:main.php")
?>

<html>
<head>
    <title>Page Title</title>
</head>
<body>
    <div id="login-controls">
        <h2>Login</h2>
        <?php if(@$_GET['err'] == 1){?>
        <div class ="error-text">Login incorrect. Please try again</div>
        <?php
        }
        ?>
        <form method = "POST" action = "index.php">
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