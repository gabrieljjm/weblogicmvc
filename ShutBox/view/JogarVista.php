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
            <div class="score-current " id="r1">
                <div class="price" id="rectangle">1</div>
            </div>
            <div class="score-current" id="r2">
                <div class="price" id="rectangle">2</div>
            </div>
            <div class="score-current" id="r3">
                <div class="price" id="rectangle">3</div>
            </div>
            <div class="score-current" id="r4">
                <div class="price" id="rectangle">4</div>
            </div>
            <div class="score-current" id="r5">
                <div class="price" id="rectangle">5</div>
            </div>
            <div class="score-current" id="r6">
                <div class="price" id="rectangle">6</div>
            </div>
            <div class="score-current" id="r7">
                <div class="price" id="rectangle">7</div>
            </div>
            <div class="score-current" id="r8">
                <div class="price" id="rectangle">8</div>
            </div>
            <div class="score-current" id="r9">
                <div class="price" id="rectangle">9</div>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="score-current1" id="r11">
                <div class="price" id="p2c1">1</div>
            </div>
            <div class="score-current1" id="r12">
                <div class="price" id="p2c2">2</div>
            </div>
            <div class="score-current1" id="r13">
                <div class="price" id="p2c3">3</div>
            </div>
            <div class="score-current1" id="r14">
                <div class="price" id="p2c4">4</div>
            </div>
            <div class="score-current1" id="r15">
                <div class="price" id="p2c5">5</div>
            </div>
            <div class="score-current1" id="r16">
                <div class="price" id="p2c6">6</div>
            </div>
            <div class="score-current1" id="r17">
                <div class="price" id="p2c7">7</div>
            </div>
            <div class="score-current1" id="r18">
                <div class="price" id="p2c8">8</div>
            </div>
            <div class="score-current1" id="r19">
                <div class="price" id="p2c9">9</div>
            </div>
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




