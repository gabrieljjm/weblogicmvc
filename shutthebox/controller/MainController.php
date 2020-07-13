<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class MainController extends BaseController
{
    public function indexhead(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            if ($this->check($user, $pwd)){
                Redirect::flashToRoute('home/menu', ['userlayout' => $user]);
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/menu', ['userlayout' => null]);
        }
    }

    public function index(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            if ($this->check($user, $pwd)){
                return View::make('home.menu', ['userlayout' => $user]);
            }
        }catch (Exception $e){}
        try {
            Session::remove('username');
            Session::remove('pwd');
        }catch (Exception $e){}
        View::make('home.menu', ['userlayout' => null]);
    }

    public function check($user, $pwd){
        if ((is_null($user))){
            return false;
        }elseif (strcmp($user->pwd, $pwd) != 0){
            return false;
        }elseif ($user->admin == 1){
            return true;
        }elseif ($user->banned == 1){
            return false;
        }else{
            return true;
        }
    }
}