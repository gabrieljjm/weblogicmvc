<?php

    if(isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['pass']) && !empty($_POST['pass'])){

        require '../bd.php';
        require '../models/UserModel.php';

        $u = new UserModel();


        $user = addslashes($_POST['user']);
        $senha = addslashes($_POST['pass']);

        $u->login($user, $senha);


    }else{
        header("Location: ../views/Login.php");
    }


?>