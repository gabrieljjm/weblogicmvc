<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class AuthenticationController extends BaseController
{
    public function CheckCredentials(){
        $name = $_POST['inputName'];
        $pwd = $_POST['inputPwd'];
        $user = User::find_by_name($name);
        if ((is_null($user))){
            return "null";
        }elseif (strcmp($user->pwd, $pwd) !== 0){
            return "wrong";
        }elseif ($user->admin == 1){
            return "admin";
        }elseif ($user->banned == 1){
            return "banned";
        }else{
            return "logged";
        }
    }

    public function CheckLogin(){

        return View::make('home.login');
    }
}