<?php

class UserModel{


    public function login($user, $senha){
        global $pdo;

        $sql = "select * from users where nome = :nome and pass = :senha";
        $sql = $pdo->prepare($sql);
        $sql->bindValue("nome", $user);
        $sql->bindValue("senha", $senha);
        $sql->execute();

        if($sql->rowCount()>0){
            $dado = $sql->fetch();
            echo $dado['id'];
        }
    }
}