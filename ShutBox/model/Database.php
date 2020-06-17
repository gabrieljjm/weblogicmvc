<?php

class Database{
    private $host;
    private $user;
    private $pw;
    private $database;

    function _construct($filename){
        if(is_file($filename))include $filename;
        else throw new Exception("Error");

        $this->host = $host;
        $this->user = $user;
        $this->pw = $pw;
        $this->database = $database;

        $this->connect();
    }

    private function connect(){
        if(!mysqli_connect($this->host,$this->user,$this->pw))
            throw new Exception("Error: not connected to the server");
        else echo "ok";
        if(!mysqli_select_db($this->database))
            throw new Exception("Error: no databse selected");
        else echo "ok";
    }

    function close(){
        mysqli_close();
    }
}
?>