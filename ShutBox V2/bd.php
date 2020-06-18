<?php

$host = "localhost:63342";
$user = "root";
$pw= "";
$database ="welogicmvc";

global $pdo;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=welogicmvc;charset=UTF8;");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo "Erro: " .$e->getMessage();
    exit;
}
