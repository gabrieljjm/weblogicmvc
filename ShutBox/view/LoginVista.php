
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/LoginVista.css">
    <style>

    </style>
</head>
<body>

<div class="topnav">
    <a href="HomeVista.php">Home</a>
    <a href="JogarVista.php">Jogar</a>
    <a href="TopVista.php">Top 10</a>
    <a class="active" href="LoginVista.php">Login</a>
</div>

<br>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->
        <h2 class="active"> Sign In </h2>
        <h2 class="inactive underlineHover">Sign Up </h2>

        <br>

        <form action="../controller/UserController.php" method="POST">
            <input type="hidden" name="action" value="login">
            <input type="text" id="login" class="fadeIn second" name="user" placeholder="Utilizador" required>
            <input type="text" id="password" class="fadeIn third" name="pass" placeholder="Palavra-passe" required>
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

    </div>
</div>



</body>
</html>