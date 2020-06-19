<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class MainController extends BaseController
{
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
        try {
            Session::remove('name');
            Session::remove('pwd');
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

    public function update()
    {
        try {
            $id = $_POST['id'];
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                if ($id == $user->id){
                    Session::set('name', $name);
                    Session::set('pwd', $pwd);
                }
                $useredit = User::find($id);
                $useredit->update_attributes(Post::getAll());
                if($useredit->is_valid()){
                    $useredit->save();
                    Redirect::toRoute('home/perfil');
                }
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }
    }

    public function perfil(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                $matches = Match::first();
                //Redirect::flashToRoute('home/inicio', ['user' => $user]);
                return View::make('home.perfil', ['user' => $user, 'matches' => $matches]);
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