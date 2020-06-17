<?php

class LoginModel{

    private $username;
    private $password;
    private $cxn;

    function _construct($username, $password){
        $this->setData($username, $password);
        $this->connectToDb();
        $this->getData();
    }

    private function setData($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    private function connectToDb(){
        include 'Database.php';
        $vars = "../include/vars.php";
        $this->cxn = new Database($vars);
    }

    function getData(){
        $query = "select * from users where nome = '$this->username' and pass = '$this->password'";
        $sql = mysqli_query($query);

        if(mysqli_num_rows($sql) > 0)
        {
            return true;
        }
        else
        {
            throw new Exception("Username or password is incorrect");
        }
    }

    function close(){
        mysqli_close();
    }
}