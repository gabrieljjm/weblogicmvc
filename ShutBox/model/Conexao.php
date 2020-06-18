<?php

class Conexao{

    private $con;

    public function __construct()
    {
        $this->con = new mysqli('localhost', 'root', '','welogicmvc');


    }

    public function getUsers(){
        $query = $this->con->query('select * from users');

        $result = [];

        $i = 0;
        while($fila = $query->fetch_assoc()){
            $result[$i] = $fila;
        }

        return $result;
    }
}