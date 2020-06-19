<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class GameController extends BaseController
{
    public function menu(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                return View::make('game.menu', ['user' => $user]);
            }
        }catch (Exception $e){}
        Redirect::flashToRoute('home.login', ['msg' => "", 'user' => null]);
    }

    public function game(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                if (isset($_POST['game'])){
                    $game = $_POST['game'];
                    return View::make('game.game', ['user' => $user, 'game' => $game]);
                }else{
                    $game = "a";
                    return View::make('game.game', ['user' => $user, 'game' => $game]);
                }
            }
        }catch (Exception $e){}

        Redirect::flashToRoute('home.login', ['msg' => "", 'user' => null]);
    }

    public function indexhead(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                Redirect::flashToRoute('home/inicio', ['user' => $user]);
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }
    }

    public function index(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                return View::make('home.inicio', ['user' => $user]);
            }
        }catch (Exception $e){}
        return View::make('home.inicio', ['user' => null]);
    }

    public function login(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                Redirect::flashToRoute('home/inicio', ['user' => $user]);
            }
        }catch (Exception $e){}
        return View::make('home.login', ['msg' => "", 'user' => null]);
    }

    public function logout(){
        Session::remove('name');
        Session::remove('pwd');
        Redirect::toRoute('home/login');
        //return View::make('home.login', ['msg' => "", 'user' => null]);
    }

    public function authenticate(){
        $name = $_POST['name'];
        $pwd = $_POST['pwd'];
        if (isset($_POST['btlogin'])){
            $user = User::find_by_name($name);
            if ((is_null($user))){
                return View::make('home.login', ['msg' => "Conta não existe", 'user' => null]);
            }elseif (strcmp($user->pwd, $pwd) !== 0){
                return View::make('home.login', ['msg' => "Palavra-Passe errada", 'user' => null]);
            }elseif ($user->admin == 1){
                Session::set('name', $name);
                Session::set('pwd', $pwd);
                Redirect::flashToRoute('home/inicio', ['user' => $user]);
            }elseif ($user->banned == 1){
                return View::make('home.login', ['msg' => "Conta Banida", 'user' => null]);
            }else{
                Session::set('name', $name);
                Session::set('pwd', $pwd);
                Redirect::flashToRoute('home/inicio', ['user' => $user]);
            }
        }else{
            $attributes = array('name' => $name, 'pwd' => $pwd);
            $user = new User($attributes);
            if ($user->is_valid()){
                $user->save();
                return View::make('home.login', ['msg' => "Boa!, agora inicie sessão.", 'user' => null]);
            }else{
                return View::make('home.login', ['msg' => "Credenciais inválidas.", 'user' => null]);
            }
        }
    }

    public function check($user, $pwd){
        if ((is_null($user))){
            return false;
        }elseif (strcmp($user->pwd, $pwd) !== 0){
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