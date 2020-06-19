<?php
include_once ("../controller/JogarController.php");
$jogar = new JogarController();


?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/JogoVista.css">

    <style>

    </style>
</head>
<body>

<div class="topnav">
    <a href="HomeVista.php">Home</a>
    <a class="active" href="JogarVista.php">Jogar</a>
    <a href="TopVista.php">Top 10</a>
    <a href="LoginVista.php">Login</a>
</div>

<br>
<br>

<div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-2">
    <div class="game-container center-block">
        <div class="col-xs-2">
            <form method="post">
                <button class="score-current" name="bt1" id="r1">
                    <div class="price" id="p1c1">1</div>
                    <?php
                    $bt1 = 1;
                    ?>
                </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt2" id="r2">
                <div class="price" id="p1c2">2</div>
                <?php
                $bt2 = 2;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt3" id="r3">
                <div class="price" id="p1c3">3</div>
                <?php
                $bt3 = 3;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt4" id="r4">
                <div class="price" id="p1c4">4</div>
                <?php
                $bt1 = 4;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt5" id="r5">
                <div class="price" id="p1c5">5</div>
                <?php
                $bt5 = 5;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt6" id="r6">
                <div class="price" id="p1c6">6</div>
                <?php
                $bt6 = 6;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt7" id="r7">
                <div class="price" id="p1c7">7</div>
                <?php
                $bt7 = 7;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt8" id="r8">
                <div class="price" id="p1c8">8</div>
                <?php
                $bt8 = 8;
                ?>
            </button>
            </form>
            <form method="post">
            <button class="score-current" name="bt9" id="r9">
                <div class="price" id="p1c9">9</div>
                <?php
                $bt9 = 9;
                ?>
            </button>
            </form>
        </div>

        <div class="col-xs-3">
            <button class="score-current1" id="r11">
                <div class="price" id="p2c1">1</div>
            </button>
            <button class="score-current1" id="r12">
                <div class="price" id="p2c2">2</div>
            </button>
            <button class="score-current1" id="r13">
                <div class="price" id="p2c3">3</div>
            </button>
            <button class="score-current1" id="r14">
                <div class="price" id="p2c4">4</div>
            </button>
            <button class="score-current1" id="r15">
                <div class="price" id="p2c5">5</div>
            </button>
            <button class="score-current1" id="r16">
                <div class="price" id="p2c6">6</div>
            </button>
            <button class="score-current1" id="r17">
                <div class="price" id="p2c7">7</div>
            </button>
            <button class="score-current1" id="r18">
                <div class="price" id="p2c8">8</div>
            </button>
            <button class="score-current1" id="r19">
                <div class="price" id="p2c9">9</div>
            </button>
        </div>

        <div class="col-xs-6">
            <div class="row">
                <center>
                    <div class="col-xs-12">
                        <form method="POST">
                            <input type="submit" id="dicebutton" name="dicebutton" value="Lançar dados" class="button buttonLancar" >
                        </form>
                        <!-- TESTE -->
                        <br>
                        <?php



                        function lancarDados()
                        {

                            $dado1 = rand(1, 6) . "";
                            $dado2 = rand(1, 6) . "";

                            if($dado1 == 1){
                                echo "<img src=\"../imagens/1.PNG\"/>";
                            }
                            if($dado1 == 2){

                                echo "<img src=\"../imagens/2.PNG\"/>";
                            }
                            if($dado1 == 3){

                                echo "<img src=\"../imagens/3.PNG\"/>";
                            }
                            if($dado1 == 4){

                                echo "<img src=\"../imagens/4.PNG\"/>";
                            }
                            if($dado1 == 5){

                                echo "<img src=\"../imagens/5.PNG\"/>";
                            }
                            if($dado1 == 6){

                                echo "<img src=\"../imagens/6.PNG\"/>";
                            }

                            echo "<br>";
                            echo "<br>";

                            if($dado2 == 1){

                                echo "<img src=\"../imagens/1.PNG\"/>";
                            }
                            if($dado2 == 2){

                                echo "<img src=\"../imagens/2.PNG\"/>";
                            }
                            if($dado2 == 3){

                                echo "<img src=\"../imagens/3.PNG\"/>";
                            }
                            if($dado2 == 4){

                                echo "<img src=\"../imagens/4.PNG\"/>";
                            }
                            if($dado2 == 5){

                                echo "<img src=\"../imagens/5.PNG\"/>";
                            }
                            if($dado2 == 6){

                                echo "<img src=\"../imagens/6.PNG\"/>";
                            }

                            $somadados = $dado1+$dado2;
                            echo "<br>";

                            switch ($somadados){
                                case 2:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r3").disabled = true;
                                    document.getElementById("r4").disabled = true;
                                    document.getElementById("r5").disabled = true;
                                    document.getElementById("r6").disabled = true;
                                    document.getElementById("r7").disabled = true;
                                    document.getElementById("r8").disabled = true;
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;
                                case 3:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r4").disabled = true;
                                    document.getElementById("r5").disabled = true;
                                    document.getElementById("r6").disabled = true;
                                    document.getElementById("r7").disabled = true;
                                    document.getElementById("r8").disabled = true;
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;

                                case 4:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r5").disabled = true;
                                    document.getElementById("r6").disabled = true;
                                    document.getElementById("r7").disabled = true;
                                    document.getElementById("r8").disabled = true;
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;

                                case 5:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r6").disabled = true;
                                    document.getElementById("r7").disabled = true;
                                    document.getElementById("r8").disabled = true;
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;

                                case 6:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r7").disabled = true;
                                    document.getElementById("r8").disabled = true;
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;
                                case 7:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r8").disabled = true;
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;

                                case 8:
                                    echo '<script type="text/JavaScript">  
                                    document.getElementById("r9").disabled = true;
                                 </script>';
                                    break;
                                case 9:
                                    default;
                            }
                        }


                        if(array_key_exists('dicebutton',$_POST)){
                            lancarDados();
                        }
                        ?>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>


</body>
</html>




