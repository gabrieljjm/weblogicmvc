<?php
require '../model/Conexao.php';
$con = new Conexao();
$users = $con->getUsers();

require '../view/LoginVista.php';


class UserController extends UserModel{

    public function LoginVista(){
        require '../view/LoginVista.php';
    }





}

if(isset($_GET['action']) && $_GET['action'] == 'login'){
    $instanciaControlador = new UserModel();
    $instanciaControlador->LoginVista();
}

?>