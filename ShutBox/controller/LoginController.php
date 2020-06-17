<?php

try{
    include '../model/Database.php';
    $vars = "../include/vars.php";
    new Database($vars);

}catch (Exception $exc){
    echo $exc->getMessage();
}



if($_POST){
    if(isset($_POST['op']) and $_POST['op'] == "login"){
        $username = $_POST ['user'];
        $password = $_POST ['pass'];

        try {
              include '../model/LoginModel.php';
              $login = new Login($username, $password);

              if($login == true){
                  $_SESSION['user']= $username;

              }


        }catch (Exception $exc){
            echo $exc->getMessage();
        }
    }
}