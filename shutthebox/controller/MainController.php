<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class MainController extends BaseController
{

    public function index(){
        return View::make('home.inicio');
    }

    public function login(){
        return View::make('home.login');
    }

    public function authenticate(){
        /*$option = AuthenticationController::CheckCredentials($name, $pwd);
        switch ($option){
            case "null":
                return View::make('home.login');
                break;
            case "wrong":
                return View::make('home.login');
                break;
            case "admin":
                return View::make('home.inicio');
                break;
            case "banned":
                return View::make('home.login');
                break;
            case "logged":
                return View::make('home.inicio');
                break;
        }
        */
        $name = $_POST['inputName'];
        $pwd = $_POST['inputPwd'];
        $user = User::find_by_name($name);
        if ((is_null($user))){
            return View::make('home.login');
        }elseif (strcmp($user->pwd, $pwd) !== 0){
            return View::make('home.login');
        }elseif ($user->admin == 1){
            return View::make('home.inicio');
        }elseif ($user->banned == 1){
            return View::make('home.login');
        }else{
            return View::make('home.inicio');
        }

    }
}